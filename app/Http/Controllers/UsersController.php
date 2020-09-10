<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Locale;
use App\Exports\UsersExport;

class UsersController extends Controller
{
    public function show(User $user) {
        if($user != Auth::user() && ! Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $data = array(
            'user' => $user,
        );

        return view('users.show')->with($data);
    }

    public function edit(User $user) {
        if($user != Auth::user() && ! Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $data = array(
            'user' => $user,
            'locales' => Locale::All(),
        );

        return view('users.edit')->with($data);
    }

    public function index() {
        return view('users.index');
    }

    //Return a json containing users matching a search string sent from a select2 object. See https://select2.org/data-sources/ajax
    public function select2(Request $request) {
        $users = User::where('name', 'like', '%'.$request->q.'%')->orWhere('email', 'like', '%'.$request->q.'%')->get();

        $results = ['results' => []];

        foreach($users as $key => $user) {
            $results['results'][$key] = [
                'id' => $user->id,
                'text' => $user->name.' ('.$user->email.')',
            ];
        }

        return $results;
    }

    //The following function will not really delete a user, just remove it from the workplace
    public function destroy(User $user) {
        $user->workplace_id = null;
        $user->save();
    }

    private static function randomPassword() {
        $alphabet = 'abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 10; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function create() {
        $password = $this->randomPassword();
        $data = [
            'password' => $password,
            'locales' => Locale::All(),
        ];
        return view('users.create')->with($data);
    }

    public function store(Request $request) {
        usleep(50000);

        $this->validate($request, [
            'firstname' => 'required|string|between:2,255',
            'lastname' => 'required|string|between:2,255',
            'email' => 'required|string|email|unique:users',
            'pwd_cleartext' => 'required|string|between:8,255',
        ],
        [
            'firstname.required' => __('Du måste ange ett förnamn!'),
            'firstname.string' => __('Du måste ange ett förnamn!'),
            'firstname.between' => __('Du måste ange ett förnamn!'),
            'lastname.required' => __('Du måste ange ett efternamn!'),
            'lastname.string' => __('Du måste ange ett efternamn!'),
            'lastname.between' => __('Du måste ange ett efternamn!'),
            'email.required' => __('Du måste ange en e-postadress!'),
            'email.string' => __('Du måste ange en e-postadress!'),
            'email.email' => __('Du måste ange en e-postadress!'),
            'email.unique' => __('En användare med denna e-postadress finns redan registrerad!'),
            'pwd_cleartext.required' => __('Du måste ange ett lösenord!'),
            'pwd_cleartext.string' => __('Du måste ange ett lösenord!'),
            'pwd_cleartext.between' => __('Lösenordet du anger måste vara minst 8 tecken!'),
        ]);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->name = $request->firstname.' '.$request->lastname;
        $user->locale_id = $request->input('locale');
        $user->email = $request->email;
        $user->password = Hash::make($request->pwd_cleartext);
        $user->save();

        if($request->lesson_editor) {
            $user->assignRole('lesson_editor');
        } else {
            $user->removeRole('lesson_editor');
        }

        return redirect('/')->with('success', __('Användaren har skapats'));
    }

    public function update(Request $request, User $user) {
        usleep(50000);

        $this->validate($request, [
            'firstname' => 'required|string|between:2,255',
            'lastname' => 'required|string|between:2,255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ],
        [
            'firstname.required' => __('Du måste ange ett förnamn!'),
            'firstname.string' => __('Du måste ange ett förnamn!'),
            'firstname.between' => __('Du måste ange ett förnamn!'),
            'lastname.required' => __('Du måste ange ett efternamn!'),
            'lastname.string' => __('Du måste ange ett efternamn!'),
            'lastname.between' => __('Du måste ange ett efternamn!'),
            'email.required' => __('Du måste ange en e-postadress!'),
            'email.string' => __('Du måste ange en e-postadress!'),
            'email.email' => __('Du måste ange en e-postadress!'),
            'email.unique' => __('En användare med denna e-postadress finns redan registrerad!'),
        ]);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->name = $request->firstname.' '.$request->lastname;
        $user->locale_id = $request->input('locale');
        $user->email = $request->email;
        $user->save();

        if($request->lesson_editor) {
            $user->assignRole('lesson_editor');
        } else {
            $user->removeRole('lesson_editor');
        }

        return redirect('/')->with('success', __('Användaren har sparats'));
    }
}
