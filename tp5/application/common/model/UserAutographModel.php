<?php
/**
 * Created by PhpStorm.
 * User: 12155
 * Date: 2019/8/7
 * Time: 10:58
 */

namespace app\common\model;


class UserAutographModel extends BaseModel
{
    protected $name = 'user_autograph';

    public function getAddTimeAttr($value)
    {
        if ($value) {
            $addTime = date('Y-m-d H:i',$value);
        } else {
            $addTime = '';
        }

        return $addTime;
    }

    public function getContentAttr($value)
    {
        if ($value) {
            return htmlentities(base64_decode($value));
        } else {
            return '';
        }

    }

    /**
     * @param $list_rows
     * @param $page
     * @param array $params
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * @deng      2019/8/9    23:04
     */
    public static function getUserAutographList($list_rows,$page, $params = [])
    {
        $query = self::alias('a')
            ->field('a.*')
            ->field('b.nick_name,b.avatar')
            ->join('user b','a.user_id = b.id','right');

        if (!empty($params['user_id'])) {
            if ($params['user_id'] != 8) {
                $query->where('a.user_id','=',$params['user_id']);
            }
        }
        $query->order('a.id desc');

        $result = $query->paginate($list_rows, false, ['page'=>$page]);

        foreach ($result as $value) {
            $value->nick_name = htmlentities(base64_decode($value->nick_name));
        }


        return $result;
    }

    public function addUserAutographFind($user_id)
    {
        $data = [
            'user_id' => $request->user->id,
            'add_time' => time(),
            'content' => $contentJson,
            'create_time' => date('Y-m-d H:i:s'),
        ];

        self::where('user_id','=',$user_id);
    }
}
