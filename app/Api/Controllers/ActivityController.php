<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/12
 * Time: 21:42
 */

namespace App\Api\Controllers;


use App\Model\Activity;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class ActivityController extends BaseController
{
    public function index()
    {
        $activities=Activity::all();
        $total=$activities->count();
        $activities_info=array();
        foreach ($activities as $activity) {
            $activity=$this->insert_tags($activity);
            $activities_info[]=$activity;
        }
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'activities'=>$activities_info,
        ]);
    }

    public function show($id)
    {
        $activity=Activity::find($id);
        $activity=$this->insert_tags($activity);
        return $this->return_response_activity('2000','success',$activity);
    }

    public function store()
    {
        $rules = [
            'title'   => 'required|max:100',
            'content' => 'required',
            'type'=>'required',
        ];
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return $this->return_response_activity('4003','请求参数出错');
        }
        $activity = Activity::create(Input::only('title', 'content','people_number_limit','people_number_up','type','entrie_time_start','entrie_time_end','date_time_start','date_time_end','location'));
        //$activity=Activity::find($activity->id);
        $activity->creator=$this->getUser()->id;
        if(!$activity->save())
        {
            return $this->return_response_activity('5000','服务器出错');
        }
        $activity=$this->insert_tags($activity);
        return $this->return_response_activity('2000','success',$activity);
    }

    public function update($id)
    {
        return Input::all();

        $activity=Activity::find($id);
//        $rules = [
//            'title'   => 'required|max:100',
//            'content' => 'required',
//            'type'=>'required',
//        ];
//        $validator = Validator::make(Input::all(), $rules);
//
//        if ($validator->fails())
//        {
//            return $this->return_response_activity('4003','请求参数出错');
//        }
        $activity->update(Input::only('title', 'content','people_number_limit','people_number_up','type','entrie_time_start','entrie_time_end','date_time_start','date_time_end','location'));

        if(!$activity->save())
        {
            return $this->return_response_activity('5000','服务器出错');
        }
        $activity=$this->insert_tags($activity);
        return $this->return_response_activity('2000','success',$activity);
    }
}