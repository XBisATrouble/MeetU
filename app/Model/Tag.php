<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable=['name'];
    protected $hidden = ['pivot'];
    public $timestamps = false;
    public function articles()
    {
        return $this->belongsToMany('App\Model\Activity');
    }
}
