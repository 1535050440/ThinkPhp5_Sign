<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/9
 * Time: 23:55
 */

namespace app\common\model;


class ThemeModel extends BaseModel
{
    protected $name = 'theme';

    protected $hidden = [
        'delete_time',
        'update_time',
        'head_img_id',
        'top_img_id'
    ];

    /**
     * 一对一管理查询belongsTo
     * @return \think\model\relation\BelongsTo
     */
    public function headImg()
    {
        return $this->belongsTo('ImageModel', 'head_img_id', 'id');
    }

    /**
     * 一对一管理查询belongsTo
     * @return \think\model\relation\BelongsTo
     */
    public function topImg()
    {
        return $this->belongsTo('ImageModel', 'top_img_id', 'id');
    }
    public function products()
    {
        return $this->hasMany('ProductModel','img_id','id');
    }
    public function themeProduct()
    {
        return $this->belongsTo('ThemeProductModel','theme_id','id');
    }

    /**
     * 获取未删除的主题列表
     * @param int $list_rows
     * @param int $page
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getThemeList($list_rows = 10,$page = 1)
    {
        return self::with('headImg,topImg')
            ->where('delete_time','=',null)
            ->paginate($list_rows,false,['page'=>$page]);
    }

    /**
     * @param int $list_rows
     * @param int $page
     * @param array $paramArray
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getThemeProductList($list_rows = 10,$page = 1,$paramArray = [])
    {
        $query = ThemeProductModel::alias('a')
            ->field('a.theme_id')
            ->field('b.*')
            ->field('c.from,c.path')
            ->join('product b','a.product_id = b.id','left')
            ->join('image c','b.img_id = c.id','left');

        if (!empty($paramArray['theme_id'])) {
            $query->where('a.theme_id','=',$paramArray['theme_id']);
        }

        $result = $query->paginate($list_rows,false,['page'=>$page]);

        return $result;
    }

}
