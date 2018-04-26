<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
class CompetitionSeasonMatchesController extends Controller
{
    public function matchesBySeason($id)
    {
    	try {
            $obj = \App\Models\CompetitionSeasonMatch::where('CompetitionSeasonId', '=', $id)->get();
            $obj->load('CompetitionSeason');
            $obj->load('CompetitionSeasonGroup');
            $obj->load('CompetitionRound');
            $obj->load('HomeTeam');
            $obj->load('VisitorTeam');
            $obj->load('LineUp');
            $obj->load('Goals');
            $obj->load('Cards');
            $obj->load('Subs');
            $obj->load('Activities');
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
    
    public function matchesByRound($id)
    {
    	try {
            $obj = \App\Models\CompetitionSeasonMatch::where('CompetitionRoundId', '=', $id)->get();
            $obj->load('CompetitionSeason');
            $obj->load('CompetitionSeasonGroup');
            $obj->load('CompetitionRound');
            $obj->load('HomeTeam');
            $obj->load('VisitorTeam');
            $obj->load('LineUp');
            $obj->load('Goals');
            $obj->load('Cards');
            $obj->load('Subs');
            $obj->load('Activities');
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
    
    public function matchesBySeasonAndGroup($id, $id2)
    {
        //return $id2;
    	try {
            $obj = \App\Models\CompetitionSeasonMatch::where('CompetitionSeasonId', '=', $id)
                    ->where('CompetitionSeasonGroupId', '=', $id2)->get();
            $obj->load('CompetitionSeason');
            $obj->load('CompetitionSeasonGroup');
            $obj->load('CompetitionRound');
            $obj->load('HomeTeam');
            $obj->load('VisitorTeam');
            $obj->load('LineUp');
            $obj->load('Goals');
            $obj->load('Cards');
            $obj->load('Subs');
            $obj->load('Activities');
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
}