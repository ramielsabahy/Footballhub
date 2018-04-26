<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Feed extends Model
{
    protected $table = 'hubfeeds';
    protected $primaryKey = 'id';
    protected $fillable = ['body', 'thumbnail', 'type', 'feed_type', 'active_status'];
    protected $hidden = [];

    protected $appends = ['hasLiked', 'NumLikes'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\UserFeedComment')->where('active_status', '=', 1)->with('user')->orderBy('id', 'desc');
    }

    public function likes()
    {
        return $this->hasMany('App\FeedLike');
    }

    public function feed_reports()
    {
        return $this->hasMany('App\feed_report');
    }

    public function getHasLikedAttribute()
    {
        try {
            if (\App\FeedLike::where('user_id', '=', auth()->user()->id)->where('feed_id', '=', $this->id)->get()->count()) {
                return true;
            }
            else {
                return false;
            }
        } catch(\Exception $e) {
            return false;
        }
    }

    public function getNumLikesAttribute()
    {
        return \App\FeedLike::where('feed_id', '=', $this->id)->get()->count();
    }

    public function getNumCommentsAttribute()
    {
        return $this->comments()->count();
    }
}
