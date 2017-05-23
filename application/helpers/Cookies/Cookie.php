<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-21
 * Time: 2:24 PM
 */

namespace Cookies;

/**
 * Interface Cookie
 * @package Cookies
 */
interface Cookie
{
    /**
     * @return mixed
     */
    public function retrieveCookie ();

    /**
     * @param  mixed $endPointId
     * @return mixed
     */
    public function sendCookie ($endPointId);

    /**
     * @param $endPointId
     * @return mixed
     */
    public function updateCookie ($endPointId);

    /**
     * @param $endPointId
     * @return mixed
     */
    public function deleteCookie ($endPointId);
}