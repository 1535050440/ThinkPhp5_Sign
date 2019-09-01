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

Route::any('userapi/v1/user/info_update','userapi/v1.User/updateInfo');
Route::get('userapi/v1/user/info','userapi/v1.User/info');
Route::get('userapi/v1/user/list','userapi/v1.User/getUserList');
Route::get('userapi/v1/user/register_count','userapi/v1.User/getRegister');

//  签名
Route::get('userapi/v1/user_autograph/copy','userapi/v1.UserAutograph/copy');
Route::get('userapi/v1/user_autograph/index','userapi/v1.UserAutograph/index');
Route::get('userapi/v1/user_autograph/list','userapi/v1.UserAutograph/getAutograph');
Route::get('userapi/v1/user_autograph/getList','userapi/v1.UserAutograph/getList');

//  聊天
Route::get('userapi/v1/user_chat/add','userapi/v1.UserChat/add');


//  版本更新日志
Route::get('userapi/v1/version/list','userapi/v1.VersionLog/index');

//  ============================================================
Route::any('redis','userapi/v1.Test/redis');
Route::any('test','userapi/v1.Test/test');
Route::any('file','userapi/v1.File/downFile');
Route::any('phpinfo','userapi/v1.Test/info');
Route::any('demo','userapi/v1.File/addFile');

Route::get('think', function () {
    return 'hethinkllo,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

return [

];
