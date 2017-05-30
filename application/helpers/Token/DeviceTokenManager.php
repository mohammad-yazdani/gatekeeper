<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-21
 * Time: 6:39 PM
 */

namespace Token;

require_once APPPATH."controllers\Authentication.php";
require_once APPPATH."controllers\ClientController.php";
require_once 'TokenManager.php';

use Authentication;
use FileSystem\RSA_FileManager;
use Firebase\JWT\JWT;
use models\Client;
use models\Device;
use models\DeviceController;
use models\Token;
use \ClientController;

/**
 * Class DeviceTokenManager
 * @package Token
 */
class DeviceTokenManager implements TokenManager
{
    static public function generate(Device $device, Client $client) : string
    {
        $token = (new Token($device, $client->getUsername()))->jsonSerialize();
        $key_res = new RSA_FileManager();
        $jwt = JWT::encode($token, $key_res->getKey(true), 'RS256');

        echo $jwt;

        return $jwt;
    }

    /**
     * @param string $key
     * @return bool
     */
    static public function validate(string $key) : bool
    {
        $result = 1;
        // TODO : Validate JWT:
        // TODO : Validate the issuer, and the info
        $key_res = new RSA_FileManager();
        // TODO : THE DECODE PART
        $decoded = (array) JWT::decode($key, $key_res->getKey(), array('RS256'));

        //print_r($decoded);

        $iss = $decoded['iss'];
        $aud = $decoded['aud'];
        $init = (int) $decoded['init'];
        $exp = (int) $decoded['exp'];
        $uid = $decoded['deviceInfo']->uid;
        $username = $decoded['deviceInfo']->client;
        $passSaved = $decoded['deviceInfo']->passSaved;

        if (!($iss == "gatekeeper")) $result = 0;
        if (!($username == $aud)) $result = 0;
        $deviceCtrl = new DeviceController();
        $device = $deviceCtrl->get($uid);
        if (!$device) $result = 0;
        else $device = $device->getPassIsSaved();

        //if (time() > ($init + $exp)) $result = 2;

        if ($passSaved == 'true') $passSaved = true;
        else $passSaved = false;
        if ($passSaved !== $device) $result = 0;

        /* TODO : FOR TEST
        $passSavedString = "false";
        if ($passSaved) $passSavedString = "true";

        echo "[iss] ".$iss."\n";
        echo "[aud] ".$aud."\n";
        echo "[init] ".$init."\n";
        echo "[exp] ".$exp."\n";

        // TODO : Will be changed for development.
        // echo "[deviceInfo][uid] ".$uid."\n";

        echo "[deviceInfo][client] ".$username."\n";
        echo "[deviceInfo][passSaved] ".$passSavedString."\n";
        */
        // TODO : Compare save password against database

        switch ($result)
        {
            case 0:
                http_response_code(406);
                echo Authentication::$notAcceptable_406;
                return false;
                break;
            case 2:
                http_response_code(403);
                echo Authentication::$expired_403;
                return false;
                break;
            default:
                return true;
        }
    }


    /**
     * @param string $token
     * @return string
     */
    static public function update(string $token) : string
    {
        if (self::validate($token))
        {
            $client = null;
            $device = null;

            $key_res = new RSA_FileManager();
            // TODO : THE DECODE PART
            $decoded = (array) JWT::decode($token, $key_res->getKey(), array('RS256'));

            $aud = $decoded['aud'];
            $uid = $decoded['deviceInfo']->uid;

            $client = (new ClientController())->get($aud);
            $device = (new DeviceController())->get($uid);

            $newToken = self::generate($device, $client);

            return $newToken;
        }
        else
        {
            http_response_code(403);
            echo Authentication::$expired_403;
            return null;
        }
    }
}