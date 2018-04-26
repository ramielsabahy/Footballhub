<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class friendlyMembers extends Model
{
	protected $table = 'hubfriendly_members';
	protected $fillable = ['player_id', 'friendly_match_id'];
	protected $hidden = [];

	public function player()
	{
		return $this->belongsTo('\App\User', 'player_id');
	}

	public function friendlyMatch()
	{
		return $this->belongsTo('\App\friendlyMatch', 'friendly_match_id');
	}
}
