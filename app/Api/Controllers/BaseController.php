<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 16:48
 */

namespace App\Api\Controllers;


use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use JWTAuth;

class BaseController extends Controller
{
    use Helpers;

    public function upLoadPhoto($photo,$path,$name,$prefix=null)
    {
        $photoPath='./public/upload/'.$path;
        $extension = $photo->getClientOriginalExtension();
        $photo->move($photoPath,$name.$prefix.'.'.$extension);
        return $photoPath.'/'.$name.'.'.$extension;
    }

    public function return_response($status_code, $info, $token='')
    {
        return $this->response->array([
            'status_code'=>$status_code,
            'info'=> $info,
            'token'=>$token,
        ]);
    }

    public function return_response_activity($status_code, $info, $activity='')
    {
        if($activity=='')
        {
            return $this->response->array([
                'status_code'=>$status_code,
                'info'=> $info,
            ]);
        }
        else
        {
            return $this->response->array([
                'status_code'=>$status_code,
                'info'=> $info,
                'data'=>$activity,
            ]);
        }
    }

    public function return_response_user($status_code, $info, $users='')
    {
        if($users=='')
        {
            return $this->response->array([
                'status_code'=>$status_code,
                'info'=> $info,
            ]);
        }
        else
        {
            return $this->response->array([
                'status_code'=>$status_code,
                'info'=> $info,
                'data'=>$users,
            ]);
        }
    }

    public function errorNotFound_Me($data)
    {
        return response()->json([
            'status_code'=>'4004',
            'info'=>$data,
        ]);
    }

    public function getUser()
    {
        return $user = JWTAuth::parseToken()->authenticate();
    }

    public function insert_tags($activity)
    {
        $tags_array=array();
        $tags=$activity->tags;
        foreach ($tags as $tag) {
            $tags_array[$tag->id]=$tag->name;
        }
        $activity=$activity->toArray();
        $activity['tags']=$tags_array;
        return $activity;
    }

    public function is_participated($user_id,$activity_id)
    {
        if(DB::table('activity_user')->where(['activity_id'=>$activity_id,'user_id'=>$user_id])->get()!=null)
            return true;
        else
            return false;
    }
}