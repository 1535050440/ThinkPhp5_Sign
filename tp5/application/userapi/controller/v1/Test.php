<?php

namespace app\userapi\controller\v1;

use app\userapi\controller\UserApi;
use think\facade\Env;
use think\Request;

class Test extends UserApi
{
    protected $no_need_token = [
        'test'
    ];

    /**
     * 测试使用
     * @param Request $request
     * @author deng    (2019/8/10 11:37)
     */
    public function test(Request $request)
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


}
