<?php
/**
 * Created by PhpStorm.
 * User: 14155
 * Date: 2019/6/23
 * Time: 23:21
 */

namespace app\common\exception;


class ParamException extends BaseException
{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = 666;

    /**
     * ParamBaseException constructor.
     * @param string $msg
     */
    public function __construct($msg = "参数错误")
    {
        $this->msg = $msg;

    }
}
