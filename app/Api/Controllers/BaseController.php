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
use phpDocumentor\Reflection\Types\Null_;

class BaseController extends Controller
{
    use Helpers;

    public function errorNotFound_Me($data)
    {
        return response()->json([
            'status_code'=>'4004',
            'info'=>$data,
        ]);
    }

    public function upLoadPhoto($photo,$name,$prefix=null)
    {
        $photoPath='./public/upload/verify';
        $extension = $photo->getClientOriginalExtension();
        $photo->move($photoPath,$name.$prefix.'.'.$extension);
        return $photoPath.'/'.$name.'.'.$extension;
    }
}