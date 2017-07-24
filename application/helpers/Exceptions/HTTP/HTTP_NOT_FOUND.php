<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-23
 * Time: 1:38 PM
 */

namespace Exceptions\HTTP;

require_once 'HTTP_EXCEPTION.php';

use \Authentication;

/**
 * Class HTTP_NOT_FOUND
 * @package Exceptions\HTTP
 */
class HTTP_NOT_FOUND extends HTTP_EXCEPTION
{
    /**
     * HTTP_NOT_FOUND constructor.
     */
    public function __construct()
    {
        parent::__construct(Authentication::$notFound_404, Authentication::HTTP_NOT_FOUND);
    }
}