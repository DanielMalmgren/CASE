<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poll;
use App\PollResponse;
use App\PollQuestion;
use App\PollSession;
use App\TestSession;

class PollResponseController extends Controller
{
    public function store(Request $request) {
        usleep(50000);

        if(isset($request->response)) {
            foreach($request->response as $id => $response) {
                $poll_response = PollResponse::firstOrNew([
                    'poll_question_id' => $id,
                    'poll_session_id' => session("poll_session_id"),
                ]);
                if(is_array($response)) {
                    $poll_response->response = implode(", ", $response);
                } elseif(is_null($response)) {
                    $poll_response->response = "";
                } else {
                    $poll_response->response = $response;
                }
                $poll_response->save();
            }
        }

        if($request->submit == 'previous') {
            return redirect('/pollquestion/'.$request->previous_id);
        } else {
            $question = PollQuestion::find($request->page_break_id);

            if(isset($question)) {
                $nextquestion = $question->next_question();
            }

            if(isset($nextquestion)) {
                return redirect('/pollquestion/'.$nextquestion->id);
            } else {
                $poll_session = PollSession::find($request->session()->get("poll_session_id"));
                $poll_session->finished = true;
                $poll_session->save();

                $test_session = TestSession::find($request->session()->get('test_session_id'));

                $data = [
                    'poll' => $poll_session->poll,
                    'test_session' => $test_session,
                ];

                return view('polls.feedback')->with($data);
            }
        }
    }
}
