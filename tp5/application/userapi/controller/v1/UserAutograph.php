<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/8/7
 * Time: 0:18
 */

namespace app\userapi\controller\v1;


use app\common\exception\ParamException;
use app\common\model\AutographModel;
use app\common\model\UserAutographModel;
use app\common\model\UserModel;
use app\userapi\controller\UserApi;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\facade\Log;
use think\Request;

/**
 * @method static field($string)
 * @method static where($string, $string1, $id)
 */
class UserAutograph extends UserApi
{
    protected $no_need_token = [
        'getAutograph'
    ];

    /**
     * @param Request $request
     * @throws DbException
     * @throws ParamException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @deng      2019/8/7    0:20
     */
    public function copy(Request $request)
    {
        $avatar = $request->user->avatar;
        if (empty($avatar)) {
            throw new ParamException('请先授权微信头像');
        }
        $content = $request->param('content');

        if (empty($content)) {
            $this->success();
        }

        Log::record($content,'demo');

        $contentJson = base64_encode($content);
        Log::record($contentJson,'demo');

        $userFind = UserModel::get($request->user->id);
        $userFind->addUserAutograph($contentJson);

        //  保存到数据库

        //  验证是否格式正确
//        $content = '特3456书yuuo莞6543李zxcz蒜7782法fgnv级完2347全dfji试3726测asad感3847知qwez到';
//        $access_token = $request->user->access_token;
//        $result = curlText($content,$access_token);
//        if ($result->errcode == '87014') {
//            throw new ParamException('内容包含敏感信息，请从新输入！');
//        }


        //  -----------------------------------------------
        $text_len = strlen($content);
//        echo strlen($text_len);exit;
        //  一个中文，3个字符
        //  11个中午，那么可输入33个字符
        //  如果不够33个字符，凑白
        if ($text_len <= 30) {
            $cha = 30 - $text_len;
            $sahng = intval($cha/3);
            //  循环几次
            $i=0;
            $nulll = '';
            for ($i;$i <= $sahng;$i++) {
                $nulll = $nulll.'ICAg';
            }

            //  换行  1rTWtAr
            $demo_left = '1rTWtAr';
            $demo_right = 'ICAg4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';

            //  2.
            $data = base64_decode($demo_left).$content.base64_decode($nulll).base64_decode($demo_right);
            $content_now = base64_encode($data);
            //  11个字符  +自己的字
        } else if ($text_len >30 && $text_len <=50) {
            //  循环几次
            $nulll = '';

            //  换行  1rTWtAr
            $demo_left = '1rTWtAr';
            $demo_right = 'ICAg4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';

            //  2.
            $data = base64_decode($demo_left).$content.base64_decode($demo_right);
            $content_now = base64_encode($data);
        } else {
            $data = $content;
            $content_now = base64_encode($data);
        }

        //  -----------------------------------------------

        $result = [
            'text' => $data,
            'text_base' => $content_now
        ];
        $this->success($result);
    }

    /**
     * @param Request $request
     * @throws DbException
     * @author deng    (2019/8/10 10:47)
     */
    public function index(Request $request)
    {
        $list_rows = $request->param('list_rows')?:30;
        $page = $request->param('page')?:1;
        $user_id = $request->param('user_id');

        $params = [
            'user_id' => $user_id
        ];

        $result = UserAutographModel::getUserAutographList($list_rows,$page,$params);

        $this->success($result);
    }

    /**
     * base64_decode        解密
     * @param Request $request
     * @throws DbException
     */
    public function getAutograph(Request $request)
    {
        $list_rows = $request->param('list_rows')?:30;
        $page = $request->param('page')?:1;

        $result = AutographModel::field('*')
            ->order('order_id asc')
            ->where('is_show','=',1)
            ->paginate($list_rows,false,['page'=>$page]);

        $this->success($result);

    }

}
