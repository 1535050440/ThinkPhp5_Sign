<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/6/23
 * Time: 22:42
 */

namespace app\common\model;

/**
 * 轮播图片
 * Class BannerModel
 * @package app\common\model
 */
class BannerModel extends BaseModel
{
    protected $name = 'banner';

    /**
     * @return \think\model\relation\HasMany
     */
    public function items()
    {
        return $this->hasMany('BannerItemModel', 'banner_id', 'id');
    }

    /**
     * @param $id int banner所在位置
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getBannerById($id)
    {
        $banner = self::with(['items','items.img'])
            ->find($id);

        return $banner;
    }

}
