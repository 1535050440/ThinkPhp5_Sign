<?php


namespace app\common\model;


use think\facade\Cache;

class SettingModel extends BaseModel
{
    protected $name = 'setting';

    public static function getSettingFind($key, $value = '')
    {
        $values = Cache::get($key);

        //  检查缓存是否为false
        if (!$values) {
            $values = self::where('key','=',$key)
                ->value('values');
            //  存入缓存(1小时)
            $time = 60 * 60;
            Cache::set('web',$values,$time);
            $values = Cache::get('web');
        }

        $result = json_decode($values);

        if ($value) {
            //  第二个参数存在时，直接返回对应的结果
            return $result->$value;
        }

        return $result;
    }

}