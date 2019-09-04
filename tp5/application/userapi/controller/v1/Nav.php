<?php


namespace app\userapi\controller\v1;


use app\common\model\NavModel;
use app\userapi\controller\UserApi;
use think\Request;

class Nav extends UserApi
{
    protected $no_need_token = [
        'index'
    ];

    public function index(Request $request)
    {
        $list_rows = $request->param('list_rows')?:10;

        $getNavList = NavModel::where('status','=',1)
            ->paginate($list_rows);

        $this->success($getNavList);

    }

}