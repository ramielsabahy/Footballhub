<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'hubreports';
    protected $fillable = ['type', 'description'];
    protected $hidden = [];

    public function feed_reports()
    {
    	return $this->hasMany('App\feed_report');
    }
}
