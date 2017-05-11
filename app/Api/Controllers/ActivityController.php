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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class ActivityController extends BaseController
{
    public function index(Request $request)
    {
        $attributes = array_filter(
            $request->only('school_id', 'type'),
            function($value) {
                return ($value !== null && $value !== false && $value !== '');
            }
        );
        $people_number_up=isset($_GET['numberOfPeople'])?$_GET['numberOfPeople']:10000;
        $activities=Activity::with('creator','activity_users')
            ->where($attributes)
            ->where('people_number_up','<',$people_number_up)
            ->get(['id','title','content','creator','location','people_number_up','people_number_join','entrie_time_start','entrie_time_end','date_time_start','date_time_end','type']);
        $total=$activities->count();
        if ($total==0)
        {
            return $this->return_response_activity('4004','未找到相关信息');
        }
        $activities_info=array();

        $user_id='';
        if (isset($_GET['token']))
        {
            if (is_object($this->getUser()))
            {
                $user_id=$this->getUser()->id;
                goto a;       //跳出该if
            }

            if ($this->getUser()==4011)
            {
                return response()->json([
                    'status_code'=>'4011',
                    'info' => 'token已过期',
                ]);
            }
            if ($this->getUser()==4012)
            {
                return response()->json([
                    'status_code'=>'4012',
                    'info' => 'token无效',
                ]);
            }
        }
        else
        {
            $user_id='';
        }

a:
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
        $activity=Activity::with('creator','tags','users')->find($id);
        $user_id='';
        if (isset($_GET['token']))
        {
            if (is_object($this->getUser()))
            {
                $user_id=$this->getUser()->id;
                goto a;       //跳出该if
            }

            if ($this->getUser()==4011)
            {
                return response()->json([
                    'status_code'=>'4011',
                    'info' => 'token已过期',
                ]);
            }
            if ($this->getUser()==4012)
            {
                return response()->json([
                    'status_code'=>'4012',
                    'info' => 'token无效',
                ]);
            }
        }
        else
        {
            $user_id='';
        }

a:
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

        if (!is_null(Input::get('tags')))
        {
            $tags=Input::get('tags');
            $tags=$this->normalizeTopic($tags);
        }

        $activity = Activity::create(Input::only('title', 'content','people_number_up','type','entrie_time_start','entrie_time_end','date_time_start','date_time_end','location'));
        $activity->creator=$this->getUser()->id;
        //标签
        $activity->tags()->attach($tags);

        if (Input::get('people_number_up')==null)
        {
            $activity->people_number_up=0;
        }
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
        $activity->update(Input::only('title', 'content','people_number_up','type','entrie_time_start','entrie_time_end','date_time_start','date_time_end','location'));
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

    public function tags(Request $request)
    {
        $topics=Tag::select(['id','name'])->where('name','like','%'.$request->query('q').'%')->get();
        return $topics;
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic)){
                return (int)$topic;
            }
            $newTopic=Tag::create(['name'=>$topic]);
            return $newTopic->id;
        })->toArray();
    }
}