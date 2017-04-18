<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/12
 * Time: 21:42
 */

namespace App\Api\Controllers;


use App\Model\Activity;
use JWTAuth;

class ActivityController extends BaseController
{
    public function index()
    {
        $activities=Activity::all();
        $total=$activities->count();
        $activities_info=array();
        foreach ($activities as $activity) {
            $activities_info=$activity::with('tags')->get()->toArray();
        }
        return $this->response->array([
            'status_code'=>'2000',
            'total'=>$total,
            'activities'=>$activities_info,
        ]);
    }

    public function show($id)
    {
        $activity=Activity::with('tags')->find($id);
        return $this->response->array([
            'status_code'=>'2000',
            'activities'=>$activity->toArray(),
        ]);
    }
}