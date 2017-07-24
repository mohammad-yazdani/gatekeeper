<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:59 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_TIMEOUT extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$timeout_408, Authentication::HTTP_REQUEST_TIMEOUT);
    }
}