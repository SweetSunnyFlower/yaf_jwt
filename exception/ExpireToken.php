<?php
/**
 * author : v_gaobingbing@duxiaoman.com
 * createTime : 2020/11/20 1:47 下午
 * description :
 */

class Jwt_Exception_ExpireToken extends Exception {
    /**
     *  Jwt_Exception_ExpireToken constructor.
     * @desc 自己定义参数验证状态码，可以在此处使用日志library库，统一打印日志
     * @param  string  $message
     * @param  int  $code
     * @param  Throwable|null  $previous
     * @throws Exception
     */
    public function __construct($message = "", $code = Refund_Error::ERRNO_TOKEN_EXPIRE, Throwable $previous = null) {
        Refund_UtilLog::addLog(
            Refund_UtilLog::WARNING,
            __METHOD__,
            __LINE__,
            $code,
            $message,
            true,
            $message,
            null,
            2
        );
        parent::__construct($message, $code, $previous);
    }
}