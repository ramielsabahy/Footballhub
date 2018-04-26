<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionSeason extends Model
{
    protected $table = 'hub_compeitionseasons';
    protected $primaryKey = 'Id';
    protected $fillable = ['CompetitionId', 'Season', 'StartDate', 'EndDate', 'YellowCardsToSuspend',
        'NumberOfTeams', 'NumberOfGroups', 'Status'];
    protected $hidden = ['created_at', 'updated_at'];

    public function Competition()
    {
        return $this->belongsTo('\App\Models\Competition', 'CompetitionId', 'Id');
    }
    
    public function CompetitionSeasonGroups()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonGroup', 'CompetitionSeasonId')->with('CompetitionSeasonTeams');
    }

    public function competitionSeasonMatches()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonMatch', 'CompetitionSeasonId', 'Id');
    }
}