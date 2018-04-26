<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionSeasonGroup extends Model
{
    protected $table = 'hub_compeitionseasongroups';
    protected $primaryKey = 'Id';
    protected $fillable = ['CompetitionSeasonId', 'Name', 'Rank'];
    protected $hidden = [];

    public function CompetitionSeason()
    {
        return $this->belongsTo('\App\Models\CompetitionSeason', 'CompetitionSeasonId', 'Id');
    }
    
    public function CompetitionSeasonTeams()
    {
        return $this->hasMany('\App\Models\CompetitionSeasonTeam', 'CompetitionSeasonGroupId')->with('Team');
    } 
}