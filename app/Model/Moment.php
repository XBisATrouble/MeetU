<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/5/27
 * Time: 12:48
 */

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Moment extends Model
{
    protected $table='moments';

    protected $fillable=['title','content','location','votes_count','comments_count','user_id'];

    public function user()
    {
        return $this->belongsTo(UserMin::class);
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