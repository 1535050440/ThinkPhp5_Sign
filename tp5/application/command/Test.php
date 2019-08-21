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
        for($i = 0;$i<20;$i++) {
            $user_id = 1001;
            $userSign = UserSignModel::where('user_id','=',$user_id)
                ->find();
            if (!$userSign) {
                UserSignModel::create([
                    'user_id' => $user_id,
                    'add_time' => time(),
                    'create_time' => date('Y-m-d H:i:s')
                ]);
                echo '【'.$i.'】\n';
            }

        }

        echo 'success';
        exit;




        $userList = UserModel::field('id,avatar')
//            ->where('id','<',9)
            ->where('id','>=',9)
            ->where('avatar','not null')
            ->select()
            ->toArray();

        foreach ($userList as $user) {
            $avatar = $user['avatar'];
            $result = downFileImg($avatar);

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
