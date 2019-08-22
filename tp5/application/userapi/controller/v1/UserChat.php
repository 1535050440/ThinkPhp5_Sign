<?php


namespace app\userapi\controller\v1;


use app\common\exception\ParamException;
use app\common\model\UserModel;
use app\userapi\controller\UserApi;
use think\Request;

class UserChat extends UserApi
{
    /**
     * 发送聊天信息
     * @param Request $request
     * @throws ParamException
     * @author deng    (2019/8/22 0:29)
     */
    public function add(Request $request)
    {
        $content = $request->param('content');
        $to_id = $request->param('to_id');

        if (empty($content)) {
            throw new ParamException('请输入内容');
        }
        if (empty($to_id)) {
            throw new ParamException('请输入选择对应的人');
        }

        $userFind = UserModel::get($request->user->id);

        $userFind->addUserChat($to_id, $content);

        $this->success('发送成功');
    }

}