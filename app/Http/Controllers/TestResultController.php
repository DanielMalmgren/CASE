<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\TestSession;
use PDF;

class TestResultController extends Controller
{
    public function show(TestSession $test_session, Request $request) {

        if($request->session()->get('test_session_id') != $test_session->id) {
            abort(403);
        }

        //If there is no poll attached we don't need the test session id anymore
        $poll = $test_session->lesson->poll;
        if(!isset($poll)) {
            $request->session()->forget('test_session_id');
        }
        //If an attached poll has already been answered, don't care about it any longer
        if($request->session()->pull('poll_session_id') !== null) {
            $request->session()->forget('test_session_id');
            $poll = null;
        }

        $data = [
            'test_session' => $test_session,
            'lesson' => $test_session->lesson,
            'percent' => $test_session->percent(),
            'poll' => $poll,
        ];

        return view('pages.testresult')->with($data);
    }

    public function pdfdiploma(TestSession $test_session, Request $request) {
        usleep(50000);
        $this->validate($request, [
            'name' => 'required',
        ],
        [
            'name.required' => __('Du måste ange ditt namn!'),
        ]);

        $data = [
            'test_session' => $test_session,
            'lesson' => $test_session->lesson,
            'name' => $request->name,
        ];

        $pdf = PDF::loadView('lessons.pdfdiploma', $data);

        return $pdf->download('certificate.pdf');
    }

    public function resultmail(TestSession $test_session, Request $request) {
        usleep(50000);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ],
        [
            'name.required' => __('Du måste ange ditt namn!'),
            'email.required' => __('Du måste ange din e-postadress!'),
            'email.email' => __('vänligen ange en giltig e-postadress!'),
        ]);

        $recipient_address = $request->email;
        $name = $request->name;

        try {
            \Mail::to($recipient_address)->send(new \App\Mail\TestResult($name, $test_session->lesson));
            return redirect('/')->with('success', __('Meddelandet har skickats'));
        } catch(\Swift_TransportException $e) {
            return redirect('/')->with('error', __('Meddelandet kunde inte skickas!'));
        }

    }
}
