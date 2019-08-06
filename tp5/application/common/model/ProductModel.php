<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/10
 * Time: 0:05
 */

namespace app\common\model;


class ProductModel extends BaseModel
{
    protected $name = 'product';

    protected $hidden = [
//        'img_id',
        'update_time',
        'category_id',
        'add_time'
    ];
    /**
     * 商品图片
     * @return \think\model\relation\BelongsTo
     */
    public function img()
    {
        return $this->belongsTo('ImageModel', 'img_id', 'id');
    }

    public function productImage()
    {
        return $this->hasMany('ProductImageModel','product_id','id');
    }

    /**
     * @param $id
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getProductFind($id)
    {
        return self::with(['img','productImage.img'])
            ->where('id','=',$id)
            ->find();
    }

    /**
     * @param $list_rows
     * @param $page
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public static function getProductList($list_rows,$page, $paramArray = [])
    {
        $query = self::alias('a')
            ->field('a.*')
            ->field('c.from,c.path')
            ->join('category b','a.category_id = b.id')
            ->join('image c','a.img_id = c.id','left');

        if (!empty($paramArray['categoryId'])) {
            $query->where('a.category_id','=',$paramArray['categoryId']);
        }

        $result = $query->paginate($list_rows,false,['page'=>$page]);

        return $result;
    }
}
