<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Locale;
use App\Track;
use App\Municipality;
use App\Workplace;
use App\User;
use App\Title;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function edit(?User $user = null): View {
        if(! $user) {
            $user = Auth::user();
        }

        if($user != Auth::user() && ! Auth::user()->hasRole('Admin') && (! isset($user->workplace) || ! $user->workplace->workplace_admins->contains('id', Auth::user()->id))) {
            abort(403);
        }

        if($user->can('list all lessons')) {
            $tracks = Track::orderBy('order')->get();
        } else {
            $tracks = Track::where('active', 1)->orderBy('order')->get();
        }

        $data = [
            'municipalities' => Municipality::orderBy('name')->get(),
            'workplaces' => Workplace::orderBy('name')->get(),
            'user' => $user,
            'locales' => Locale::All(),
            'titles' => Title::All(),
            'tracks' => $tracks,
        ];

        return view('pages.settings')->with($data);
    }

    public function storeLanguage(Request $request): RedirectResponse {

        $this->validate($request, [
            'locale' => 'required',
        ]);

        $user = $request->user();
        $user->locale_id = $request->input('locale');
        $user->save();

        return redirect('/settings');
    }

    public function store(Request $request, User $user): RedirectResponse {
        if($user != Auth::user() && ! Auth::user()->hasRole('Admin') && (! isset($user->workplace) || ! $user->workplace->workplace_admins->contains('id', Auth::user()->id))) {
            abort(403);
        }

        usleep(50000);
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$user->id,
        ],
        [
            'email.required' => __('Du måste ange din e-postadress!'),
            'email.unique' => __('E-postadressen du har angett finns registrerad på en annan användare!'),
            'email.email' => __('vänligen ange en giltig e-postadress!'),
        ]);

        $user->email = $request->input('email');
        $user->locale_id = $request->input('locale');
        $user->save();

        $user->assignRole('Registrerad');

        return redirect('/')->with('success', __('Inställningarna sparade'));
    }
}
