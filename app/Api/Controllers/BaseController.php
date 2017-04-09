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

    public function errorNotFound_Me($data)
    {
        return response()->json([
            'status_code'=>'4004',
            'info'=>$data,
        ]);
    }
}