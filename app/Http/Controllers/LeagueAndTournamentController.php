<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class LeagueAndTournamentController extends Controller
{

    public function index(){
        return view('league.main');
    }


    // public function index(){
    // 	return view('league.league');
    // }
    // public function search(Request $request){
    // 	$output = "";
    // 	if($request->ajax()){
    // 		$teams = Team::where('name','LIKE','%'.$request->search.'%')->whereNotIn('name',[$request->names])->get();
    // 	}
    // 	if($teams){
    // 		foreach ($teams as $key => $team) {
    // 			$output .= '<li class="dragElement-wrapper drag" draggable="true" ondragstart="return dragStart(event)" id="boxA">'.
    // 				     '<div class="drag-element col-md-6" style="background-color:white;color:black;">'.'</td>'.
    // 				     '<i class="fa fa-cogs"> </i>'.$team->name.'<input type="hidden" name="teams[]" value="'.$team->name.'">'.
    // 				     '</div>'.
    // 				     '</li>';
    // 		}
    // 		return Response($output);
    // 	}

    // 	// $term = $request->search;
    // 	// $data = Team::where('name','LIKE','%'.$term.'%')->take(10)->get();
    // 	// $result = array();
    // 	// foreach ($data as $key => $value) {
    // 	// 	$result[] = ['id'=>$value->id,'name' => $value->name];
    // 	// }
    // 	// return response()->json($result);
    // }
    // public function create(Request $request){
    // 	dd($request->teams);
    // }
}
