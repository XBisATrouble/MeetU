<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //

    public function tags()
    {
        $tags=$this->belongsToMany('App\Model\Tag')->select('name');
        return $tags;
    }

    public function getThemeAttribute($theme)
    {
        return $this->attributes['theme']=Theme::find($theme)->theme;
    }

    public function getCreatorAttribute($user_id)
    {
        return $this->attributes['creator']=User::find($user_id)->name;
    }

    public function users()
    {
        return $this->belongsToMany('App\Model\User')->select('user_id','name');
    }
}