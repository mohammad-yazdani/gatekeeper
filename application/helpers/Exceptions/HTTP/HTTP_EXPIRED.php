<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:53 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_EXPIRED extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$expired_403, Authentication::HTTP_FORBIDDEN);
    }
}