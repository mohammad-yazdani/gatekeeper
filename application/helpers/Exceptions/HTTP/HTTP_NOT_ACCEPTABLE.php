<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:58 PM
 */

namespace Exceptions\HTTP;

require_once 'HTTP_EXCEPTION.php';

use \Authentication;

class HTTP_NOT_ACCEPTABLE extends HTTP_EXCEPTION
{
    public function __construct()
    {
        parent::__construct(Authentication::$notAcceptable_406, Authentication::HTTP_NOT_ACCEPTABLE);
    }
}