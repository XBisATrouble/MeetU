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


class AuthController extends BaseController
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('phone', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                        'success'=>'false',
                        'status_code'=>'400',
                        'msg' => '用户名或密码错误']
                );
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json([
                    'success'=>'false',
                    'status_code'=>'500',
                    'msg' => '创建token失败']
            );
        }

        // all good so return the token
        return response()->json([
            'success'=>'true',
            'status_code'=>'200',
            'token'=>$token,
        ]);
    }

    /*
     * 更新用户token
     */
    public function upToken()
    {
        $token = JWTAuth::refresh();

        return $this->response->array(compact('token'));
    }

    public function register()
    {
        //验证规则
        $rules = [
            'name' => ['required','unique:users'],
            'phone' => ['required', 'min:11', 'max:11', 'unique:users'],
            'password' => ['required', 'min:6'],
            'school_id'=>['required'],
            'gender'=>['required','min:0','max:1','integer'],
        ];
        $payload = app('request')->only('name', 'phone', 'password','school_id','gender');
        // 验证格式
        $validator = app('validator')->make($payload, $rules);
        if ($validator->fails()) {
            return $this->response->array([
                'success'=>'false',
                'status_code'=>'400',
                'msg' => $validator->errors()
            ]);
        }

        $newUser=[
            'name' => $payload['name'],
            'phone' => $payload['phone'],
            'password' => bcrypt($payload['password']),
            'school_id'=>$payload['school_id'],
            'gender'=>$payload['gender'],
        ];


        $res = User::create($newUser);

        // 创建用户成功
        if ($res) {
            return $this->response->array([
                'success'=>'true',
                'status_code'=>'200',
                'msg' => '创建用户成功',
            ]);
        } else {
            return $this->response->array([
                'success'=>'false',
                'status_code'=>'500',
                'msg' => '创建用户失败',
            ]);
        }
    }
}