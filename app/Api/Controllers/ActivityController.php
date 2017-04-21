<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/12
 * Time: 21:42
 */

namespace App\Api\Controllers;


use App\Model\Activity;
use App\Model\Tag;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class ActivityController extends BaseController
{
    public function create()
    {
        $tags=Tag::lists('name','id');
        return compact('tags');
    }

    public function index()
    {
        $activities=Activity::with('creator')->get();
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
        $activity=Activity::with('creator')->find($id);
        if($activity==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
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
        $activity->creator=$this->getUser()->id;
        if(!$activity->save())
        {
            return $this->return_response_activity('5000','服务器出错');
        }
        $activity=Activity::with('creator')->find($activity->id);
        $activity=$this->insert_tags($activity);
        return $this->return_response_activity('2000','发布成功',$activity);
    }

    public function update($id)
    {
        $activity=Activity::with('creator')->find($id);
        if($activity==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        if($activity->creator!=$this->getUser()->id)
        {
            return $this->return_response_activity('4030','您没有权限进行此操作');
        }
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
        $activity->update(Input::only('title', 'content','people_number_limit','people_number_up','type','entrie_time_start','entrie_time_end','date_time_start','date_time_end','location'));
        if(!$activity->save())
        {
            return $this->return_response_activity('5000','服务器出错');
        }
        $activity=$this->insert_tags($activity);
        return $this->return_response_activity('2000','更新成功',$activity);
    }

    public function destroy($id)
    {
        $activity=Activity::find($id);
        if($activity==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        if($activity->creator!=$this->getUser()->id)
        {
            return $this->return_response_activity('4030','您没有权限进行此操作');
        }
        if(!$activity->delete())
        {
            return $this->return_response_activity('5000','服务器出错');
        }
        else
        {
            return $this->return_response_activity('2000','删除成功');
        }
    }
}