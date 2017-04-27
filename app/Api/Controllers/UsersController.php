<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 19:21
 */

namespace App\Api\Controllers;

use App\Model\UserMin;
use App\Model\User;
use JWTAuth;

class UsersController extends BaseController
{
    public function index()
    {
        $since= isset($_GET['since'])?$_GET['since']:0;
        $users=UserMin::since($since)->select('id','nickname','age','character_value','gender','grade','followers','description','school_id')->take('50')->get();

        $user_array=array();
        foreach ($users as $user) {
            $user_array[] = collect($user)->map(function ($item) {
                if ($item==null) {
                    $item = "";
                }
                return $item;
            });
        }

        if ($user_array==null)
        {
            return $this->return_response_user('4004','未找到相关信息');
        }
        return $this->return_response_user('2000','success',$user_array);
    }

    public function show($id)
    {
        $user=UserMin::select('id','nickname','age','character_value','gender','followers','grade','description','school_id')->find($id);
        $user = collect($user)->map(function ($item) {
            if ($item==null) {
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

    public function store()
    {
        //验证规则
        $rules = [
            'phone' => ['required', 'between:11,11', 'unique:users'],
            'password' => ['required', 'min:6'],
            'nickname' => ['required'],
            'gender'=>['boolean'],
            'name' => ['unique:users'],
            'idcard'=>['unique:users','between:18,18'],
//            'photo'=>['mimes:jpeg,bmp,png,jpg'],
//            'photo2'=>['mimes:jpeg,bmp,png,jpg'],
        ];

        $error_message=[
            'phone.required'=>'手机号不能为空!',
            'phone.between'=>'手机号必须为11位!',
            'phone.unique'=>'该手机已被注册!',
            'password.required'=>'密码不能为空!',
            'password.min'=>'密码必须大于6位!',
            'nickname.required'=>'昵称不能为空!',
            'name.unique'=>'该姓名已被注册!',
            'idcard.unique'=>'该身份证已被注册!',
            'idcard.between'=>'身份证必须为18位',
//            'photo.mimes'=>'必须上传图片',
//            'photo2.mimes'=>'必须上传图片',
        ];

        $payload = app('request')->only('phone','password','nickname','gender','description','name','idcard','school_id','student_id','QQ','WeChat','WeiBo','FaceBook','Instagram','Twitter','photo','photo2');

        // 验证格式
        $validator = app('validator')->make($payload, $rules,$error_message);
        $validator_array=$validator->errors()->toArray();

        if ($validator->fails()) {
            if(!empty($validator_array['phone'][0]))
            {
                return $this->return_response('4022',$validator_array['phone'][0]);
            }
            if(!empty($validator_array['idcard'][0]))
            {
                return $this->return_response('4023',$validator_array['idcard'][0]);
            }
            if(!empty($validator_array['password'][0]))
            {
                return $this->return_response('4024',$validator_array['password'][0]);
            }
//            if(!empty($validator_array['photo'][0]))
//            {
//                return $this->return_response('4025',$validator_array['photo'][0]);
//            }
//            if(!empty($validator_array['photo2'][0]))
//            {
//                return $this->return_response('4025',$validator_array['photo2'][0]);
//            }
        }

//        if ($payload['photo']!=null){
//            $photo=$this->upLoadPhoto($payload['photo'],$payload['idcard']);
//        }else{
//            $photo=null;
//        }
//        if ($payload['photo2']!=null){
//            $photo2=$this->upLoadPhoto($payload['photo2'],$payload['idcard'],'_2');
//        }else{
//            $photo2=null;
//        }

        $newUser=[
            'phone' => $payload['phone'],
            'password' => bcrypt($payload['password']),
            'nickname'=>$payload['nickname'],
            'gender'=>$payload['gender'],
            'description'=>$payload['description'],
            'name' => $payload['name'],
            'idcard'=>$payload['idcard'],
            'school_id'=>$payload['school_id'],
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

        $res = User::create($newUser);
        // 创建用户成功
        if ($res)
        {
            $credentials = ['phone'=>$payload['phone'],'password'=>$payload['password']];

            $token = JWTAuth::attempt($credentials);
            return $this->response->array([
                'status_code'=>'2001',
                'info'=> '注册成功',
                'token'=>$token,
                'user'=>$res->toArray(),
            ]);
            //return $this->return_response('2001','注册成功',$token);
        }
        else
        {
            return $this->return_response('5000','服务器出错!');
        }
    }

    public function followers($user_id)
    {
        if($user=UserMin::find($user_id)->followers)
        {
            $total=$user->count();
            if ($total==0)
            {
                return $this->return_response_user('2004','未找到相关信息');
            }
            return $this->return_response_user('2000','success',$user,$total);
        }
        else
        {
            return $this->return_response('5000','服务器出错!');
        }
    }

    public function following($user_id)
    {
        if($user=UserMin::find($user_id)->followings)
        {
            $total=$user->count();
            if ($total==0)
            {
                return $this->return_response_user('2004','未找到相关信息');
            }
            return $this->return_response_user('2000','success',$user,$total);
        }
        else
        {
            return $this->return_response('5000','服务器出错!');
        }
    }
}