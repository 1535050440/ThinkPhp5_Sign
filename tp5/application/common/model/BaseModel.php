<?php
/**
 * 基类-模型
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/6/23
 * Time: 22:42
 */

namespace app\common\model;


use think\Model;

class BaseModel extends Model
{
    //自动过滤掉不存在的字段
    protected $field = true;

}
