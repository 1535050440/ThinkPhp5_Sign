<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/6/23
 * Time: 23:12
 */

namespace app\common\model;


class BannerItemModel extends BaseModel
{
    protected $name = 'banner_item';

    protected $hidden = ['img_id', 'banner_id', 'delete_time'];

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function img()
    {
        return $this->belongsTo('ImageModel', 'img_id', 'id');
    }
}
