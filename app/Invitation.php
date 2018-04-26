<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'hub_invitations';
    protected $primary = 'id';
    protected $fillable = ['player_id', 'team_id', 'friendly_match_id', 'phone_number', 'invitation_type'];
    // invitation_type
    // 1 for team invitation
    // 2 for friendly_match invitation
    protected $hidden = [];
    protected $appends = ['MatchName', 'MatchOwner'];

    public function player() {
    	return $this->belongsTo('\App\User');
    }

    public function team() {
    	return $this->belongsTo('\App\Team');
    }

	public function friendlyMatch()
	{
		return $this->belongsTo('\App\friendlyMatch', 'friendly_match_id');
	}

	public function getMatchNameAttribute() {
        try {
	       return $this->friendlyMatch->matchName;
        } catch(\Exception $e) {
            return '';
        }
	}

	public function getMatchOwnerAttribute() {
        try {
	       return \App\User::find($this->friendlyMatch->owner_id)->fullName;
        } catch(\Exception $e) {
            '';
        }
	}
}
