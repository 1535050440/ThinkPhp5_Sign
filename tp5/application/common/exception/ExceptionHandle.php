<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/6/25
 * Time: 23:50
 */

namespace app\common\exception;


use think\exception\Handle;
use think\facade\Config;
use think\facade\Log;

class ExceptionHandle extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    /**
     * @param \Exception $e
     * @return \think\Response|\think\response\Json
     */
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            //  当前异常属于BaseException时
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;

        } else {
            if (Config::get('app_debug')) {
                //  如果当前开启bug调试时，则不做处理，因为会显示比较全的提示错误
                return parent::render($e);
            }
            $this->code = 500;
            $this->msg = 'system_error';
            $this->errorCode = '999';
            //  写入日志
            $this->recordErrorLog($e);
        }

        $request = \think\facade\Request::instance();
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->errorCode,
            'request' => $request->url(),
        ];

        return json($result,$this->code);
    }

    /**
     * 将异常写入日志
     * @param $e
     */
    protected function recordErrorLog($e)
    {
        //  写入日志操作
        Log::record($e->getMessage(),'error');

    }
}
