<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

    public function pdfdiploma(TestSession $test_session) {
        $data = [
            'test_session' => $test_session,
            'lesson' => $test_session->lesson,
            'name' => 'Daniel Malmgren',
        ];

        $pdf = PDF::loadView('lessons.pdfdiploma', $data);

        return $pdf->download('diploma.pdf');
    }

    public function resultmail(TestSession $test_session) {

        $recipient_address = 'daniel.malmgren@itsam.se';
        $name = 'Daniel Malmgren';

        try {
            \Mail::to($recipient_address)->send(new \App\Mail\TestResult($name, $test_session->lesson));
            return redirect('/')->with('success', __('Meddelandet har skickats'));
        } catch(\Swift_TransportException $e) {
            return redirect('/')->with('error', __('Meddelandet kunde inte skickas!'));
        }

    }
}
