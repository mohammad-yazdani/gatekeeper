<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/24/2017
 * Time: 11:52 AM
 */

namespace Exceptions\HTTP;

use Authentication;

class HTTP_UNPROCESSABLE_ENTITY extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$unprocessable_422, Authentication::HTTP_UNPROCESSABLE_ENTITY);
    }
}