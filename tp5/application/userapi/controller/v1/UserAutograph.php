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
        'getAutograph',
        'getList'
    ];

    /**
     * @param Request $request
     * @throws DbException
     * @throws ParamException
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @deng      2019/8/7    0:20
     */
//    public function copy_xx(Request $request)
//    {
//        $avatar = $request->user->avatar;
//        if (empty($avatar)) {
//            throw new ParamException('请先授权微信头像');
//        }
//        $content = $request->param('content');
//
//        if (empty($content)) {
//            $this->success();
//        }
//
//        Log::record('输入的内容为：'.$content,'demo');
//
//        $contentJson = base64_encode($content);
//        Log::record($contentJson,'demo');
//
//        $userFind = UserModel::get($request->user->id);
//        $userFind->addUserAutograph($contentJson);
//
//        //  保存到数据库
//        //  验证是否格式正确
////        $content = '特3456书yuuo莞6543李zxcz蒜7782法fgnv级完2347全dfji试3726测asad感3847知qwez到';
////        $access_token = $request->user->access_token;
////        $result = curlText($content,$access_token);
////        if ($result->errcode == '87014') {
////            throw new ParamException('内容包含敏感信息，请从新输入！');
////        }
//
//
//        //  -----------------------------------------------
//        $text_len = strlen($content);
////        echo strlen($text_len);exit;
//        //  一个中文，3个字符
//        //  11个中午，那么可输入33个字符
//        //  如果不够33个字符，凑白
//        if ($text_len <= 30) {
//            $cha = 30 - $text_len;
//            $sahng = intval($cha/3);
//            //  循环几次
//            $i=0;
//            $nulll = '';
//            for ($i;$i <= $sahng;$i++) {
//                $nulll = $nulll.'ICAg';
//            }
//
//            //  换行  1rTWtAr
//            $demo_left = '1rTWtAr';
//            $demo_right = 'ICAg4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';
//
//            //  2.
//            $data = base64_decode($demo_left).$content.base64_decode($nulll).base64_decode($demo_right);
//            $content_now = base64_encode($data);
//            //  11个字符  +自己的字
//        } else if ($text_len >30 && $text_len <=80) {
//            //  循环几次
//
//            $textlen = strlen($content);
//
//
//            $all = 30*3;
//
//            //  换行  1rTWtAr
//            $demo_left = '1rTWtAr';
//            $demo_right = 'ICAg4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';
//
//            $demo_left_len = strlen(base64_decode($demo_left));
//            $demo_right_len = strlen(base64_decode($demo_right));
//
//            $now = $demo_left_len + $demo_right_len;
//
//            $nownow = 90 - ($textlen + $now);
//
//            $count = intval($nownow/3)-5;
//            //  循环几次
////            echo '循环几次';
////            echo $count;
//            $i=0;
//            $nulll = '';
//            for ($i;$i < $count;$i++) {
//                $nulll = $nulll.'ICAg';
//            }
//
//            $data = base64_decode($demo_left).$content.base64_decode($nulll).base64_decode($demo_right);
//            $content_now = base64_encode($data);
//        } else {
//            $data = $content;
//            $content_now = base64_encode($data);
//        }
//
//        //  -----------------------------------------------
//
//        $result = [
//            'text' => $data,
//            'text_base' => $content_now
//        ];
//        $this->success($result);
//    }
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

        //  是否定义过
        $statusText = $this->checkCopy($content);
        if ($statusText['status']) {
            $result = [
                'text' => base64_decode($statusText['text']),
                'text_base' => $statusText['text']
            ];
            $this->success($result);
        }

        Log::record('输入的内容为：'.$content,'demo');

        $contentJson = base64_encode($content);
        Log::record($contentJson,'demo');

        $userFind = UserModel::get($request->user->id);
        $userFind->addUserAutograph($contentJson);

        //  -----------------------------------------------

        //  1.计算当前输入的所占字符数量
        $text_len = strlen($content);

        //  一个中文，3个字符,11个中午，那么可输入33个字符,如果不够33个字符，凑白
        if ($text_len <=80) {
            //  循环几次

            $textlen = strlen($content);

            //  换行  1rTWtAr
            $demo_left = '1rTWtAr';
            $demo_right = '4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';

            $demo_left_len = strlen(base64_decode($demo_left));
            $demo_right_len = strlen(base64_decode($demo_right));

            $now = $demo_left_len + $demo_right_len;

            $nownow = 90 - ($textlen + $now);

            $count = intval($nownow/3)-6;
//            $count = intval($nownow/3)-5;
            //  循环几次
            $nulll = '';
            for ($i = 0;$i < $count;$i++) {
                $nulll = $nulll.'ICAg';
            }

            $data = base64_decode($demo_left).$content.base64_decode($nulll).base64_decode($demo_right);
            $content_now = base64_encode($data);

            Log::record($content_now,'demo');
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

    public function checkCopy($content)
    {
        $status = false;
        $text = '';

        switch ($content) {
            case '4p2k5q+U6LW35Zac5qyi5pu05Yqg5Zac5qyi5YGP54ix4p2k':
                //  ❤比起喜欢更加喜欢偏爱❤【0】77
                $text = '1rTWtArinaTmr5TotbfllpzmrKLmm7TliqDllpzmrKLlgY/niLHinaQgICAgICAgICAgICDigIPigIPigIPigIPigIPWtNa0CgoK1rQ=';
                $status = true;
                break;
            case '4p2k5qyi6L+O5p2l5Yiw5oiR55qE5pyL5Y+L5ZyI4p2k':
                //  ❤欢迎来到我的朋友圈❤【1】74
                $text = '1rTWtArinaTmrKLov47mnaXliLDmiJHnmoTmnIvlj4vlnIjinaQgICAgICAgICAgICDigIPigIPigIPigIPigIPWtNa0CgoK1rQ=';
                break;
            case '8J+UiVRB5pyA6L+R5LiJ5aSp55yL5LqG5L2g5pyL5Y+L5ZyIOeasoQ==':
                //  TA最近三天看了你朋友圈9次【1】
                $text = '1rTWtArwn5SJVEHmnIDov5HkuInlpKnnnIvkuobkvaDmnIvlj4vlnIg55qyhICAgICAg4oCD4oCD4oCD4oCD4oCD1rTWtAoKCta0';
                break;
            default:
                break;
        }

        $result = [
            'text' => $text,
            'status' => $status
        ];

        return $result;
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

    /**
     * @param Request $request
     * @throws DbException
     * @author deng    (2019/8/13 14:09)
     */
    public function getList(Request $request)
    {
        $list_rows = 100;
        $page = 1;

        $getUserAutographModel = UserAutographModel::field('id,content')
            ->paginate($list_rows,false,['page'=>$page]);

        $this->success($getUserAutographModel);

    }

}
