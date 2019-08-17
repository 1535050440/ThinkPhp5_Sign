<?php

namespace app\command;

use app\common\model\UserModel;
use think\console\Command;
use think\console\Input;
use think\console\Output;

class Test extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('test')
            ->setDescription('测试使用');;
        // 设置参数
        
    }

    protected function execute(Input $input, Output $output)
    {
        $userList = UserModel::field('id,avatar')->where('id','<',200)
            ->where('avatar','not null')
            ->select()
            ->toArray();
//        echo count($userList);exit;
        foreach ($userList as $user) {
            $avatar = $user['avatar'];
            $result = downFileImg($avatar);

            echo $result['img_path'];
            echo "\n";
        }

        echo 'success';
    }
//    protected function execute(Input $input, Output $output)
//    {
//    	// 指令输出
//    	$output->writeln('test');
//    }
}
