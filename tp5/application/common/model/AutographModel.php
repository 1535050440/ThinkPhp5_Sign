<?php


namespace app\common\model;


class AutographModel extends BaseModel
{
    protected $name = 'autograph';

    public function getTextAttr($value)
    {
        return base64_decode($value);
    }

}