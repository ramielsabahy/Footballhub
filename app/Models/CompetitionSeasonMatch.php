<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionSeasonMatch extends Model
{
    protected $table = 'hub_compeitionseasonmatches';
    protected $primaryKey = 'Id';
    // MainRefree && AssistanceRefree && StartDate
    // Adding place
    protected $fillable = ['CompetitionSeasonId', 'CompetitionSeasonGroupId', 'CompetitionRoundId',
        'HomeTeamId', 'VisitorTeamId', 'StartDate', 'HomeGoals', 'VisitorGoals', 'HomePenalties', 'VisitorPenalties', 'Status',
        'StadiumId', 'MainRefreeId', 'AsstRefreeId', 'HomeAssists', 'VisitorAssists'];
    protected $hidden = ['created_at', 'updated_at'];

    public function CompetitionSeason()
    {
        return $this->belongsTo('\App\Models\CompetitionSeason', 'CompetitionSeasonId', 'Id');
    }
    
    public function CompetitionSeasonGroup()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonGroup', 'CompetitionSeasonGroupId', 'Id');
    }
    
    public function CompetitionRound()
    {
        return $this->belongsTo('\App\Models\CompetitionRound', 'CompetitionRoundId', 'Id');
    }
    
    public function HomeTeam()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonTeam', 'HomeTeamId', 'Id')
                ->with('Team');
    }
    
    public function VisitorTeam()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonTeam', 'VisitorTeamId', 'Id')->with('Team');
    }
    
    public function MainReferee()
    {
        return $this->belongsTo('\App\User', 'MainRefreeId', 'id');
    }
    
    public function LineUp()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatchLineUp', 'SeasonMatchId')->with('SeasonMatch')->with('TeamPlayer');
    } 
    
    public function Cards()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatchCard', 'SeasonMatchId')->with('SeasonMatch')->with('TeamPlayer');
    } 
    
    public function Activities()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatchActivity', 'SeasonMatchId')->with('SeasonMatch')->with('TeamPlayer');
    } 
    
    public function Subs()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatchSub', 'SeasonMatchId')->with('SeasonMatch')
                ->with('TeamPlayerIn')->with('TeamPlayerOut');
    } 
    
    public function Goals()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatchGoal', 'SeasonMatchId')->with('SeasonMatch')->with('TeamPlayer');
    }
}