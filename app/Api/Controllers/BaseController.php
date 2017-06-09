<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/4/2
 * Time: 16:48
 */

namespace App\Api\Controllers;


use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserMin;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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

    public function return_response_activity($status_code, $info, $activity='',$total='')
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
            if($total=='')
            {
                return $this->response->array([
                    'status_code'=>$status_code,
                    'info'=> $info,
                    'data'=>$activity,
                ]);
            }
            else
            {
                return $this->response->array([
                    'status_code'=>$status_code,
                    'info'=> $info,
                    'total'=>$total,
                    'data'=>$activity,
                ]);
            }
        }
    }

    public function return_response_user($status_code, $info, $users='',$total='')
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
            if($total=='')
            {
                return $this->response->array([
                    'status_code'=>$status_code,
                    'info'=> $info,
                    'data'=>$users,
                ]);
            }
            else
            {
                return $this->response->array([
                    'status_code'=>$status_code,
                    'info'=> $info,
                    'total'=>$total,
                    'data'=>$users,
                ]);
            }
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
        //return $user = JWTAuth::parseToken()->authenticate();

        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                    $status_code='4004';
                    return $status_code;
            }
        } catch (TokenExpiredException $e) {
            $status_code='4011';
            return $status_code;
        } catch (TokenInvalidException $e) {
            $status_code='4012';
            return $status_code;
        } catch (JWTException $e) {
            $status_code='5000';
            return $status_code;
        }
        return $user;
    }

    public function insert_tags($activity)
    {
        $tags_array=array();
        $tags=$activity->tags;
        foreach ($tags as $tag) {
            $tags_array[]=$tag->name;            //$tags_array[$tag->id]=$tag->name;
        }
        $activity=$activity->toArray();
        $activity['tags']=$tags_array;
        return $activity;
    }

    public function isParticipated($user_id,$activity_id)
    {
        if(DB::table('activity_user')->where(['activity_id'=>$activity_id,'user_id'=>$user_id])->get()!=null)
            return true;
        else
            return false;
    }

    public function isFollow($user_id,$follower_id)
    {
        return UserMin::find($user_id)->isFollowing($follower_id);
    }

    public function BaiduApiLocation($location)
    {
        header('Access-Control-Allow-Origin:*');
        $ch = curl_init();
        $url="http://api.map.baidu.com/place/v2/suggestion?query=".$location."&region=全国&output=json&ak=QFB8m8ZrCEgUXss3Av5vId58CuxlA0jl";
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
//执行并获取HTML文档内容
        $output = curl_exec($ch);
//释放curl句柄
        curl_close($ch);
//打印获得的数据
        $array=json_decode($output)->result;
        $result['lat']=$array[0]->location->lat;
        $result['lng']=$array[0]->location->lng;
        return $result;
    }

    public function distance($user_id,$activity)
    {
        $user=User::find($user_id);
        if ($user!=null)
            return $this->getDistance($user->last_lat,$user->last_lng,$activity->lat,$activity->lng);
        else
            return null;
    }

    function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        header('Access-Control-Allow-Origin:*');
        $ch = curl_init();
        $url="http://api.map.baidu.com/routematrix/v2/driving?output=json&origins=".$lat1.",".$lng1."&destinations=".$lat2.",".$lng2."&ak=QFB8m8ZrCEgUXss3Av5vId58CuxlA0jl";
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
//执行并获取HTML文档内容
        $output = curl_exec($ch);
//释放curl句柄
        curl_close($ch);
//打印获得的数据
        $status=json_decode($output)->status;

        if ($status==0)
        {
            $result=json_decode($output)->result;
            return $result[0]->distance->text;
        }
        else
        {
            return "0公里";
        }
    }
}