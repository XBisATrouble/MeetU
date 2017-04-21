<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/12
 * Time: 21:42
 */

namespace App\Api\Controllers;

use App\Model\Activity;
use App\Model\User;
use Illuminate\Support\Facades\DB;

class ActivityParticipantsController extends BaseController
{
    public function index($id)
    {
        $users=Activity::find($id)->users()->get();
        $total=$users->count();
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'users'=>$users,
        ]);
    }

    public function store($id)
    {
        $activity_id=$id;
        $user_id=$this->getUser()->id;

        if (!$activity=Activity::find($activity_id))
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        if(DB::table('activity_user')->where(['activity_id'=>$id,'user_id'=>$user_id])->get()!=null)
        {
            return $this->return_response_activity('4004','您已参加该活动');
        }

        $activity->users()->attach($user_id);
        return $this->return_response_activity('2000','参加成功');
    }

    public function destroy($id)
    {
        $activity_id=$id;
        $user_id=$this->getUser()->id;
        if (!$activity=Activity::find($activity_id))
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        if(DB::table('activity_user')->where(['activity_id'=>$id,'user_id'=>$user_id])->get()==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }

        $activity->users()->detach($user_id);
        return $this->return_response_activity('2000','退出成功');
    }

    public function participated($id)
    {
        $user=User::find($id);
        if($user==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        $activities=$user->activity;
        $activities_array=array();
        foreach ($activities as $activity) {
            $activities_array[]=$this->insert_tags($activity);
        }
        $total=$user->activity->count();
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'activity'=>$activities_array,
        ]);
    }

    public function created($id)
    {
        $user=User::find($id);
        if($user==null)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        $activities=$user->create_activity;
        $activities_array=array();
        foreach ($activities as $activity) {
            $activities_array[]=$this->insert_tags($activity);
        }
        $total=$user->create_activity->count();
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'activity'=>$activities_array,
        ]);
    }
}