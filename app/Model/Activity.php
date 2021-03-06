<?php

namespace App\Model;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;

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
        'status','PercentOfPeople'
    ];

    protected $casts = [
        'people_number_up'=>'integer',
        'people_number_join'=>'integer',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Model\Tag');
    }

    public function getTypeAttribute($type)
    {
        return $this->attributes['type']=(int)$type;
    }

    public function creator()
    {
        return $this->belongsTo('App\Model\User','creator')->select('id','nickname','avatar','age','character_value','gender','followers_count','description','school_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User')->withTimestamps()->select('users.id','nickname','avatar','age','character_value','gender','followers_count','description','school_id');
    }

    public function activity_users()
    {
        return $this->belongsToMany('App\Model\User')->withTimestamps()->select('users.id','avatar','school_id');
    }

    public function getStatusAttribute()
    {
        $dt = new DateTime();
        $dt_now=$dt->format('Y-m-d H:i:s');
        if($dt_now<$this->entrie_time_start)
            return "报名尚未开始";
        else if ($dt_now>$this->entrie_time_end)
            return "报名已经结束";
        else
            return "报名进行中";
    }

    public function getPercentOfPeopleAttribute()
    {
        return $this->people_number_up===0?0:(floatval(round((float)$this->people_number_join/$this->people_number_up,2)));
    }

    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() > Carbon::parse($date)->addDays(10)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }

    public function getUpdatedAtAttribute($date)
    {
        if (Carbon::now() > Carbon::parse($date)->addDays(10)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }
}