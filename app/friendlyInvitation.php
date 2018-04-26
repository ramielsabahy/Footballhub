<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class friendlyInvitation extends Model
{
	protected $table = 'hubfriendly_invitations';
	protected $fillable = ['player_id', 'friendly_match_id'];
	protected $hidden = [];
	protected $appends = ['MatchName', 'MatchOwner'];

	public function player()
	{
		return $this->belongsTo('\App\User', 'player_id');
	}

	public function friendlyMatch()
	{
		return $this->belongsTo('\App\friendlyMatch', 'friendly_match_id');
	}

    public function getMatchNameAttribute() {
        return $this->friendlyMatch->matchName;
    }

    public function getMatchOwnerAttribute() {
    	return \App\User::find($this->friendlyMatch->owner_id)->fullName;
    }
}
