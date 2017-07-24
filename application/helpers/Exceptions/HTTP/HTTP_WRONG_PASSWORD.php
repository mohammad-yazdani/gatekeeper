<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:51 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_WRONG_PASSWORD extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$wrongPassword_401, Authentication::HTTP_UNAUTHORIZED);
    }
}