<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:52 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_FORBIDDEN extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$forbidden_403, Authentication::HTTP_FORBIDDEN);
    }
}