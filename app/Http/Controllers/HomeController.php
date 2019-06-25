<?php

namespace App\Http\Controllers;

use App\Board;
use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('board');
    }

    public function home()
    {
        return view('home');
    }

    public function me()
    {
        return [
            'user' => [
                'name' => Auth::user()->name,
            ],
            'teams' => Team::where('user_id', Auth::user()->id)->get(),
            'boards' => Board::where('user_id', Auth::user()->id)->get(),
        ];
    }
}
