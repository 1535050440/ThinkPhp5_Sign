<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/10
 * Time: 23:57
 */

namespace app\common\model;


class ProductImageModel extends BaseModel
{
    protected $name = 'product_image';

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function img()
    {
        return $this->belongsTo('ImageModel','img_id','id');
    }

}
