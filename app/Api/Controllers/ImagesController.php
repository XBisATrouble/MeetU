<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/5/16
 * Time: 21:13
 */

namespace App\Api\Controllers;


use App\Model\Activity;
use Illuminate\Support\Facades\Input;

class ImagesController extends BaseController
{
    public function uploadVerifyPhotos()
    {
        $photo = Input::file('photo');
        $user=$this->getUser();
        $photoPath='./storage/uploads/verify';
        $extension = $photo->getClientOriginalExtension();
        $photo->move($photoPath,$user->idcard.'.'.$extension);
        $user->verify_photo='/storage/uploads/verify/'.$user->idcard.'.'.$extension;
        $user->save();
        return $this->response->array([
            'status_code'=>'2000',
            'info' => '上传成功',
        ]);
    }

    public function uploadActivityPhotos($activity_id)
    {
    }

    public function getActivityPhotos($activity_id)
    {
    }

    public function uploadUserAvatar()
    {
        $photo = Input::file('photo');
        $user=$this->getUser();
        $photoPath='./public/uploads/avatars';
        $extension = $photo->getClientOriginalExtension();
        $photo->move($photoPath,$user->id.'.'.$extension);
        $user->avatar='/public/uploads/avatars/'.$user->id.'.'.$extension;
        $user->save();
        return $this->response->array([
            'status_code'=>'2000',
            'info' => '上传成功',
            'data'=> '/public/uploads/avatars/'.$user->id.'.'.$extension,
        ]);
    }
}