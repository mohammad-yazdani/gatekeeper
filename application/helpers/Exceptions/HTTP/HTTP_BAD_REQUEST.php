<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:45 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_BAD_REQUEST extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$badRequest_400, Authentication::HTTP_BAD_REQUEST);
    }
}