<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/6
 * Time: 23:51
 */

namespace app\userapi\controller\v1;


use app\userapi\controller\UserApi;
use think\facade\Log;

class User extends UserApi
{
    public function show()
    {
        Log::record(222,'demo');
        echo 'show';
    }

}
