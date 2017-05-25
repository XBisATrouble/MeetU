<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 19:21
 */

namespace App\Api\Controllers;
use App\Model\School;
use App\Model\User;
use App\Model\UserMin;
use JWTAuth;

class UserController extends BaseController
{
    public function index()
    {
        if (! $user = JWTAuth::parseToken()->authenticate())
        {
            return $this->return_response_user('4004','未找到相关信息');
        }
        $user = collect($user)->map(function ($item) {
            if ($item===null) {
                $item = "";
            }
            return $item;
        });
        $user_array=$user->toArray(); //将结果集转化为数组
        return $this->return_response_user('2000','success',$user_array);
    }

    public function show($id)
    {
        $user_me=UserMin::find($this->getUser()->id);
        if ($user_me->isFollowEachOther($id))
        {
            $user=UserMin::find($id);
        }
        else
        {
            $user=UserMin::select('id','nickname','age','character_value','gender','followers_count','description','school_name')->find($id);
        }
        $user = collect($user)->map(function ($item) {
            if ($item===null) {
                $item = "";
            }
            return $item;
        });
        if ($user->isEmpty())
        {
            return $this->return_response_user('4004','未找到相关信息');
        }

        return $this->return_response_user('2000','success',$user);
    }

    public function update()
    {
        $user=$this->getUser();
        //验证规则
        $rules = [
            'nickname' => ['required'],
            'gender'=>['boolean'],
        ];

        $error_message=[
            'nickname.required'=>'昵称不能为空!',
        ];

        $payload = app('request')->only('nickname','gender','description','school_id','student_id','QQ','WeChat','WeiBo','FaceBook','Instagram','Twitter','photo','photo2');

        // 验证格式
        $validator = app('validator')->make($payload, $rules,$error_message);
        $validator_array=$validator->errors()->toArray();

        if ($validator->fails()) {
            return $this->return_response_user('4003','请求参数出错');
        }

        $newUser=[
            'nickname'=>$payload['nickname'],
            'gender'=>$payload['gender'],
            'description'=>$payload['description'],
            'school_id'=>$payload['school_id'],
            'school_name'=>School::find($payload['school_id'])->school_name,
            'student_id'=>$payload['student_id'],
            'QQ'=>$payload['QQ'],
            'WeChat'=>$payload['WeChat'],
            'WeiBo'=>$payload['WeiBo'],
            'FaceBook'=>$payload['FaceBook'],
            'Instagram'=>$payload['Instagram'],
            'Twitter'=>$payload['Twitter'],
            'verify_photo'=>$payload['photo'],
            'verify_photo_2'=>$payload['photo2'],
        ];

        $user->update($newUser);

        if ($user->save()) {
            return $this->return_response_user('2001','更新成功',$user);
        } else {
            return $this->return_response_user('5000','服务器出错!');
        }
    }

    public function changePwd()
    {
        //验证规则
        $rules = [
            'newPassword' => ['required', 'min:6'],
        ];
        $payload = app('request')->only('newPassword');
        // 验证格式
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return $this->response->array([
                'status_code'=>'4003',
                'info' => $validator->errors()
            ]);
        }

        $newPwd=$payload['newPassword'];
        $user_id = JWTAuth::parseToken()->authenticate()->id;
        $User=User::where('id',$user_id)->first();
        $User->password=bcrypt($newPwd);
        if($User->save())
            return $this->response->array([
                'status_code'=>'2002',
                'info'=>'修改成功',
            ]);
        else{
            return $this->response->array([
                'status_code'=>'5000',
                'info' => '服务器出错',
            ]);
        }
    }

    public function followers()
    {
        if($user=UserMin::find($this->getUser()->id))
        {
            $user=$user->followings()->get();
            $total=$user->count();
            return $this->return_response_user('2000','success',$user,$total);
        }
        else
        {
            return $this->return_response_user('2004','未找到相关信息');
        }
    }

    public function following()
    {
        if($user=UserMin::find($this->getUser()->id))
        {
            $user=$user->followings()->get();
            $total=$user->count();
            return $this->return_response_user('2000','success',$user,$total);
        }
        else
        {
            return $this->return_response_user('2004','未找到相关信息');
        }
    }

    public function follow($user_id)
    {
        if($this->isFollow($this->getUser()->id,$user_id))
        {
            return $this->return_response_activity('4041','您已经关注他');
        }
        $user=UserMin::find($this->getUser()->id);
        $user->follow($user_id);
        $follower=UserMin::find($user_id);
        $follower->followers+=1;
        $follower->save();

        return $this->return_response_activity('2000','关注成功');
    }

    public function unfollow($user_id)
    {
        if(!$this->isFollow($this->getUser()->id,$user_id))
        {
            return $this->return_response_activity('4041','您还未关注他');
        }
        $user=UserMin::find($this->getUser()->id);
        $user->unfollow($user_id);
        $follower=UserMin::find($user_id);
        $follower->followers-=1;
        $follower->save();

        return $this->return_response_activity('2000','取关成功');
    }

    public function location()
    {
        $user=$this->getUser();
        $user->last_lng=request('lng');
        $user->last_lat=request('lat');
        $user->save();
        return $this->response->array([
            'status_code'=>'2000',
            'info' => '操作成功',
        ]);
    }
}