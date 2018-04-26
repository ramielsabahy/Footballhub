<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

class CompetitionSeasonTeamsController extends Controller
{
    public function teamsByGroup($id)
    {
        try {
            $obj = \App\Models\CompetitionSeasonTeam::where('CompetitionSeasonGroupId', '=', $id)->get();
            $obj->load('CompetitionSeason');
            $obj->load('CompeitionSeasonGroup');
            $obj->load('Team');
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
    
    public function teamsBySeason($id)
    {
        try {
            $obj = \App\Models\CompetitionSeasonTeam::where('CompetitionSeasonId', '=', $id)->get();
            $obj->load('CompetitionSeason');
            $obj->load('CompeitionSeasonGroup');
            $obj->load('Team');
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