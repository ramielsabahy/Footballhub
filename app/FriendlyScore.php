<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendlyScore extends Model
{
    protected $table = 'hubfriendly_scores';
    protected $primaryKey = 'player_id';
    protected $fillable = ['player_id', 'total_points', 'total_number_of_played_matches', 'number_of_won_matches', 'number_of_goals', 'number_of_assists'];
    protected $hidden = [];

    public function player() {
    	return $this->belongsTo('\App\User', 'player_id');
    }
}
