<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:41 PM
 */

namespace Exceptions\HTTP;

/**
 * Class HTTP_EXCEPTION
 * @package Exceptions\HTTP
 */
class HTTP_EXCEPTION extends \Exception
{
    /**
     * HTTP_EXCEPTION constructor.
     * @param string $message
     * @param int $code
     */
    public function __construct($message, $code)
    {
        parent::__construct("", $code);
        http_response_code($code);
        die($message);
    }
}