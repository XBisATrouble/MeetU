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
use App\Model\Type;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class ActivityController extends BaseController
{
    public function index()
    {
        $activities=Activity::with('creator')->get();
        $total=$activities->count();
        $activities_info=array();
        if (isset($_GET['token']))
        {
            $user_id=$this->getUser()->id;
        }
        else
        {
            $user_id='';
        }
        foreach ($activities as $activity) {
            $activity['is_participated']=$this->isParticipated($user_id,$activity->id);
            $activity=$this->insert_tags($activity);
            $activities_info[]=$activity;
        }
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'data'=>$activities_info,
        ]);
    }

    public function show($id)
    {
        $activity=Activity::with('creator','tags')->find($id);
        if (isset($_GET['token']))
        {
            $user_id=$this->getUser()->id;
        }
        else
        {
            $user_id='';
        }
        if($activity==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        $activity['is_participated']=$this->isParticipated($user_id,$id);
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
        $user_id=$this->getUser()->id;
        $activity->users()->attach($user_id);
        $activity=Activity::with('creator')->find($activity->id);
        $activity['is_participated']=$this->isParticipated($user_id,$activity->id);
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
        $activity['is_participated']=$this->isParticipated($this->getUser()->id,$activity->id);
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

    public function edit($id)
    {
        $activity=Activity::with('creator')->find($id);
        if($activity==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        $activity['is_participated']=$this->isParticipated($this->getUser()->id,$id);
        $activity=$this->insert_tags($activity);
        return $this->return_response_activity('2000','success',$activity);
    }

    public function create()
    {
//        $tags=Tag::lists('name','id');
//        $type=Type::lists('type','id');
//        $result[]=compact('tags');
//        $result[]=compact('type');
//        return $result;
        $total=Tag::count();
        $tags=Tag::all();
        return response()->json([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'data'=>$tags,
        ]);
    }
}