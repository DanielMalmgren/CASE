<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Announcement;
use App\ClosedMonth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request) {
        $announcements = Announcement::All()->sort()->reverse()->take(5);

        $data = [
            'announcements' => $announcements,
        ];
        return view('pages.index')->with($data);
    }

    public function about(): View {
        return view('pages.about');
    }

    public function logout(): View {
        session()->flush();
        Auth::logout();
        return view('pages.logout');
    }
}
