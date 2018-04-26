<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchMapTeam extends Model
{
    protected $primary = 'id';
    protected $table = 'hubmatch_map_teams';
    protected $fillable = ['competition_season_id', 'competition_round_id' , 'group_A','team_A','group_B','team_B'];
    protected $hidden = [];

    
}
