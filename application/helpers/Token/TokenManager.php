<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-21
 * Time: 6:28 PM
 */

namespace Token;


/**
 * Interface TokenManager
 * @package Token
 */
interface TokenManager
{
    /**
     * @return mixed
     */
    public function genToken ();


    /**
     * @param $token
     * @return mixed
     */
    public function validateToken ($token);

    /**
     * @param $token
     * @return mixed
     */
    public function updateToken ($token);

    /**
     * @param $token
     * @return mixed
     */
    public function registerToken ($token);

    /**
     * @param $token
     * @return mixed
     */
    public function expireToken ($token);
}