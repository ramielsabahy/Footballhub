<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompetitionSeasonMatchActivity extends Model
{
    protected $table = 'hub_compeitionseasonmatchactivity';
    protected $primaryKey = 'Id';
    protected $fillable = ['TeamPlayerId', 'SeasonMatchId', 'ActionId',
        'RefreeScoreValue', 'Minute'];
    protected $hidden = ['created_at', 'updated_at'];

    public function SeasonMatch()
    {
        return $this->belongsTo('\App\Models\CompetitionSeasonMatch', 'SeasonMatchId', 'Id');
    }
    
    public function TeamPlayer()
    {
        return $this->belongsTo('\App\teams_users', 'TeamPlayerId', 'Id')->with('team')
                ->with('player');
    }
    
    public function Activity()
    {
        return $this->belongsTo('\App\Models\BasicSetup', 'ActionId', 'Id');
    }
}