<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Lesson;
use App\TestSession;
use App\Country;
use App\Locale;

class FeedbackController extends Controller
{
    public function create(Request $request) {

        $lessons = Lesson::orderBy('track_id')->orderBy('order')->where('active', true)->get();

        if(strpos(url()->previous(), '/lessons/')) {
            $activelesson = substr(url()->previous(), strrpos(url()->previous(), '/')+1);
        } elseif(strpos(url()->previous(), '/test/result/')) {
            $testsession = TestSession::find(substr(url()->previous(), strrpos(url()->previous(), '/')+1));
            $activelesson = $testsession->lesson_id;
        } else {
            $activelesson = null;
        }

        $geoip = geoip()->getLocation($request->ip);
        $users_country = Country::where('name', $geoip->country)->first();

        $data = [
            'lessons' => $lessons,
            'activelesson' => $activelesson,
            'countries' => Country::all(),
            'users_country' => $users_country,
        ];

        return view('feedback.create')->with($data);
    }

    public function post(Request $request) {
        $this->validate($request, [
            'content' => 'required',
        ]);

        $name = $request->name;
        $email = $request->email;

        $country = Country::find($request->country);

        if(isset($country)) {
            $contact_env = 'CONTACT_'.strtoupper(str_replace(' ', '_', $country->name));
        } else {
            $contact_env = 'CONTACT_GENERAL';
        }

        $geoip = geoip()->getLocation($request->ip);

        $to = [];
        $to[] = ['email' => env($contact_env), 'name' => 'CASE contact'];

        \Mail::to($to)->send(new \App\Mail\Feedback($request->content, $request->lesson, $name, $email, $geoip->country, $request->contacted));

        return redirect('/')->with('success', __('Din feedback har skickats!'));
    }
}
