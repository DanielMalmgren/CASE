<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Track;
use App\Locale;
use App\Color;
use App\Country;
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

    public function show(Request $request, Track $track) {
        if(Auth::user() !== null && Auth::user()->can('manage lessons')) {
            $lessons = $track->lessons->sortBy('order');
        } else {
            $geoip = geoip()->getLocation($request->ip);
            $country = Country::where('name', $geoip->country)->first();
            if($country !== null) {
                $country_id = $country->id;
            } else {
                $country_id = -1; //Country didn't match any country in our list
            }

            $lessons = $track->lessons()->where('active', true)
                ->where(static function ($query) use ($country_id) {
                    $query->whereHas('countries', static function ($query) use ($country_id) {
                        $query->where('id', $country_id);
                    })
                ->orWhere('limited_by_country', false);
                })
                ->orderBy('order')->get();
        }

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
            'colors' => Color::all(),
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
            'colors' => Color::all(),
        ];
        return view('tracks.edit')->with($data);
    }

    public function update(Request $request, Track $track) {
        usleep(50000);
        $this->validate($request, [
            'name' => 'required',
            'id' => 'integer|min:0',
            'color' => 'exists:colors,hex',
            'icon' => 'image|max:2000',
        ],
        [
            'name.required' => __('Du måste ange ett namn på spåret!'),
            'id.integer' => __('Du måste ange ett positivt nummer för spåret!'),
            'id.min' => __('Du måste ange ett positivt nummer för spåret!'),
            'color.exists' => __('Du måste välja en av de förvalda färgerna!'),
            'icon.image' => __('Felaktigt bildformat!'),
            'icon.max' => __('Din fil är för stor! Max-storleken är 2MB!'),
        ]);

        $currentLocale = \App::getLocale();
        $user = Auth::user();
        logger("Track ".$track->id." is being edited by ".$user->name);

        $color = Color::where('hex', $request->color)->first();
        $track->color_id = $color->id;

        if(isset($request->icon)) {
            $track->icon = basename($request->icon->store('public/icons'));
        }

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
