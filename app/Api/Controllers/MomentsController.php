<?php
/**
 * Created by PhpStorm.
 * User: 10656
 * Date: 2017/5/27
 * Time: 12:35
 */

namespace App\Api\Controllers;


use App\Model\Moment;
use Illuminate\Http\Request;

class MomentsController extends BaseController
{


    /**
     * MomentsController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.api.auth')->except('show','index');
    }

    public function store(Request $request)
    {
        $data=[
            'title'=>$request->get('title'),
            'content'=>$request->get('content'),
            'location'=>$request->get('location'),
            'votes_count'=>0,
            'comments_count'=>0,
            'user_id'=>$this->getUser()->id,
        ];

        $moment=Moment::create($data);
        return $this->response->array([
            'status_code'=>2000,
            'info'=> 'success',
            'data'=>$moment,
        ]);
    }

    public function index()
    {
        $moments=Moment::latest('updated_at')
            ->with('user')
            ->paginate(20);

        $moments_info=[];
        foreach ($moments as $moment) {
            $moments_info[]=$moment;
        }

        $total=$moments->count();

        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'data'=>$moments_info,
        ]);
    }

    public function show($id)
    {
        $moment=Moment::with('user')->find($id);

        if($moment==null)
        {
            return $this->response->array([
                'status_code'=>'4004',
                'info'=>'未找到相关信息',
            ]);
        }

        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'data'=>$moment,
        ]);
    }

    public function destroy($id)
    {
        $moment=Moment::find($id);
        if($moment==null)
        {
            return $this->response->array([
                'status_code'=>'4004',
                'info'=>'未找到相关信息',
            ]);
        }
        if($moment->user_id!=$this->getUser()->id)
        {
            return $this->response->array([
                'status_code'=>'4030',
                'info'=>'您没有权限进行此操作',
            ]);
        }
        if(!$moment->delete())
        {
            return $this->response->array([
                'status_code'=>'5000',
                'info'=>'服务器出错',
            ]);
        }
        else
        {
            return $this->response->array([
                'status_code'=>'2000',
                'info'=>'操作成功',
            ]);
        }
    }

    public function followingsFeed()
    {
        $user=$this->getUser();
        $moments=$user->momentFeed()->get();
        $total=$moments->count();
        return $this->response->array([
            'status_code'=>'2000',
            'info'=>'success',
            'total'=>$total,
            'data'=>$moments,
        ]);
    }
}