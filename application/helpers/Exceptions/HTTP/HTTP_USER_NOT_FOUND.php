<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:48 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_USER_NOT_FOUND extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$userNotFound_401, Authentication::HTTP_UNAUTHORIZED);
    }
}