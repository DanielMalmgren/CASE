<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Track;
use App\Locale;
use PDF;

class TrackController extends Controller
{
    public function index(Request $request) {
        $tracks = Track::orderBy('order')->get();

        $data = [
            'tracks' => $tracks,
        ];
        return view('tracks.index')->with($data);
    }

    public function show(Track $track) {
        $lessons = $track->lessons->sortBy('order');
        $data = [
            'track' => $track,
            'lessons' => $lessons,
        ];
        return view('tracks.show')->with($data);
    }

    public function reorder(Request $request) {
        parse_str($request->data, $data);
        $ids = $data['id'];

        foreach($ids as $order => $id){
            $track = Track::findOrFail($id);
            $track->order = $order+1;
            $track->save();
        }
    }

    public function create() {
        $data = [
            'locales' => Locale::orderBy('name')->get(),
        ];
        return view('tracks.create')->with($data);
    }

    public function store(Request $request) {
        usleep(50000);
        $this->validate($request, [
            'name' => 'required',
        ],
        [
            'name.required' => __('Du måste ange ett namn på spåret!'),
        ]);

        $track = new Track();
        $track->id = Track::max('id')+1;
        $track->default_locale_id = $request->locale;
        $track->save();

        return $this->update($request, $track);
    }

    public function edit(Track $track) {
        $data = [
            'track' => $track,
            'locales' => Locale::orderBy('name')->get(),
        ];
        return view('tracks.edit')->with($data);
    }

    public function update(Request $request, Track $track) {
        usleep(50000);
        $this->validate($request, [
            'name' => 'required',
            'id' => 'integer|min:0',
        ],
        [
            'name.required' => __('Du måste ange ett namn på spåret!'),
            'id.integer' => __('Du måste ange ett positivt nummer för spåret!'),
            'id.min' => __('Du måste ange ett positivt nummer för spåret!'),
        ]);

        $currentLocale = \App::getLocale();
        $user = Auth::user();
        logger("Track ".$track->id." is being edited by ".$user->name);

        $track->translateOrNew($currentLocale)->name = $request->name;
        $track->translateOrNew($currentLocale)->subtitle = $request->subtitle;
        $track->active = $request->active;
        $track->save();

        return redirect('/tracks/'.$track->id)->with('success', __('Ändringar sparade'));
    }

    public function pdfdiploma(Track $track) {
        $user = Auth::user();

        $lessons = $track->lessons()->finished()->where('active', true)
            ->orderBy('order')->get();

        $data = [
            'track' => $track,
            'lessons' => $lessons,
            'user' => $user,
        ];

        $pdf = PDF::loadView('tracks.pdfdiploma', $data);

        return $pdf->download('diploma.pdf');
    }
}
