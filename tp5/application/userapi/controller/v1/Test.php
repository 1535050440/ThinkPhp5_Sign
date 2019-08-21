<?php

namespace app\userapi\controller\v1;

use app\common\exception\ParamException;
use app\common\model\UserSignModel;
use app\userapi\controller\UserApi;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\facade\Cache;
use think\facade\Env;
use think\Request;

class Test extends UserApi
{
    protected $no_need_token = [
        'test',
        'info',
        'downFile',
        'redis'
    ];

    /**
     * 测试使用
     * @param Request $request
     * @author deng    (2019/8/10 11:37)
     */
    public function test1(Request $request)
    {
        $test = '啊';
        $b = strlen($test);


        echo 'test';exit;
        //  指定目录   E:\phpStudy\PHPTutorial\WWW\qq1515551519-sign-tp5\tp5\public\uploads
        $ROOT_PATH = Env::get('root_path');
        $address = $ROOT_PATH . 'public' . DIRECTORY_SEPARATOR . 'uploads'.date('Ymd');

        $img = 'https://www.guangjiaoge.com/images/user/admin.png';
//        $img = 'https://wx.qlogo.cn/mmopen/vi_32/YibZAWyltDS7hjtT302SnCasr5uUu0nSGvHNlgtMN94aicVk49UcYKvicrcIt8v3ianKicYSUbpqqHdtYDHOhIuxgxg/132';
        downloadFile($img,$address);
    }

    public function test()
    {
        $aa  = '【收藏小程序】';
        echo base64_encode($aa);
        exit;
        $text = '4p2k5qyi6L+O5p2l5Yiw5oiR55qE5pyL5Y+L5ZyI4p2k';

        $content = base64_decode($text);

//        print_r($aa);exit;

        $textlen = strlen($content);


        $all = 30*3;

        //  换行  1rTWtAr
        $demo_left = '1rTWtAr';
        $demo_right = 'ICAg4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';

        $demo_left_len = strlen(base64_decode($demo_left));
        $demo_right_len = strlen(base64_decode($demo_right));

        $now = $demo_left_len + $demo_right_len;

        echo $nownow = 90 - ($textlen + $now);

        $count = intval($nownow/3)-5;
        //  循环几次
        echo '循环几次';
        echo $count;
//exit;
        $i=0;
        $nulll = '';
        for ($i;$i < $count;$i++) {
            $nulll = $nulll.'ICAg';
        }
//        echo $nulll;exit;

        //  2.
        $data = base64_decode($demo_left).$content.base64_decode($nulll).base64_decode($demo_right);
        $content_now = base64_encode($data);

        echo $data;
        echo '======';
        echo $content_now;
        exit;


    }

    /**
     * 输出版本信息
     * @return bool
     * @author deng    (2019/8/14 10:28)
     */
    public function info()
    {
        return phpinfo();
    }


    /**
     * 测试使用-
     * @param Request $request
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws ParamException
     * @author deng    (2019/8/17 10:17)
     */
    public function redis(Request $request)
    {
        $expire_time = 60*5;
        $user_id = 6000;
        $key = 'deng_user_sign'.$user_id;
        $key_tp = 'user_sign'.$user_id;
        $egg_order = 25;

        //  先

        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
//        Cache::store('redis')->set($key, $egg_order, $expire_time);
        $redis->select(0);

        //  1.先加锁--再get----在
        $redis_user_locak = $redis->setnx($key,1);

        if ($redis_user_locak) {
            //  true
            Cache::store('redis')->set($key_tp, $egg_order, $expire_time);
            echo '===';
            UserSignModel::create([
                'user_id' => $user_id,
                'add_time' => time(),
                'create_time' => date('Y-m-d H:i:s')
            ]);

        } else {
            $key_tp_xx = $key_tp.rand(1000,999);
            Cache::store('redis')->set($key_tp_xx, $egg_order, $expire_time);
        }

        echo 'success';
        exit;



//        $redis_activity_num = Cache::store('redis')->get($key);
//        Cache::set('user_sign','sign',60*1);
//        Cache::store('redis')->dec($key);
//        exit;
        $redis_data = Cache::store('redis')->get($key);
//        print_r($ca);exit;
        if (empty($redis_data)) {
            //  为空时，进行抽奖
            //  写入缓存
            $redis_user_locak->setnx($key,1);
            Cache::store('redis')->set($key, $egg_order, $expire_time);
            $userSign = UserSignModel::where('user_id','=',$user_id)
                ->lock(true)
                ->find();
            if (!$userSign) {
                UserSignModel::create([
                    'user_id' => $user_id,
                    'add_time' => time(),
                    'create_time' => date('Y-m-d H:i:s')
                ]);
            }
        } else {
            throw new ParamException('您已抽奖');
        }


        echo 'success';
        exit;
        $activity = [
            'id' => 1,  //  活动id
            'start_time' => $start_time,        //  活动开始时间
            'end_time' => $end_time,            //  活动结束时间
        ];
        $array = [
            'activity' => $activity,
        ];


        print_r($array);
        echo 1;exit;

//        $mobile = $request->param('mobile');
//        $a = sendSms($mobile);
//
//        var_dump($a);
//        exit;
//        $mobile = null;
//        isMobile($mobile);
//         使用Redis缓存
//        Cache::store('redis')->set('name','value',3600);
//        Cache::store('redis')->get('name');


    }

    public function downFile()
    {
        echo 'downFiledownFile';
    }

}
