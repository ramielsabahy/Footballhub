<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feed_report extends Model
{
    protected $table = 'hubfeed_report';
    protected $fillable = ['user_id', 'feed_id', 'report_id'];
    protected $hidden = [];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function feed()
    {
    	return $this->belongsTo('App\Feed');
    }

    public function report()
    {
    	return $this->belongsTo('App\Report');
    }
}
