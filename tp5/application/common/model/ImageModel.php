<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/2
 * Time: 23:44
 */

namespace app\common\model;


class ImageModel extends BaseModel
{
    protected $name = 'image';

    protected $hidden = ['delete_time', 'id', 'from'];

    public function getUrlAttr($value, $data)
    {
//        return $this->prefixImgUrl($value, $data);
        return 222;
    }
}
