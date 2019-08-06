<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/24
 * Time: 22:52
 */

namespace app\common\model;

use app\common\exception\ParamException;
use think\Db;

/**
 * Class UserModel
 * @package app\common\model
 * @method static UserModel get($id)
 */
class UserModel extends BaseModel
{
    protected $name = 'user';

    /**
     * 检查当前openid是否存在，不存在新增用户
     * @param $open_id
     * @return UserModel|array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function addUserOpenID($open_id)
    {
        $userFind = self::where('open_id','=',$open_id)
            ->find();

        if (!$userFind) {
            //  不存在，新增一条
            $userFind = self::create([
                'open_id' => $open_id,
                'add_time' => time()
            ]);
        }

        return $userFind;

    }

    public function addUser($mobile,$open_id)
    {
        $userFind = self::where('open_id','=',$open_id)
            ->find();

        if (!$userFind) {
            //  不存在，新增一条
            $userFind = self::create([
                'open_id' => $open_id,
                'add_time' => time(),
                'nick_name' => base64_encode(mobile_change($mobile)),
                'invite_code' => rand(1000,9999)
            ]);
        }
        if (empty($userFind->mobile)) {
            $userFind->mobile = $mobile;
            $userFind->save();
        }

        return $userFind;
    }

    /**
     * 用户签到
     * @return UserSignModel
     * @throws ParamException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addSign()
    {
        $time_day = strtotime(date('Y-m-d'));
        $status = UserSignModel::where('user_id','=',$this->id)
            ->where('add_time','>=',$time_day)
            ->find();
        if ($status) {
            throw new ParamException('今日已签，请勿重复签到！');
        }

        $data = [
            'user_id' => $this->id,
            'add_time' => time(),
        ];

        return UserSignModel::create($data);
    }

    /**
     * 增加用户的收货地址
     * @deng      2019/8/4    18:36
     * @param $name
     * @param $mobile
     * @param $address
     * @return UserAddressModel
     * @throws ParamException
     */
    public function addAddress($name, $mobile, $detail)
    {
        if (empty($name)) {
            throw new ParamException('性名不能为空');
        }
        if (empty($mobile)) {
            throw new ParamException('手机号不能为空');
        }
        if (empty($detail)) {
            throw new ParamException('收货地址不能为空');
        }
        $data = [
            'user_id' => $this->id,
            'name' => $name,
            'mobile' => $mobile,
            'detail' => $detail,
            'update_time' => time()
        ];
        return UserAddressModel::create($data);
    }

    /**
     * 获取用户的所有收货地址
     * @deng      2019/8/4    20:10
     * @param $list_rows
     * @param $page
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getUserAddressList($list_rows = 10, $page = 1)
    {
        return UserAddressModel::field('*')
            ->where('user_id','=',$this->id)
            ->paginate($list_rows,false,['page'=>$page]);
    }

    /**
     * 获取用户的一条收货地址
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @deng      2019/8/4    20:37
     */
    public function getUserAddressFind()
    {
        return UserAddressModel::field('*')
            ->where('user_id','=',$this->id)
//            ->where('status','=',1)
            ->order('status asc')
            ->find();
    }

    /**
     * @param $orderArray
     * @param int $coin_count
     * @return OrderModel
     * @throws ParamException
     * @deng      2019/8/4    21:39
     */
    public function addOrder($orderArray, $coin_count = 0)
    {
        $add_time = time();
        Db::startTrans();
        try{
            //  创建order表
            $coin_price = $coin_count * 10;
            $data = [
                'order_no' => date('YmdHis').time(),
                'user_id' => $this->id,
                'order_status' => 1,
                'add_time' => $add_time,
                'coin_count' => $coin_count,
                'coin_price' => $coin_price,
                'delivery_status' => 1,
                'receipt_status' => 1,
            ];

            $orderModelFind = OrderModel::create($data);

            //  创建订单商品表
            foreach ($orderArray as $order) {
                $product_id = $order['product_id'];

                if (empty($order['count'])) {
                    throw new ParamException('商品数量只能输入大于1的数');
                }
                $count = $order['count'];

                $productModelFind = ProductModel::get($product_id);
                if (!$productModelFind) {
                    throw new ParamException('当前商品已被下架，请从新选择');
                }


                $data = [
                    'product_id' => $product_id,
                    'product_name' => $productModelFind->name,
                    'img_id' => $productModelFind->img_id,
                    'content' => $productModelFind->summary,
                    'product_price' => $productModelFind->price,
                    'line_price' => $productModelFind->price,
                    'total_num' => $count,
                    'total_price' => $productModelFind->price * $count,
                    'order_id' => $orderModelFind->id,
                    'user_id' => $this->id,
                    'add_time' => $add_time
                ];
                $orderData[] = $data;

            }

            $OrderProductModel = new OrderProductModel();
            $OrderProductModel->saveAll($orderData);

            //  添加order_address
            $userFind = UserModel::get($this->id);
            $getUserAddressFind = $userFind->getUserAddressFind();

            $orderAddress = [
                'order_address_id' => $getUserAddressFind->id,
                'name' => $getUserAddressFind->name,
                'mobile' => $getUserAddressFind->mobile,
//                'province_id' => $getUserAddressFind->province_id,
//                'city_id' => $getUserAddressFind->city_id,
//                'region_id' => $getUserAddressFind->region_id,
                'detail' => $getUserAddressFind->detail,
                'order_id' => $orderModelFind->id,
                'user_id' => $this->id,
                'add_time' => $add_time
            ];
            OrderAddressModel::create($orderAddress);

            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            throw new ParamException($e->getMessage());
        }

        return $orderModelFind;
    }

}
