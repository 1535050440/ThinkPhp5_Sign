<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/9
 * Time: 23:34
 */

namespace app\common\model;


class CategoryModel extends BaseModel
{
    protected $name = 'category';

    protected $hidden = [
        'add_time',
        'img_id',
        'delete_time',
        'update_time',
        'sort',
        'pid'
    ];

    /**
     * @return \think\model\relation\HasMany
     */
    public function products()
    {
        return $this->hasMany('ProductModel', 'category_id', 'id');
    }

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function img()
    {
        return $this->belongsTo('ImageModel','img_id','id');
    }

    /**
     * 获取栏目列表
     * @param int $list_rows
     * @param int $page
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\exception\DbException
     */
    public static function getCategoryList($list_rows = 10,$page = 1)
    {
        $category = self::with('img')
            ->order('sort asc')
            ->paginate($list_rows,false,['page'=>$page]);

        return $category;
    }

    /**
     * 获取一个栏目下的商品
     * @param $id
     * @param int $list_rows
     * @param int $page
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getCategoryProductList($id, $list_rows = 10, $page = 1)
    {
        $category = self::with(['products','products.img'])
            ->where('id','=',$id)
            ->paginate($list_rows,false,['page'=>$page]);

        return $category;
    }
}
