<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:49 PM
 */

namespace Exceptions\HTTP;

use \Authentication;

class HTTP_INVALID_TOKEN extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$invalidToken_401, Authentication::HTTP_UNAUTHORIZED);
    }
}