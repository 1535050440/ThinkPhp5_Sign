<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/6
 * Time: 23:51
 */

namespace app\userapi\controller\v1;


use app\common\model\UserModel;
use app\userapi\controller\UserApi;
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
     * @deng      2019/8/8    8:12
     */
    public function updateInfo(Request $request)
    {
        $nick_name = $request->param('nick_name');
        $sex = $request->param('sex')==1?1:2;
        $avatar = $request->param('avatar');

        $user_id = $request->user->id;

        $userFind = UserModel::get($user_id);
        $userFind->nick_name = base64_encode($nick_name);
        $userFind->sex = $sex;
        $userFind->avatar = $avatar;

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
     * @throws \think\exception\DbException
     * @deng      2019/8/8    20:37
     */
    public function getUserList(Request $request)
    {
        $list_rows = $request->param('list_rows')?:100;
        $page = $request->param('page')?:1;

        $result = UserModel::getUserList($list_rows, $page);

        $this->success($result);

    }

}
