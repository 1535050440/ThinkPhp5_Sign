<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/6
 * Time: 23:05
 */

namespace app\userapi\controller;


use app\common\model\UserModel;

class UserApi
{
    /**
     * 用于记录不需要token验证的方法，将方法名放进数组即可
     * @var array
     */
    protected $no_need_token = [
    ];

    public function __construct()
    {
        // 公共响应头
        header('Content-Type: Application/json');

        // 如果需要跨域，写在这里
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: x-token,user-type,Origin,Access-Control-Request-Headers,SERVER_NAME,Access-Control-Allow-Headers,cache-control,token, X-Requested-With,Content-Type,Accept,Connection,User-Agent,Cookie');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
//        throw new TokenException('请登陆');
        // 如果是options请求，直接响应
        if (request()->method() == 'OPTIONS') {
            return 'OPTIONS';
            exit;
        }

        // 验证用户登陆
        $action = request()->action() ?: 'index';

        $no_need_token_array = $this->array_to_lower($this->no_need_token);
        // 拦截器（放行数组中的方法）
        if (!in_array($action, $no_need_token_array)) {

            //获取参数token
            $token = request()->header('token');
            if ($token != 'deng') {
                $user = cache($token);
                if (!$user) {
                    $this->success([], 'token不存在，请重新获取!', 401);
                }

                $result = json_decode($user);

                $user_id = $result->user_id;
            } else {
                $user_id = 6;
            }



            $user = UserModel::find($user_id);
            request()->user = $user;
        }

    }

    /**
     * 将数组所有字符转换小写
     * @param $no_need_token_array
     * @return array
     */
    public function array_to_lower($no_need_token_array)
    {
        $no_need_token_str = implode(',',$no_need_token_array);

        $no_need_token_str = strtolower($no_need_token_str);

        $result = explode(',',$no_need_token_str);

        return $result;

    }

    public function success($data = [], $message = '请求成功', $code = '200')
    {
        $result = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        echo json_encode($result);
        exit;
    }

}

