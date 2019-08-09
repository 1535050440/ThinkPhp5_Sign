<?php
/**
 * Created by PhpStorm.
 * User: 12155
 * Date: 2019/8/9
 * Time: 15:53
 */

namespace app\userapi\controller\v1;


use app\common\model\VersionLogModel;
use app\userapi\controller\UserApi;
use think\Request;

class VersionLog extends UserApi
{
    /**
     * @var array
     */
    protected $no_need_token = [
        'index'
    ];

    /**
     * 列表
     * @author:  deng    (2019/8/9 16:25)
     * @param Request $request
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        $list_rows = $request->param('list_rows')?:10;
        $page = $request->param('page')?:1;

        $result = VersionLogModel::getVersionLogList($list_rows, $page);

        $this->success($result);
    }

}