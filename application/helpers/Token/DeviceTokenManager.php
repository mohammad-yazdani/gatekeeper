<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-21
 * Time: 6:39 PM
 */

namespace Token;


/**
 * Class DeviceTokenManager
 * @package Token
 */
class DeviceTokenManager implements TokenManager
{

    private static $minRandomInt = 1000000001;
    private static $maxRandomInt = 9999999998;

    /**
     * @return mixed
     */
    public function genToken()
    {
        // TODO : Get a random string.
        $random = random_int(self::$minRandomInt, self::$maxRandomInt);
        // TODO : Seed the constructor.

        // TODO : Return the object.
        return null;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function validateToken($token)
    {
        // TODO: Get token auth string.
        // TODO : Decrypt against server's private key.
        // TODO : Validate message against hash table.
        // TODO : Return results.
    }


    /**
     * @param $token
     * @return mixed
     */
    public function updateToken($token)
    {
        // TODO: Implement updateToken() method.
    }

    /**
     * @param $token
     * @return mixed
     */
    public function registerToken($token)
    {
        // TODO: Implement registerToken() method.
    }

    /**
     * @param $token
     * @return mixed
     */
    public function expireToken($token)
    {
        // TODO: Implement expireToken() method.
    }

}