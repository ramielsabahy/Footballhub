<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Team;
use App\User;
use Webpatser\Uuid\Uuid;

class TeamsController extends Controller
{
    public function __construct() {
        return $this->middleware('auth', ['except' => ['createTeam', 'editTeam', 'allTeams', 'deactivateTeam', 'activateTeam', 'regenerateTeamCode', 'setTeamCode', 'getTeamById', 'getTeamsByName', 'getTeamByCode', 'allActiveTeams', 'allInActiveTeams','allActiveTeamsDT','teamPlayersDT','allTeamPlayersDT','deactivateTeamCMS']]);
    }

    public function indexActiveView(){
        return view('team.teamActiveIndex');
    }
    public function indexInActiveView(){
        return view('team.teamInactiveindex');
    }
    public function allActiveTeamsDT(Request $request){
        $data = \App\Team::get();

        return response()->json($data, 200);
    }
    public function allActiveTeams() {
        return response()->json(Team::where('active_status', '=', 1)->get(), 200);
    }

    public function allInActiveTeams() {
        return response()->json(Team::where('active_status', '=', 0)->get(), 200);
    }
    public function playersView(Request $request){
        return view('team.playersIndex');
    }
    public function teamPlayersDT(Request $request){
        $data = \App\teams_users::where('team_id',$request->id)->get();
        foreach ($data as $d) {
            if($d->status == 1){
                $d->status = "Pending";
            }
        }
        return response()->json($data, 200);
    }

    public function allTeamPlayersDT(Request $request){
        $data = \App\Team::findOrFail($request->id)->get();
        $data->load('members');
        $data->load('invitations');
        return response()->json($data, 200);
    }

   // Players Only
   // Create a team through API call
   public function createTeam(Request $request)
   {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $requestUser_id = $requestUser->id;

        // checking the user does exist
        if (!\App\User::find($requestUser_id)->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the request user is not a player
        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $requestUser_id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized (Only players have the right to create a team)";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $user_id = $requestUser_id;
        $name = request()->name;
        $code = (string) Uuid::generate(4);

        try {
            $team = Team::create([
                'name' => $name,
                'code' => $code,
                'user_id' => $user_id
            ]);
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Creating a team member (The owner of the team)
        $team_member = new \App\teams_users();
        $team_member->user_id = $requestUser_id;
        $team_member->team_id = $team->id;
        $team_member->save();

        $team->load('owner');
        $team->load('members');

        // Sending players invitations
        $id_list = request()->id_list;
        $team_id = $team->id;
        foreach ($id_list as $id)
        {
            if(\App\User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Players');
            })->where('id', '=', $id)->get()->count()) {
                $player = \App\User::find($id);
                // If record not found
                if (!\App\Invitation::where('team_id', '=', $team_id)->where('player_id', '=', $id)->get()->count()) {
                    $invitation = new \App\Invitation();
                    $invitation->team_id = $team_id;
                    $invitation->player_id = $player->id;
                    $invitation->invitation_type = 1;
                    $invitation->save();
                }
            }
        }

        // Sending phone invitations
        $phone_list = request()->phone_list;
        $team_id = $team->id;
        foreach ($phone_list as $phone_number)
        {
            // Registered player
            if (\App\User::whereHas('roles', function ($query) {
                $query->where('name', '=', 'Players');
            })->where('mobileNumber', '=', $phone_number)->get()->count())
            {
                $team_invitation = new \App\Invitation();
                $team_invitation->player_id = \App\User::where('mobileNumber', '=', $phone_number)->get()->first()->id;
                $team_invitation->team_id = $team_id;
                $team_invitation->invitation_type = 1;
                $team_invitation->save();
            }
            // Unregistered player
            if (!\App\User::where('mobileNumber', '=', $phone_number)->get()->count()) {
                if (!\App\Invitation::where('phone_number', '=', $phone_number)->where('team_id', '=', $team_id)->get()->count()) {
                    $phone_invitation = new \App\Invitation();
                    $phone_invitation->phone_number = $phone_number;
                    $phone_invitation->team_id = $team_id;
                    $phone_invitation->invitation_type = 1;
                    $phone_invitation->save();
                }
            }
        }

        // return response
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Created Successfully";
        $resp->Status = true;
        $resp->InnerData = ['team' => $team, 'registeredInvitations' => \App\Invitation::where('team_id', '=', $team_id)->whereIn('player_id', $id_list)->where('invitation_type', '=', 1)->get(), 'unregisteredInvitations' => \App\Invitation::where('team_id', '=', $team_id)->whereIn('phone_number', $phone_list)->where('invitation_type', '=', 1)->get()];
        return response()->json($resp, 200);
   }

    // Admin or Owner Method
    // Edit a team through API call
    public function editTeam(\Illuminate\Support\Facades\Request $request)
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        // If the team doesn't exist return failure
        try {
            $team = \App\Team::findOrFail(intval($request::get('id')));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Team Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (!$team->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Team Not Found, Team Has Been Deleted";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not editing his own team return unauthorized
        if ($team->user_id != $requestUser->id && !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Editing the data
        $team->name = empty($request::get('name')) ? $team->name : $request::get('name');

        try {
            $team->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $team->load('owner');
        $team->load('members');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Edited Successfully";
        $resp->Status = true;
        $resp->InnerData = $team;
        return response()->json($resp, 200);
    }

    // Authenticated Method
    // Getting all the teams
    public function allTeams(\Illuminate\Http\Request $request)
    {
        // Check that the user making the request is an admin
        $token = \JWTAuth::getToken();
        $user = \JWTAuth::toUser($token);

        if (!\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Players');
            })->where('id', '=', $user->id)->get()->count()
        ) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // $data = \App\Team::where('user_id', '=', $user->id)->get();

        $teams = collect([]);
        $user->load('memberTeams');
        foreach($user->memberTeams as $memberTeam) {
            if ($memeberTeam->active_status) {
                $memberTeam->load('team');
                $memberTeam->team->load('owner');
                $memberTeam->team->load('members');
                $teams->push($memberTeam->team);
            }
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $teams;

        return response()->json($resp, 200);
    }

    // Admin or Owner Method
    // Activate a team
    public function activateTeam(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $team = \App\Team::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not destroying his own team return unauthorized
        if ($team->user_id != $requestUser->id && !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Delete the invitations and the team
        try {
            // \App\Invitation::where('team_id', '=', $team->id)->delete();
            // $team->destroy($request::get('id'));
            $team->active_status = 0;
            $team->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Deleted Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    // Admin or Owner Method
    // Deactivate a team
    public function deactivateTeam(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $team = \App\Team::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not destroying his own team return unauthorized
        if ($team->user_id != $requestUser->id && !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Delete the invitations and the team
        try {
            // \App\Invitation::where('team_id', '=', $team->id)->delete();
            // $team->destroy($request::get('id'));
            $team->active_status = 1;
            $team->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Restored Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
    }

    public function deactivateTeamCMS(\Illuminate\Support\Facades\Request $request) 
    {

        \App\Team::where('id',$request->id)->update(['active_status' => '0']);
    }

    // Admin or Owner Method
    // API call to team code regenerate
    public function regenerateTeamCode(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $team = \App\Team::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (!$team->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found, Team Has Been Deleted';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not destroying his own team return unauthorized
        if ($team->user_id != $requestUser->id && !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Regenerate the code
        try {
            $team->code = (string) Uuid::generate(4);
            $team->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Cannot regenerate the code at the moment, kindly try again later or set it your self';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $team->load('owner');
        $team->load('members');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Code Regenerated Successfully";
        $resp->Status = true;
        $resp->InnerData = $team;
        return response()->json($resp, 200);
    }

    // Admin or Owner Method
    // API call to team code set
    public function setTeamCode(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        try {
            $team = \App\Team::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (!$team->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found, Team Has Been Deleted';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // If the user is not an admin and the player is not destroying his own team return unauthorized
        if ($team->user_id != $requestUser->id && !\App\User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'Admins');
            })->where('id', '=', $requestUser->id)->get()->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Unauthorized";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        // Regenerate the code
        try {
            $team->code = empty($request::get('code')) ? $team->code : $request::get('code');
            $team->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Code already exist, please choose another code';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $team->load('owner');
        $team->load('members');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Team Code Has Been Set Successfully";
        $resp->Status = true;
        $resp->InnerData = $team;
        return response()->json($resp, 200);
    }

    // All Method
    // API call to get a team by id
    public function getTeamById(\Illuminate\Support\Facades\Request $request) 
    {
        // Getting the request user
        $token = \JWTAuth::getToken();
        $requestUser = \JWTAuth::toUser($token);

        $requestUser_id = $requestUser->id;

        // checking the user does exist
        if (!\App\User::find($requestUser_id)->count()) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "User doesn't exist";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        try {
            $team = \App\Team::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'No Team Found With This Id';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if (!$team->active_status) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'No Team Found With This Id, Team Has Been Deleted';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $team->load('owner');
        $team->load('members');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $team;
        return response()->json($resp, 200);
    }

    // All Method
    // API call to get teams by name
    public function getTeamsByName(\Illuminate\Support\Facades\Request $request) 
    {
        try {
            $teams = \App\Team::all()->where('name', $request::get('name'))->where('active_status', '=', 1);
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'No Team(s) Found With This Name';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $teams->load('owner');
        $teams->load('members');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retreived Successfully";
        $resp->Status = true;
        $resp->InnerData = $teams;
        return response()->json($resp, 200);
    }

    // All Method
    // API call to get a team by code
    public function getTeamByCode(\Illuminate\Support\Facades\Request $request) 
    {
        try {
            $team = \App\Team::where('code', $request::get('code'))->where('active_status', '=', 1);
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Team Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        if ($team->count()) {
            $team = $team->first();
            $team->load('owner');
            $team->load('members');

            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Retreived Successfully";
            $resp->Status = true;
            $resp->InnerData = $team;
            return response()->json($resp, 200);
        }
        else {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Team Not Found";
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
    }
}
