<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/24
 * Time: 20:34
 */

// +----------------------------------------------------------------------
// | 微信设置
// +----------------------------------------------------------------------
return [
    'app_id' => 'wx25158e96f55779ff',
    'secret' => '02a241af046c07e58794a87e2e4efe70',
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?".
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code"
];
