<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:47 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_UNAUTHORIZED extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$unauthorized_401, Authentication::HTTP_UNAUTHORIZED);
    }
}