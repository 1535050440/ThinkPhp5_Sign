<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/7/24
 * Time: 23:58
 */

namespace app\common\exception;


class TokenException extends BaseException
{
    public $code = 505;
    public $errorCode = 50000;
    public $msg = 666;

    /**
     * ParamBaseException constructor.
     * @param string $msg
     */
    public function __construct($msg = "请登陆")
    {
        $this->msg = $msg;

    }
}
