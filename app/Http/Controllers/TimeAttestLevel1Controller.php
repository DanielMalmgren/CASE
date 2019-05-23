<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TimeAttest;
use App\ClosedMonth;

class TimeAttestLevel1Controller extends Controller
{
    public function store(Request $request) {
        usleep(50000);

        $this->validate($request, [
            'month' => 'required',
            'year' => 'required',
            'attest' => 'required',
        ]);

        $user = Auth::user();

        $time_attest = new TimeAttest();
        $time_attest->year = $request->year;
        $time_attest->month = $request->month;
        $time_attest->user_id = $user->id;
        $time_attest->attestant_id = $user->id;
        $time_attest->attestlevel = 1;
        $time_attest->hours = $request->hours;
        $time_attest->clientip = $request->ip();
        $time_attest->authnissuer = session('authnissuer');
        $time_attest->save();

        return redirect('/')->with('success', 'Attesteringen har sparats');
    }

    public function create() {
        $user = Auth::user();
        setlocale(LC_TIME, $user->locale_id);

        if(ClosedMonth::all()->where('month', date("m", strtotime("first day of previous month")))->where('year', date("Y", strtotime("first day of previous month")))->isNotEmpty()) {
            $month_is_closed = true;
        } else {
            $month_is_closed = false;
        }

        $year = date('Y', strtotime("first day of previous month"));
        $month = date('n', strtotime("first day of previous month"));
        $monthstr = strftime('%B', strtotime("first day of previous month"));

        $time_rows = $user->time_rows($year, $month);

        $data = [
            'time_rows' => $time_rows,
            'year' => $year,
            'month' => $month,
            'monthstr' => $monthstr,
            'days_in_month' => cal_days_in_month(CAL_GREGORIAN, $month, $year),
            'already_attested' => $user->time_attests->where('attestlevel', 1)->where('month', $month)->where('year', $year)->isNotEmpty(),
            'month_is_closed' => $month_is_closed,
        ];

        return view('timeattestlevel1.create')->with($data);
    }
}
