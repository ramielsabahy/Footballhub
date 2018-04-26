<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CompetitionsController extends Controller
{

    public function index()
    {
        return view('competitions.index');
    }

    public function show($id) {
        try {
            $competition = \App\Models\Competition::findOrFail($id);
        } catch(\Exception $e) {
            return redirect('/')->with('error', 'competition doesn\'t exist');
        }
        $competition->load('competitionSeasons');
       $competition->competitionSeasons->load('CompetitionSeasonGroups');
        // $competitions = \App\Models\Competition::all();
        return view('competitions.show')
                    ->with('competition', $competition);
    }



    public function allCompetitionsDT()
    {
        $competitions = \App\Models\Competition::all();
        return response()->json($competitions, 200);
    }

    public function allCompetitions()
    {
        try {
            $obj = \App\Models\Competition::all();
            $obj->load('competitionSeasons');
            $obj->load('competitionRounds');
            //$obj->competition_seasons->load('CompetitionSeasonGroups');
        } catch(\Exception $e) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = "Failure";
                $resp->Status = true;
                //$resp->InnerData = $e.getMessage();
                return response()->json($resp, 200);
            }

        $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Success";
            $resp->Status = true;
            $resp->InnerData = $obj;
            return response()->json($obj, 200);
    }

    public function getGroupById(\Illuminate\Support\Facades\Request $request)
    {
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Group Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = \App\Models\CompetitionSeasonGroup::find($request::get('id'));
        return response()->json($resp, 200);
    }

    public function allCompetitionSeasonGroupsDT()
    {
        $groups = \App\Models\CompetitionSeasonGroup::all();
        return response()->json($groups, 200);
    }

    public function AddGroups(\Illuminate\Support\Facades\Request $request)
    {
        $Season = \App\Models\CompetitionSeasonGroup::create([
            'CompetitionSeasonId' => $request::get('CompetitionSeasonId'),
            'Name' => $request::get('Name'),
            'Rank' => $request::get('Rank')
        ]); 

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Competition Season Group Created Successfully";
        $resp->Status = true;
        $resp->InnerData = $Season;
        return response()->json($resp, 200); 
    }

    public function GetTeams(\Illuminate\Support\Facades\Request $request)
    {
        try {
        $selected = collect([]);

        $count = $request::get('count');
        $teams_list = $request::get('teams_list');
        $teams = \App\Team::whereNotIn('name', $teams_list)->get();
        foreach($teams as $team) 
        {
            $team->load('members');
            if ($count == 5) {
                if ($team->members->count() >= 5 && $team->members->count() <= 8) {
                    $selected->push($team);
                }
            }
            else if ($count == 7) {
                if ($team->members->count() >= 7 && $team->members->count() <= 11) {
                    $selected->push($team); 
                }
            }
            else if ($count == 11) {
                if ($team->members->count() >= 11 && $team->members->count() <=18) {
                    $selected->push($team); 
                }
            }
        }
        return response()->json($selected, 200);
        }catch(\Exception $e) {
            return response()->json($e->getMessage(), 200);
        }              
    }

    public function CreateCompetitionSeason(\Illuminate\Support\Facades\Request $request)
    {
        $LogoUrl = $request::get('LogoUrl');
        if ($LogoUrl) {
            // Uploaded photo
            $img = Image::make($LogoUrl);
            $data = $LogoUrl;
            $type = explode(';', $data)[0];
            $extension = explode('/', $type)[1];
            $filenameToStore = 'logo_'.time().'.'.$extension;
            $img->save(public_path('storage/logos/'.$filenameToStore));
            $filenameToStore = '/storage/logos/'.$filenameToStore;
        }
        else {
            $filenameToStore = '/storage/logos/no_image.jpg';
        }
        $competition = \App\Models\Competition::create([
            'Name' => $request::get('Name'),
            'ArName' => $request::get('ArName'),
            'LogoUrl' => $request::get('LogoUrl'),
            'CompetitionTypeId' => $request::get('CompetitionTypeId'),
            'NumberOfTeams' => $request::get('NumberOfTeams'),
            'YellowCardsToSuspend' => $request::get('YellowCardsToSuspend'),
        ]);
        $competitionSeason = \App\Models\CompetitionSeason::create([
            'CompetitionId' => $competition->Id,
            'Season' => $request::get('Season'),
            'StartDate' => $request::get('StartDate'),
            'EndDate' => $request::get('EndDate'),
            'YellowCardsToSuspend' => $request::get('YellowCardsToSuspend'),
            'NumberOfTeams' => $request::get('NumberOfTeams'),
            'NumberOfGroups' => $request::get('NumberOfGroups'),
            'Status' => $request::get('Status')  
        ]);

        $competition->load('competitionSeasons');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $competition;
        return response()->json($resp, 200); 
    }

    public function AddSeasons(\Illuminate\Support\Facades\Request $request)
    {
        $Season = \App\Models\CompetitionSeason::create([
            'CompetitionId' => $request::get('competition_id'),
            'Season' => $request::get('Season'),
            'StartDate' => $request::get('StartDate'),
            'EndDate' => $request::get('EndDate'),
            'YellowCardsToSuspend' => $request::get('YellowCardsToSuspend'),
            'NumberOfTeams' => $request::get('NumberOfTeams'),
            'NumberOfGroups' => $request::get('NumberOfGroups'),
            'Status' => $request::get('Status')
        ]); 

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Competition Seasons Created Successfully";
        $resp->Status = true;
        $resp->InnerData = $Season;
        return response()->json($resp, 200); 

    }

    public function allCompetitionSeasons($id)
    {
        $competition = \App\Models\Competition::findOrFail($id);
        $competition->load('competitionSeasons');

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $competition;
        return response()->json($resp, 200);    
    }

    public function EditCompetitonSeason(\Illuminate\Support\Facades\Request $request)
    {
        try{
            $competition_id = \App\Models\Competition::findOrFail($request::get('competition_id'));
        } catch(\Exception $e){
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }

        
        try{
            $competition_season_id = \App\Models\CompetitionSeason::findOrFail($request::get('competition_season_id'));
        } catch(\Exception $e){
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }

        if ($competition_season_id->CompetitionId != $competition_id) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "competition_season_id is not the Same As competition_id ";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }

        $competition_id->name = $request::get('league_name');
        $competition_id->ArName = $request::get('ArName');
        $competition_id->LogoUrl = $request::get('LogoUrl');
        $competition_id->CompetitionTypeId = $request::get('CompetitionTypeId');
        $competition_id->NumberOfTeams = $request::get('NumberOfTeams');
        $competition_id->YellowCardsToSuspend = $request::get('YellowCardsToSuspend');

        $competition_id->name = empty($name) ? $user->name : $name;
        $competition_id->ArName = empty($ArName) ? $user->ArName : $ArName;
        $competition_id->LogoUrl = empty($LogoUrl) ? $user->LogoUrl : $LogoUrl;
        $competition_id->CompetitionTypeId = empty($CompetitionTypeId) ? $user->CompetitionTypeId : $CompetitionTypeId;
        $competition_id->NumberOfTeams = empty($NumberOfTeams) ? $user->NumberOfTeams : $NumberOfTeams;
        $competition_id->YellowCardsToSuspend = empty($YellowCardsToSuspend) ? $user->YellowCardsToSuspend : $YellowCardsToSuspend;

        try {
            $competiton_id->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $competition_season_id = $competition_id;
        $competition_season_id->Season = $request::get('Season');
        $competition_season_id->StartDate = $request::get('StartDate');
        $competition_season_id->EndDate = $request::get('EndDate');
        $competition_season_id->YellowCardsToSuspend = $request::get('YellowCardsToSuspend');
        $competition_season_id->NumberOfTeams = $request::get('NumberOfTeams');
        $competition_season_id->NumberOfGroups = $request::get('NumberOfGroups');
        $competition_season_id->Status = $request::get('Status');

        $competition_season_id->Season = empty($Season) ? $user->Season : $Season;
        $competition_season_id->StartDate = empty($StartDate) ? $user->StartDate : $StartDate;
        $competition_season_id->EndDate = empty($EndDate) ? $user->EndDate : $EndDate;
        $competition_season_id->YellowCardsToSuspend = empty($YellowCardsToSuspend) ? $user->YellowCardsToSuspend : $YellowCardsToSuspend;
        $competition_season_id->NumberOfTeams = empty($NumberOfTeams) ? $user->NumberOfTeams : $NumberOfTeams;
        $competition_season_id->NumberOfGroups = empty($NumberOfGroups) ? $user->NumberOfGroups : $NumberOfGroups;
        $competition_season_id->Status = empty($Status) ? $user->Status : $Status;
        try {
            $competition_season_id->save();
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = $e->getMessage();
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

        $competiton_id->load('competitionSeasons');


        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "CompetitionSeason Edited Successfully";
        $resp->Status = true;
        $resp->InnerData = $competiton_id;
        return response()->json($resp, 200); 
    }

    public function CreateGroupsGroupsTeams(\Illuminate\Support\Facades\Request $request)
    {   
        // Create Groups and its teams also create the matchs for each team in the round .
        $competition_season_id = $request::get('competition_season_id');
        $competiton_id = $request::get('competiton_id');
        $groups = $request::get('groups');

        foreach($groups as $group) {
            $competition_group = \App\Models\CompetitionSeasonGroup::create([
                'CompetitionSeasonId' => $competition_season_id,
                'Name' => $group['Name'],
                'Rank' => 0
            ]);
            foreach ($group['teams'] as $team) {
                $competition_season_team = new \App\Models\CompetitionSeasonTeam;
                $competition_season_team->CompetitionSeasonId = $competition_season_id;
                $competition_season_team->TeamId = $team['TeamId'];
                $competition_season_team->GoalsScored = 0;
                $competition_season_team->GoalsConceded = 0;
                $competition_season_team->Won = 0;
                $competition_season_team->Lost = 0;
                $competition_season_team->Tie = 0;
                $competition_season_team->PositionInCompetition = 0;
                $competition_season_team->CompetitionSeasonGroupId = $competition_group['Id'];
                $competition_season_team->save();
            }
            for($i = 0; $i < count($group['teams']); $i++) {
                for($j = $i; $j < count($group['teams']); $j++) {
                    $match = \App\Models\CompetitionSeasonMatch::create([
                    'CompetitionSeasonId' => $competition_season_id,
                    'CompetitionSeasonGroupId' => $competition_group['Id'],
                    'CompetitionRoundId' => '1',
                    'HomeTeamId' => $group['teams'][$i]['TeamId'],
                    'VisitorTeamId' => $group['teams'][$j]['TeamId'],
                    // 'StartDate' => ,
                    'HomeGoals' => 0,
                    'VisitorGoals' => 0,
                    'HomePenalties' => 0,
                    'VisitorPenalties' => 0,
                    'Status' => 1
                    // 'StadiumId' =>
                    // 'MainRefreeId' =>
                    // 'AsstRefreeId' =>
                ]);   
                }
            }

        }
        $competition_season = \App\Models\CompetitionSeason::find($competition_season_id);
        $competition_season->load('Competition');
        $competition_season->load('CompetitionSeasonGroups');
        $competition_season->CompetitionSeasonGroups->load('CompetitionSeasonTeams');
        $competition_season->load('competitionSeasonMatches');
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $competition_season;
        return response()->json($resp, 200); 
    }
    
    //Last Stand Who Will Win
    public function matchMapTeams(\Illuminate\Support\Facades\Request $request)
    {
        $competition_season_id = $request::get('competition_season_id');
        $competition_round_id = $request::get('competition_round_id');
        $competiton_id = $request::get('competiton_id');
        $matches = $request::get('matches');
        // Count Number of matches to assign the right round to it as for 
        // 4 matches round id = 2 && for 8 matches round id = 3
        
        foreach ($matches as $team) {
            $teamArr = str_split($team);
            foreach ($teamArr as $teamChar) 
            {
                $match_map_team = \App\MatchMapTeam::create([
                    'competition_season_id' => $competition_season_id ,
                    'competition_round_id' => $competition_round_id ,
                    'group_A' => $teamArr[0] , 
                    'team_A' => $teamArr[1],
                    'group_B' => $teamArr[2],
                    'team_B' => $teamArr[3]
                ]);
            }
        }
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = \App\MatchMapTeam::where('competition_season_id', '=', $competition_season_id)->get();
        return response()->json($resp, 200);
    }

    public function EditGroupsGroupsTeams(Illuminate\Support\Facades\Request $request)
    {

        try{
            $competition_id = \App\Models\Competition::findOrFail($request::get('competition_id'));
        } catch(\Exception $e){
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }

        try{
            $competition_season_id = \App\Models\CompetitionSeason::findOrFail($request::get('competition_season_id'));
        } catch(\Exception $e){
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }

        try{
            $groups = \App\Models\CompetitionSeasonGroup::findOrFail($request::get('groups'));
        } catch(\Exception $e){
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }


        if ($competition_season_id->CompetitionId != $competition_id) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "competition_season_id is not the Same As competition_id ";
            $resp->Status = false;
            $resp->InnerData = $competition;
            return response()->json($resp, 200);
        }


        foreach($groups as $group) {
            $competition_group = \App\Models\CompetitionSeasonGroup::update([
                'CompetitionSeasonId' => $competition_season_id,
                'Name' => $group['Name'],
                'Rank' => 0
            ]);
        try{
            foreach ($group['teams'] as $team) {
                $competition_season_team = \App\Models\CompetitionSeasonTeam::update([
                    'CompetitionSeasonId' => $competition_season_id,
                    'TeamId' => $team['TeamId'],
                    'GoalsScored' => 0,
                    'GoalsConceded' => 0,
                    'Won' => 0,
                    'Lost' => 0,
                    'Tie' => 0,
                    'PositionInCompetition' => 0,
                    'CompetitionSeasonGroupId' => $competition_group['Id']
                ]);
                // $competition_season_team = new \App\Models\CompetitionSeasonTeam;
                // $competition_season_team->CompetitionSeasonId = $competition_season_id;
                // $competition_season_team->TeamId = $team['TeamId'];
                // $competition_season_team->GoalsScored = 0;
                // $competition_season_team->GoalsConceded = 0;
                // $competition_season_team->Won = 0;
                // $competition_season_team->Lost = 0;
                // $competition_season_team->Tie = 0;
                // $competition_season_team->PositionInCompetition = 0;
                // $competition_season_team->CompetitionSeasonGroupId = $competition_group['Id'];
                // $competition_season_team->save();
                
            }
        }catch (Exception $e){
            return response()->json($e->getMessage(), 200);
        }

        }
        $competition_season = \App\Models\CompetitionSeason::find($competition_season_id);
        $competition_season->load('Competition');
        $competition_season->load('CompetitionSeasonGroups');
        $competition_season->CompetitionSeasonGroups->load('CompetitionSeasonTeams');
        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Retrieved Successfully";
        $resp->Status = true;
        $resp->InnerData = $competition_season;
        return response()->json($resp, 200); 
    }

    public function deleteGroupTeam(\Illuminate\Support\Facades\Request $request)
    {
        try {
            $competition_season_team = \App\CompetitionSeasonTeam::findOrFail($request::get('id'));
        }
        catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Competition Season Group Team Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }

    }

    public function deleteGroup(\Illuminate\Support\Facades\Request $request)
    {
        try {
            $competiton_season_group = \App\CompetitionSeasonGroups::findOrFail($request::get('id'));
        } catch (Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Competiton Season Group Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json( $resp , 200 );
        }
    }

    public function deleteSeason(\Illuminate\Support\Facades\Request $request)
    {
        try {
            $competition_season = \App\ComeptitionSeason::findOrFail($request::get('id'));
        } catch (Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = 'Competiton Season  Not Found';
            $resp->Status = false;
            $resp->InnerData = (object)[];
            return response()->json( $resp , 200 );        }
    }



}
