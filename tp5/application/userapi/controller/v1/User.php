<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/6
 * Time: 23:51
 */

namespace app\userapi\controller\v1;


use AlibabaCloud\Client\Exception\ClientException;
use app\common\exception\ParamException;
use app\common\model\UserModel;
use app\userapi\controller\UserApi;
use DengTp5\AliSms;
use think\exception\DbException;
use think\facade\Log;
use think\Request;

class User extends UserApi
{
    public function show()
    {
        Log::record(222,'demo');
        echo 'show';
    }

    /**
     * 更新用户的微信头像，昵称
     * @param Request $request
     * @throws ParamException
     * @deng      2019/8/8    8:12
     */
    public function updateInfo(Request $request)
    {
        $nick_name = $request->param('nick_name');
        $sex = $request->param('sex');
        $avatar = $request->param('avatar');

        $user_id = $request->user->id;

        $userFind = UserModel::get($user_id);
        if ($nick_name) $userFind->nick_name = base64_encode($nick_name);
        if ($sex)   $userFind->sex = $sex==1?1:2;
        if ($avatar)    $userFind->avatar = $avatar;

        if (!$userFind->add_time) {
            $userFind->add_time = time();
        }

        $userFind->save();

        $this->success($userFind);
    }

    /**
     * @param Request $request
     * @deng      2019/8/8    8:35
     */
    public function info(Request $request)
    {
        $this->success($request->user);
    }

    /**
     * @param Request $request
     * @throws DbException
     * @deng      2019/8/8    20:37
     */
    public function getUserList(Request $request)
    {
        $list_rows = $request->param('list_rows')?:100;
        $page = $request->param('page')?:1;

        $result = UserModel::getUserList($list_rows, $page);

        $this->success($result);

    }

    /**
     * 修改用户的个人信息api
     * nick_name                微信昵称
     * sex                      微信性别
     * avatar                   微信头像
     * @param Request $request
     * @author deng    (2019/8/16 15:30)
     */
    public function updateUserInfo(Request $request)
    {
        $nick_name = $request->param('nick_name');
        $sex = $request->param('sex');
        $avatar = $request->param('avatar');
//        $mobile = $request->param('mobile');
        $birthday = $request->param('birthday');
        $real_name = $request->param('real_name');

        $paramArray = [];
        if ($nick_name) $paramArray['nick_name'] = base64_encode($nick_name);
        if ($sex) $paramArray['sex'] = $sex==1?:2;
        if ($avatar) $paramArray['avatar'] = $avatar;
//        if ($mobile) $paramArray['mobile'] = $mobile;
        if ($birthday) $paramArray['birthday'] = $birthday;
        if ($real_name) $paramArray['real_name'] = $real_name;

        $userFind = UserModel::get($request->user->id);
        $userFind->updateUserInfo($paramArray);

        $this->success('修改成功');

    }

    /**
     * 修改手机号
     * mobile               手机号
     * yzm                  验证码
     * @param Request $request
     * @throws ClientException
     * @author deng    (2019/8/17 9:51)
     */
    public function updateUserMobile(Request $request)
    {
        $mobile = $request->param('mobile');
        $yzm = $request->param('yzm');

        $paramArray = [
            'mobile' => $mobile
        ];
        AliSms::sendSms();

        $userFind = UserModel::get($request->user->id);
        $userFind->updateUserInfo($paramArray);

    }

}
