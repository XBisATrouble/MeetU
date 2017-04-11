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

    public function errorNotFound_Me($data)
    {
        return response()->json([
            'status_code'=>'4004',
            'info'=>$data,
        ]);
    }
}