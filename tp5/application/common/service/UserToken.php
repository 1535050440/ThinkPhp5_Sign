<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/24
 * Time: 20:39
 */

namespace app\common\service;


use app\common\exception\ParamException;
use app\common\model\UserModel;
use DengTp5\WxLogin;
use think\facade\Config;

/**
 * Class UserToken
 * @package app\common\service
 */
class UserToken
{
    /**
     * @param $code
     * @return mixed
     * @throws ParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserToken($code)
    {
        $paramArray = [
            'app_id' => Config('wx.app_id'),
            'secret' => Config('wx.secret'),
            'login_url' => Config('wx.login_url'),
        ];

        $wxLogin = new WxLogin($paramArray, $code);
        $wxResult = $wxLogin->get();

        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回
            // 这种情况通常是由于传入不合法的code
            throw new ParamException('获取session_key及openid异常，微信内部错误');
        }

        // 建议用明确的变量来表示是否成功
        // 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
        // 这样非常不好判断，只能使用errcode是否存在来判断
        $loginFail = array_key_exists('errcode',$wxResult);

        if ($loginFail) {
            throw new ParamException($wxResult['errmsg']);
        }

        $open_id = $wxResult['openid'];
        $userFind = UserModel::where('open_id','=',$open_id)
            ->find();

        if (!$userFind) {
            //  openid不存在时，新增一条
            $data = [
                'open_id' => $open_id,
                'add_time' => time()
            ];

            $userFind = UserModel::create($data);
        }
        //
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.Config('wx.app_id').'&secret='.Config('wx.secret');
        $html = file_get_contents($url);

        $html = json_decode($html);
        $userFind->access_token = $html->access_token;
        $userFind->save();

        $token = $this->grantToken($wxResult);

        if ($userFind->avatar) {
            $status = true;
        } else {
            $status = false;
        }

        $result = [
            'status' => $status,
            'token' => $token
        ];

        return $result;
    }



    //  模拟发送get方式发送http请求微信服务器

    public function get()
    {
        //  发送get请求(字符串)
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);

        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回
            // 规则摸索出来的
            // 这种情况通常是由于传入不合法的code
            throw new ParameException('获取session_key及openid异常，微信内部错误');
        }

        // 建议用明确的变量来表示是否成功
        // 微信服务器并不会将错误标记为400，无论成功还是失败都标记成200
        // 这样非常不好判断，只能使用errcode是否存在来判断
        $loginFail = array_key_exists('errcode',$wxResult);

        if ($loginFail) {
            throw new ParameException($wxResult['errmsg']);
        }

//        return $this->grantToken($wxResult);
    }

    /**
     * 根据获取的openid 查询用户表
     * @param $wxResult
     * @return string
     * @throws ParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function grantToken($wxResult)
    {
        //  拿到openid
        //  检查当前openid是否已经存在        1.如果存在，则不做处理，       2.如果不存在那么新增一条user记录
        //  生成令牌，准备缓存数据，写入缓存
        //  把令牌返回到客户端去
        //  key:令牌
        //  value wxResult,user_id,scope

        //  获取微信返回的openid
        $openid = $wxResult['openid'];

        //  1.如果存在，则不做处理，       2.如果不存在那么新增一条user记录
        $userFind = UserModel::addUserOpenID($openid);

        //  拼接-缓存数组
        $cacheValue = $this->prepareCacheValue($wxResult,$userFind->id);

        return $this->saveToken($cacheValue);
    }

    /**
     * 拼接缓存数据
     * @param $wxResult
     * @param $user_id
     * @return
     */
    private function prepareCacheValue($wxResult,$user_id)
    {
        $cacheValue['openid'] = $wxResult['openid'];
        $cacheValue['session_key'] = $wxResult['session_key'];
        $cacheValue['user_id'] = $user_id;

        return $cacheValue;
    }


    /**
     *  添加缓存数据
     * @param $cacheValue
     * @return string
     * @author:  deng    (2019/4/10 11:22)
     * @throws ParamException
     */
    private function saveToken($cacheValue)
    {
        //  生产令牌的方法
        $key = $this->createToken();

        //  数组格式转换json字符串
        $value = json_encode($cacheValue);

        $expire_in = Config('setting.token_expire_in');

        $result = cache($key, $value , $expire_in);

        if (!$result) {
            throw new ParamException('服务器缓存异常');
        }

        return $key;
    }

    /**
     * @return string|null
     */
    public function createToken()
    {
        $length = 30;
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }

    /**
     * @param $code
     * @return mixed
     * @throws ParamException
     */
    public function getWeChatOpenId($code)
    {
        $paramArray = [
            'app_id' => Config('wx.app_id'),
            'secret' => Config('wx.secret'),
            'login_url' => Config('wx.login_url'),
        ];

        $wxLogin = new WxLogin($paramArray, $code);
        $wxResult = $wxLogin->get();

        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回
            // 这种情况通常是由于传入不合法的code
            throw new ParamException('获取session_key及openid异常，微信内部错误');
        }

        return $wxResult;
    }
}
