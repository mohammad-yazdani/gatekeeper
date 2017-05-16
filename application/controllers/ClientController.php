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
use application\helpers\DAO\ClientDAOImpl;
use models\Client;
use models\Device;
use \Crypto\DeviceUID;


// TODO : Handle existing stuff like existing username and email.
// TODO : DOCUMENTATION

class ClientController extends \Controller
{
    private $deviceDAO;

    function __construct ()
    {
        parent::__construct();
        $this->load->library('doctrine');
        $em = $this->doctrine->em;
        $the_dao = new ClientDAOImpl($em);
        $this->dao = $the_dao;
        $this->load->helper('url');
        // TODO : CHANGE
        $this->deviceDAO = new \DAO\DeviceDAOImpl($em);
    }
	
    public function get ($key=NULL, $xss_clean=NULL): Client
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
	
    public function post ($key = null, $xss_clean=NULL)
    {
        $json = json_decode($key);

        // TODO : REQUEST USER
        $userCtrl = new UserController();
        $userId = $userCtrl->post($json->data);

        $client = null;
        if ($userId) $client = new Client(
            ( string ) $json->username,
            ( string ) $json->email,
            $userId,
            $json->authId
            );
        else return false;

        if($this->dao->save($client))
        {
            $device = null;
            if ($json->uid != null)
            {
                $device = $this->deviceDAO->get($json->uid);
            }
            if ($device == null)
            {
                $uidGen = new DeviceUID();
                $device = new Device($uidGen->generateDeviceUID(), $client->getId());
                if (!$this->deviceDAO->save($device)) return false;
            }
            if($this->dao->save($client)) return true;
            else return false;
        }
        else return false;
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

    public function put ($key = null, $xss_clean=NULL)
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