<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-21
 * Time: 6:28 PM
 */

namespace Token;
use models\Client;
use models\Device;


/**
 * Interface TokenManager
 * @package Token
 */
interface TokenManager
{
    static public function generate (Device $device, Client $client) : string;

    static public function validate (string $key);

    static public function update (string $token) : string ;
}