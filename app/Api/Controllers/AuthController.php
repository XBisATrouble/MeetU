<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 16:50
 */

namespace App\Api\Controllers;
use App\Model\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;


class AuthController extends BaseController
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->return_response('4001','账号或者密码错误!');
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->return_response('5000','服务器出错!');
        }
        // all good so return the token
        return $this->return_response('2000','success',$token);
    }

    /*
     * 更新用户token
     */
    public function upToken()
    {
        try {
            $old_token = JWTAuth::getToken();
            $token = JWTAuth::refresh($old_token);
            //JWTAuth::invalidate($old_token);
        } catch (TokenExpiredException $e) {
            return $this->response->array([
                'status_code'=>'4011',
                'info'=>'token已过期',
                'token'=>'',
            ]);
        } catch (JWTException $e) {
            return $this->response->array([
                'status_code'=>'4012',
                'info'=>'token无效',
                'token'=>'',
            ]);
        }

        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'token'=>$token,
        ]);
    }

    public function register()
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
        if ($res) {
            $credentials = ['phone'=>$payload['phone'],'password'=>$payload['password']];

            $token = JWTAuth::attempt($credentials);

            return $this->return_response('2001','success',$token);
        } else {
            return $this->return_response('5000','服务器出错!');
        }
    }
}