<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;
class CompetitionRoundsController extends Controller
{
    public function roundsByCompetition($id)
    {
    	try {
            $obj = \App\Models\CompetitionRound::where('CompetitionId', '=', $id)->get();
            $obj->load('CompetitionSeasonMatches');
            $obj->load('Competition');
            $obj->load('Round');
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

    protected function insertionSort(array $array) {
        $count = count($array);
        for($i = 1; $i < $count; $i ++) {

            $j = $i - 1;
            // second element of the array
            $element = $array[$i];
            while ( $j >= 0 && $array[$j] > $element ) {
                $array[$j + 1] = $array[$j];
                $array[$j] = $element;
                $j = $j - 1;
            }
        }
        return $array;
    }

    public function getRound(\Illuminate\Support\Facades\Request $request){
        $last = \App\Models\CompetitionSeasonMatch::where('CompetitionSeasonId', '=', 7)->orderBy('CompetitionRoundId', 'desc')->first();
        $roundId = $last->CompetitionRoundId;
        $roundMatches = \App\Models\CompetitionSeasonMatch::where([ 'CompetitionSeasonId' => 7 ,'CompetitionRoundId' => $roundId])->get();
        $roundMatches->load('CompetitionSeasonGroup');
        $canStartRound = true;
        $winners = array();
        $counter = 0;
        $groups  = array();
        $dataObject = [];
        foreach ($roundMatches as $team) {
            if($team->Status != 3){
                $canStartRound = false;
                break;
            }
        }
        if($canStartRound){
            foreach ($roundMatches as $winner) {
                // $winners[$counter] = $winner->winner_id;
                // $groups[$counter] = $roundMatches[0]['CompetitionSeasonGroup']['Id'];
                try {
                    array_push($dataObject[$roundMatches[0]['CompetitionSeasonGroup']['Id']], $winner->winner_id);
                } catch(\Exception $e) {
                    $dataObject[$roundMatches[0]['CompetitionSeasonGroup']['Id']] = [];
                    array_push($dataObject[$roundMatches[0]['CompetitionSeasonGroup']['Id']], $winner->winner_id);
                }
                $counter++;
            }
            
        }else{
            foreach ($roundMatches as $winner) {
                // $winners[$counter] = $winner->winner_id;
                // $groups[$counter] = $roundMatches[0]['CompetitionSeasonGroup']['Id'];
                try {
                    array_push($dataObject[$roundMatches[0]['CompetitionSeasonGroup']['Id']], $winner->winner_id);
                } catch(\Exception $e) {
                    $dataObject[$roundMatches[0]['CompetitionSeasonGroup']['Id']] = [];
                    array_push($dataObject[$roundMatches[0]['CompetitionSeasonGroup']['Id']], $winner->winner_id);
                }
                $counter++;
            }
            ksort($dataObject);
            foreach ($dataObject as $count => $data) {
                $dataObject[$count] = $this->insertionSort($data);
                // $team = \App\Team::where('id',$data)->get();
                // \App\MatchMapTeam::where('competition_season_id', $count);
            }
            
            
        }
        return response()->json($dataObject,200);
    }
}