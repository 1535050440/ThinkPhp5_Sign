<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/26
 * Time: 0:25
 */

namespace app\common\service;


use think\facade\Config;

class SmsService
{
    /**
     * @param $code
     * @return array
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @author:  deng    (2019/7/21 23:50)
     */
    public static function sendSms($mobile,$code)
    {
        $condition = [
            'accessKeyId' => Config('sms.accessKeyId'),
            'accessSecret' => Config('sms.accessSecret'),
            'code' => $code,
            'mobile' => $mobile,
            'signName' => Config('sms.signName'),
            'templateCode' => 'SMS_163852033'
        ];

        $sendSms = \DengTp5\AliSms::sendSms($condition);

    return $sendSms;
}
}
