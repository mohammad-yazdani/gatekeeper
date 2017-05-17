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
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';
require_once 'UserController.php';

use models\Client;
use models\Device;
use \models\User;


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
	
    public function get ($key=NULL): Client
    {
        $id = $key;
        $client = $this->dao->get($id);
        // TODO : TEST
        if ($client == NULL) return NULL;
        echo "<br/><br/>";
        echo $client->getJSON();

        if ($client == NULL) return null;
        else return $client;
    }
	
    public function post ($key = null)
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
            echo "client object created<br/>";
        }
        else
        {
            return false;
        }

        // TODO : Client is saved, now we have to save their device.

        if($this->dao->save($client))
        {
            $device = null;
            if ($uid != null)
            {
                $device = $this->deviceDAO->get($json->uid);
            }
            if ($device == null)
            {
                $device = new Device($client->getId());
                if (!$this->deviceDAO->save($device)) return false;
            }
            if($this->dao->save($client)) return true;
            else return false;
        }
        else return false;
    }

    public function delete($key = NULL)
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

    public function put ($key = null)
    {
        // TODO : WARNING! -> TEMPORARY
        $this->post($key);
    }

    public function REST_GET($id)
    {
        $this->get($id);
    }

    public function REST_POST(string $json)
    {
        //echo "Posting client 2<br/>";
        //return null;
        $this->post($json);
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