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
        return $this->response->array([
            'status_code'=>$status_code,
            'info'=> $info,
            'activity'=>$activity,
        ]);
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
            $tags_array[]=$tag->name;
        }
        $activity=$activity->toArray();
        $activity['tags']=$tags_array;
        return $activity;
    }
}