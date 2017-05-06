<?php

namespace App\Model;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable = [
        'title','content','type','creator','people_number_limit','people_number_up','theme','date_time_start','date_time_end','entrie_time_end','entrie_time_start','location'
    ];

    protected $hidden = [
        'pivot','school_id'
    ];

    protected $appends = [
        'status'
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Model\Tag');
    }

    public function getTypeAttribute($type)
    {
        return $this->attributes['type']=Type::find($type)->type;
    }

    public function creator()
    {
        return $this->belongsTo('App\Model\User','creator')->select('id','nickname','avatar','age','character_value','gender','followers','description','school_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User')->withTimestamps()->select('users.id','nickname','avatar','age','character_value','gender','grade','followers','description','school_id');
    }

    public function getStatusAttribute()
    {
        $dt = new DateTime();
        $dt_now=$dt->format('Y-m-d H:i:s');
        if($this->entrie_time_start<$dt_now && $this->entrie_time_end>$dt_now)
            return "活动进行中";
        else
            return "活动已经结束";
    }
}