<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 5/4/2017
 * Time: 11:31 PM
 */
require_once APPPATH.'helpers/DAO/ClientDAOImpl.php';
require_once APPPATH.'helpers/DAO/DeviceDAOImpl.php';
require_once APPPATH.'helpers/FileSystem/RSA_FileManager.php';
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';
require_once 'UserController.php';
require_once APPPATH.'helpers\JWT\JWT.php';


use models\Client;
use models\DeviceController;
use models\Token;
use models\Device;
use \models\User;
use \Firebase\JWT\JWT;
use \FileSystem\RSA_FileManager;
use \DAO\AuthDAOImpl;

// TODO : Handle existing stuff like existing username and email.
// TODO : DOCUMENTATION

class ClientController extends \Controller
{
    private $deviceDAO;

    private $userDAO;

    function __construct ()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $the_dao = new \DAO\ClientDAOImpl($em);
        $this->dao = $the_dao;
        // TODO : CHANGE
        $this->deviceDAO = new \DAO\DeviceDAOImpl($em);
        $this->userDAO = new \DAO\UserDAOImpl($em);
    }
	
    public function get ($key=NULL, $token = NULL, $check = false)
    {
        $jwt= null;
        if ($check)
        {
            $username = $this->dao->checkForUsername($key);
            $email = $this->dao->checkForEmail($key);

            if (!$username && !$email) return false;
            else
            {
                $result = null;
                if ($username) $result = $this->dao->get($key);
                else $result = $this->dao->get($key);

                return $result;
            }
        }
        else
        {
            $id = $key;
            if ($token != NULL)
            {
                // TODO : Update the token
                // TODO : Echo token
                $key_res = new RSA_FileManager();
                // TODO : THE DECODE PART
                $decoded = (array) JWT::decode($token, $key_res->getKey(), array('RS256'));
                $aud = $decoded['aud'];
                $uid = $decoded['deviceInfo']->uid;
                $deviceCtrl = new DeviceController();
                $device = $deviceCtrl->get($uid);

                $token = (new Token($device, $aud))->jsonSerialize();
                $key_res = new RSA_FileManager();
                $jwt = JWT::encode($token, $key_res->getKey(true), 'RS256');

                echo $jwt;

                if ($key == 'null') $key = null;
                if ($key == NULL)
                {
                    $id = $aud;
                }
            }

            $client = $this->dao->get($id);

            // TODO : If token is NULL make a new device and send a token
            if ($token == NULL)
            {
               $newDevice = null;
               $newDevice = new Device($client->getUsername());
               if (!$this->deviceDAO->save($newDevice)) return false;
               $jwt = AuthDAOImpl::generateKey($newDevice, $client);
               echo $jwt;
            }

            return $client;
        }
    }
	
    public function post ($key = null, $xss_clean = NULL)
    {
        $json = json_decode($key);

        $username = $json->username;
        $email = $json->email;
        $data = $json->data;
        $uid = $json->uid;
        $authId = $json->authId;

        // TODO : REQUEST USER

        $user = new User($data);
        $userId = $this->userDAO->save($user);
        $client = null;

        if ($userId)
        {
            $client = new Client(
                ( string ) $username,
                ( string ) $email,
                $userId,
                $authId
            );
        }
        else return false;

        // TODO : Client is saved, now we have to save their device.
        // TODO : FOR TEST echo "<br/>before saving client<br/>";
        $jwt = null;

        $saveResult = $this->dao->save($client);
        if(
            $saveResult
            //true
        )
        {
            $device = null;
            if ($uid != null)
            {
                $device = $this->deviceDAO->get($json->uid);
            }
            if ($device == null)
            {
                $device = new Device($client->getUsername());
                if (!$this->deviceDAO->save($device)) return false;

                $jwt = AuthDAOImpl::generateKey($device, $client);

                //echo "JWT: \n".$jwt."\n";
            }

            if($this->dao->save($client)) return $jwt;
            else return false;
        }
        return false;
    }

    public function delete($key = NULL, $xss_clean = NULL)
    {
        $json = json_decode($key);
        $clientId = null;
        if ($json->username) $clientId = $json->username;
        elseif ($json->email) $clientId = $json->email;
        else return false;
        // TODO : DELETE DEVICES
        // TODO : DEBUG
        // TODO : HANDLE EXCEPTIONS
        $client = $this->dao->get($clientId);
        $device[] = $this->deviceDAO->getByClient($client->getJSON());
        foreach ($device as $dev)
        {
            $this->deviceDAO->delete($dev);
        }
        if($this->dao->delete($client)) return true;
        else return false;
    }

    public function put ($key = NULL, $xss_clean = NULL)
    {
        // TODO : WARNING! -> TEMPORARY
        return $this->post($key);
    }

    public function REST_GET($id, $token = NULL)
    {
        return $this->get($id, $token);
    }

    public function REST_POST(string $json)
    {
        return $this->post($json);
    }

    public function REST_PUT(string $json)
    {
        $this->put($json);
    }

    public function REST_DELETE(string $json)
    {
        $this->delete($json);
    }

    public function index()
    {
        echo "Access Denied";
    }
}