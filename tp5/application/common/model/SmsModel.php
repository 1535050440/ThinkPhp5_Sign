<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/25
 * Time: 23:34
 */

namespace app\common\model;


use app\common\exception\ParamException;
use app\common\service\SmsService;

class SmsModel extends BaseModel
{
    protected $name = 'sms';

    /**
     * @param $mobile
     * @return SmsModel
     */
    public static function addSendSms($mobile)
    {
        $code = rand(1000,9999);

        $data = [
            'mobile'=>$mobile,
            'add_time'=>time(),
            'create_time'=>date('Y-m-d H:i:s'),
            'ip'=>request()->ip(),
            'code' => $code,
            'type_name' => 'REGISTER',
        ];

        $smsFind = self::create($data);

        //  发送短信
        try {
            SmsService::sendSms($mobile,$code);
            $result = 'OK';
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }
        $smsFind->result = $result;
        $smsFind->save();

        return true;
    }

}
