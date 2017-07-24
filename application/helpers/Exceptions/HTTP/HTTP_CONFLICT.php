<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 2:00 PM
 */

namespace Exceptions\HTTP;

use \Authentication;


class HTTP_CONFLICT extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$conflict_409, Authentication::HTTP_CONFLICT);
    }
}