<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable = [
        'title','content','type','creator','people_number_limit','people_number_up','theme','date_time_start','date_time_end','entrie_time_end','entrie_time_start','location'
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Model\Tag');
    }

    public function getTypeAttribute($type)
    {
        return $this->attributes['type']=Type::find($type)->type;
    }

//    public function getCreatorAttribute($user_id)
//    {
//        return $this->attributes['creator']=User::find($user_id)->name;
//    }

    public function creator()
    {
        return $this->belongsTo('App\Model\User','creator')->select('id','name');
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User')->select('user_id','name');
    }
}