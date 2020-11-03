<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\TestSession;
use PDF;

class TestResultController extends Controller
{
    public function show(TestSession $test_session) {

        /*if($test_session->percent() === 100) {
            $resulttext = __('Grattis, du hade rätt på :percent% av frågorna på första försöket!', ['percent' => $test_session->percent()]);
        } elseif($test_session->percent() > 74) {
            $resulttext = __('Du hade rätt på :percent% av frågorna på första försöket!', ['percent' => $test_session->percent()]);
        } else {
            $resulttext = __('Du hade bara rätt på :percent% av frågorna på första försöket!', ['percent' => $test_session->percent()]);
        }*/

        $data = [
            'test_session' => $test_session,
            //'nextlesson' => Auth::user()->next_lesson(),
            //'resulttext' => $resulttext,
            'lesson' => $test_session->lesson,
            'percent' => $test_session->percent(),
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

        return $pdf->download('diploma.pdf');
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
