<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/6
 * Time: 23:07
 */

namespace app\userapi\controller\v1;


use app\common\exception\ParamException;
use app\common\service\UserToken;
use app\userapi\controller\UserApi;
use think\Request;

class Login extends UserApi
{
    protected $no_need_token = [
        'login'
    ];

    /**
     * @param Request $request
     * @throws ParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @deng      2019/8/6    23:11
     */
    public function login(Request $request)
    {
        $code = $request->param('code');

        if (empty($code)) {
            throw new ParamException('code参数不能为空');
        }

        $userFind = new UserToken();
        $wxResult = $userFind->getUserToken($code);

        $this->success($wxResult);
    }

}
