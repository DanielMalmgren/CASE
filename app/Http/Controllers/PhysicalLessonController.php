<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Workplace;

class PhysicalLessonController extends Controller
{
    public function create(Request $request) {
        $workplaces = Workplace::all();
        $data = array(
            'workplaces' => $workplaces
        );
        return view('physicallesson.create')->with($data);
    }

    public function ajax(Workplace $workplace) {
        $data = array(
            'workplace' => $workplace
        );
        return view('physicallesson.ajax')->with($data);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'time' => 'required',
            'workplace_id' => 'required'
        ]);

        $workplace = Workplace::find($request->workplace_id);

        $parsedtime = date_parse($request->time);
        $minutes = date_parse($request->time)['hour']*60 + date_parse($request->time)['minute'];
        logger("Registrerar en lektion för ".$workplace->name.", antal minuter: ".$minutes);

        /*$workplace = new Workplace;
        $workplace->name = $request->name;
        $workplace->workplace_type_id = $request->workplace_type;
        $workplace->municipality_id = $request->municipality;
        $workplace->save();
        $workplace->tracks()->sync($request->tracks);*/

        return redirect('/physicallesson/create')->with('success', 'Lektionen har sparats');
    }

}
