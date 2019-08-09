<?php
/**
 * Created by PhpStorm.
 * User: 12155
 * Date: 2019/8/9
 * Time: 15:53
 */

namespace app\common\model;


class VersionLogModel extends BaseModel
{
    protected $name = 'version_log';

    public function getContentAttr($value)
    {
        if ($value) {
            $result = explode(',',$value);
        } else {
            $result = [];
        }
        return $result;
    }

    /**
     * @param $value
     * @return false|string
     * @author:  deng    (2019/8/9 17:30)
     */
    public function getAddTimeAttr($value)
    {
        return date('Y-m-d H:i',$value);
    }

    /**
     * @param $list_rows
     * @param $page
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * @author:  deng    (2019/8/9 16:29)
     */
    public static function getVersionLogList($list_rows, $page)
    {
        return self::field('*')
            ->paginate($list_rows,false,['page'=>$page]);
    }
}