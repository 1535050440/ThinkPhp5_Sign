<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


function curlText($content,$ACCESS_TOKEN){
    $url = "https://api.weixin.qq.com/wxa/msg_sec_check?access_token=".$ACCESS_TOKEN;
    $file_data = '{ "content":"'.$content.'" }';//$content(需要检测的文本内容，最大520KB)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch , CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
    $output = curl_exec($ch);//发送请求获取结果
    $output=json_decode($output,false);
    curl_close($ch);//关闭会话

    return $output;//返回结果
}

function downloadFile($url, $path = 'images/')
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $file = curl_exec($ch);
    curl_close($ch);
    $filename = pathinfo($url, PATHINFO_BASENAME);
//    echo $path . $filename. 'a';exit;
//    print_r($filename);exit;
    $resource = fopen($path . $filename, 'a');
    fwrite($resource, $file);
    fclose($resource);
}