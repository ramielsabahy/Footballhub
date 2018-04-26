<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Invitation;

class DashboardController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $received_invitations = Invitation::where('user_id', auth()->user()->id)
            ->where('status', 0)->get();
        
        $accepted_invitations = Invitation::where('user_id', auth()->user()->id)
            ->where('status', 1)->get();

        return view('dashboard')
            ->with('created_teams', auth()->user()->teams)
            ->with('received_invitations', $received_invitations)
            ->with('accepted_invitations', $accepted_invitations);
    }
}
