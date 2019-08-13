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
        $aa  = '——版本更新中，请稍等——';
        echo base64_encode($aa);
        exit;
        //  ❤欢迎来到我的朋友圈❤
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

}
