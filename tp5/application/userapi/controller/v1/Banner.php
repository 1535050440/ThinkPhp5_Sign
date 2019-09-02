<?php


namespace app\userapi\controller\v1;


use app\common\exception\ParamException;
use app\common\model\BannerModel;
use app\userapi\controller\UserApi;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Banner extends UserApi
{
    protected $no_need_token = [
        'getBannerList',
    ];


    /**
     * @param Request $request
     * @throws ParamException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function getBannerList(Request $request)
    {
        $id = $request->param('id');
        if (empty($id)) {
            throw new ParamException('参数错误');
        }

        $getBanner = BannerModel::getBannerById($id);

        $this->success($getBanner);

    }
}
