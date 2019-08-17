<?php

namespace app\userapi\controller\v1;

use AlibabaCloud\Client\Exception\ClientException;
use app\common\exception\ParamException;
use app\common\model\UserModel;
use app\userapi\controller\UserApi;
use think\Config;
use think\facade\Cache;
use think\facade\Env;
use think\Request;

class Test extends UserApi
{
    protected $no_need_token = [
        'test',
        'info',
        'downFile'
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
     * @param Request $request
     * @throws ClientException
     * @throws ParamException
     * @author deng    (2019/8/17 10:17)
     */
    public function redis(Request $request)
    {
        $mobile = $request->param('mobile');
        $a = sendSms($mobile);

        var_dump($a);
        exit;
        $mobile = null;
        isMobile($mobile);
        // 使用Redis缓存
        Cache::store('redis')->set('name','value',3600);
        Cache::store('redis')->get('name');


    }

    public function downFile()
    {
        echo 'downFiledownFile';
    }

}
