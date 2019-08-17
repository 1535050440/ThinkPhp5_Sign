<?php
/**
 * Created by PhpStorm.
 * User: 12155
 * Date: 2019/8/8
 * Time: 16:36
 */

namespace app\userapi\controller\v1;


use app\common\exception\ParamException;
use app\common\model\SettingModel;
use app\userapi\controller\UserApi;
use think\facade\Env;
use think\Request;

class File extends UserApi
{
    protected $no_need_token = [
        'addFile',
        'downFile'
    ];

    /**
     * mysql 需要保存 path,size,
     * [type] => image/png
     * 获取表单上传文件 例如上传了1001.jpg
     * @author:  deng    (2019/8/8 17:30)
     */
    public function addFile(){
        $file = request()->file('image');
        //  获取文件信息
        $getInfoFile = $file->getInfo();
        // 判断文件大小
        if ($getInfoFile['size'] >= 1024*100) {
            throw new ParamException('超出文件限制');
        }

        //  0:image  1:png
        $type_array = explode('/',$getInfoFile['type']);
        $pattern = '/^[jpg|png]$/';
        if (preg_match($pattern, $type_array['1'])) {
            throw new ParamException('只能上传jpg/png文件');
        }

        //  指定目录   E:\phpStudy\PHPTutorial\WWW\qq1515551519-sign-tp5\tp5\public\uploads
        $ROOT_PATH = Env::get('root_path');
        $address = $ROOT_PATH . 'public' . DIRECTORY_SEPARATOR . 'uploads';

        // 移动到框架应用根目录/uploads/      true/false
        $info = $file->move($address);

        if($info){
            //  成功上传后 获取上传信息
            //  输出 jpg
            //  echo $info->getExtension();

            //  输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //  echo $info->getSaveName();

            //  输出 42a79759f284b767dfcb2a0197904287.jpg
            //  echo $info->getFilename();
        }else{
            // 上传失败获取错误信息
            throw new ParamException($file->getError());
        }
    }

    public function downFile($url = '')
    {
        $url = 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKFmdEQ797aNMwyzpn5m4gGuHMJE8CNHge0Diabadq9guyvXyVxRIT7IbEWrBL2Clh5G6AXQUlwSvA/132';

//        $result = downFileImg($url);

        $result = SettingModel::getSettingFind('web','web_url');

        print_r($result);



//        print_r($result);exit;

    }


}