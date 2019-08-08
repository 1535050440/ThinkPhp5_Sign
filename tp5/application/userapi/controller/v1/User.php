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

        $userFind->save();

        $this->success($userFind);
    }

}
