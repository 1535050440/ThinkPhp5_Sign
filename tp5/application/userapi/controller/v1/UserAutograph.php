<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/7
 * Time: 0:18
 */

namespace app\userapi\controller\v1;


use app\common\exception\ParamException;
use app\userapi\controller\UserApi;
use think\facade\Log;
use think\Request;

class UserAutograph extends UserApi
{
    /**
     * @param Request $request
     * @throws ParamException
     * @deng      2019/8/7    0:20
     */
    public function copy(Request $request)
    {
        $content = $request->param('content');

        Log::record(222,'demo');
        //  验证是否格式正确
//        $content = '特3456书yuuo莞6543李zxcz蒜7782法fgnv级完2347全dfji试3726测asad感3847知qwez到';

        $access_token = $request->user->access_token;
        $result = curlText($content,$access_token);

        if ($result->errcode == '87014') {
            throw new ParamException('内容包含敏感信息，请从新输入！');
        }

        $this->success($content);
    }

}
