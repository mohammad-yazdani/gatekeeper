<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 2:01 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_OPERATION_FAILED extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$operation_failed_501, Authentication::HTTP_NOT_IMPLEMENTED);
    }
}