<?php

namespace app\command;

use app\common\model\UserModel;
use app\common\model\UserSignModel;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;

class Test extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('test')
            ->setDescription('测试使用');;
        // 设置参数
        
    }

    /**
     * @param Input $input
     * @param Output $output
     * @return int|void|null
     * @throws Exception
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws PDOException
     */
    protected function execute(Input $input, Output $output)
    {
        $userList = UserModel::field('id,avatar')
            ->where('avatar','like','%'.'wx.qlogo.cn'.'%')
            ->where('avatar','not null')
            ->select()
            ->toArray();

        echo count($userList);
        echo "\n";


        foreach ($userList as $user) {
            $result = downFile($user['avatar']);

            UserModel::where('id','=',$user['id'])
                ->update(['avatar'=>$result['img_path']]);
            echo '【'.$user['id'].'】==='.$result['img_path'];
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
