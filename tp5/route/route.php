<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use \think\facade\Route;

//  ============================================================

//  登陆
Route::get('userapi/v1/login','userapi/v1.Login/login');

//  查询个人信息接口
Route::get('userapi/v1/user/show','userapi/v1.User/show');

Route::get('userapi/v1/user_autograph/copy','userapi/v1.UserAutograph/copy');
Route::get('userapi/v1/user/info_update','userapi/v1.User/updateInfo');
Route::get('userapi/v1/user/info','userapi/v1.User/info');

//  ============================================================
Route::any('demo','userapi/v1.File/addFile');

Route::get('think', function () {
    return 'hethinkllo,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

return [

];
