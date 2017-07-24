<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:55 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_NOT_ALLOWED extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$notAllowed_405, Authentication::HTTP_METHOD_NOT_ALLOWED);
    }
}