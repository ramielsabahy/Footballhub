<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'hubusers';
    protected $primaryKey = 'id';
    protected $appends = ['NumOfFollowers', 'NumOfFollowing', 'NumOfTeams'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fullName', 'name', 'email', 'password', 'mobileNumber', 'location', 'favourite_club', 'facebook_id', 'facebook_token', 'user_photo', 'date_of_birth', 'height', 'weight', 'active_status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getNumOfFollowersAttribute() {
        return \App\Follow::where('following', '=', $this->id)->get()->count();
    }

    public function getNumOfFollowingAttribute() {
        return \App\Follow::where('follower', '=', $this->id)->get()->count();
    }

    public function getNumOfTeamsAttribute() {
        return $this->memberTeams()->count();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'hubrole_user');
    }

    public function feeds()
    {
        return $this->hasMany('App\Feed');
    }

    public function comments()
    {
        return $this->hasMany('App\UserFeedComment')->where('active_status', '=', 1)->orderBy('id', 'desc');
    }

    public function likes()
    {
        return $this->hasMany('App\FeedLike');
    }

    public function feed_reports()
    {
        return $this->hasMany('App\feed_report');
    }

    public function ownedTeams()
    {
        return $this->hasMany('\App\Team')->where('active_status', '=', 1);
    }

    public function friendlyInvitations() {
        return $this->hasMany('\App\Invitation', 'player_id')->where('invitation_type', '=', 2);
    }

    public function memberTeams()
    {
        return $this->hasMany('\App\teams_users')->orderBy('id', 'desc');
    }

    public function friendlyMatches()
    {
        return $this->hasMany('\App\friendlyMatch', 'owner_id')->orderBy('id', 'desc');
    }

    public function friendlyJoinedMatches()
    {
        return $this->hasMany('\App\friendlyMembers', 'player_id')->orderBy('id', 'desc');
    }

    public function invitations() {
        return $this->hasMany('\App\Invitation', 'player_id')->orderBy('id', 'desc');
    }

    public function friendlyScore()
    {
        return $this->hasOne('\App\FriendlyScore', 'player_id');
    }

    public function followers()
    {
        return $this->hasMany('\App\Follow', 'follower')->orderBy('id', 'desc');
    }

    public function followings()
    {
        return $this->hasMany('\App\Follow', 'following')->orderBy('id', 'desc');
    }

    public function isAdmin() 
    {
        return $this->whereHas('roles', function($query) {
            $query->where('name', '=', 'Admins');
        })->get()->count();
    }
}
