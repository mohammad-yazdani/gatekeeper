<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 4:17 PM
 */

require_once APPPATH."controllers/Controller.php";
require_once APPPATH."helpers/DAO/AuthDAOImpl.php";
require_once APPPATH."helpers/DAO/DAOImpl.php";
require_once APPPATH."helpers/DAO/ClientDAOImpl.php";
require_once APPPATH."helpers\Token\DeviceTokenManager.php";

use \DAO\AuthDAOImpl;
use \models\Client;

// TODO : DOCUMENTATION

abstract class Authentication extends \Restserver\Libraries\REST_Controller
{
    protected $controller;

    protected $dao;

    protected $clientDAO;

    static public $badRequest_400 = "<h1>Bad request! (400)</h1>";
    static public $unauthorized_401 = "<h1>Unauthorized access! (401)</h1>";
    static public $forbidden_403 = "<h1>Access forbidden! (403)</h1>";
    static public $expired_403 = "<h1>Expired authentication! (403)</h1>";
    static public $notFound_404 = "<h1>Resource not found! (404)</h1>";
    static public $notAllowed_405 = "<h1>Method not allowed! (405)</h1>";
    static public $notAcceptable_406 = "<h1>Request not acceptable! (406)</h1>";
    static public $timeout_408 = "<h1>Request timeout! (408)</h1>";
    static public $conflict_409 = "<h1>Conflict! (409)</h1>";

    /**
     * Authentication constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
        $em = $this->doctrine->em;
        $dao = new \DAO\AuthDAOImpl($em);
        $this->clientDAO = new \DAO\ClientDAOImpl($em);
        $this->dao = $dao;
        $this->controller = null;
        $this->load->helper('url');

        // TODO : Get and evaluate JWT
    }

    protected function evaluate ($key = NULL, $username = NULL, $password = NULL)
    {
        if ($key)
        {
            // TODO : If not validated report corrupt key: Forbidden!
            $tokenResult = \Token\DeviceTokenManager::validate($key);
            if(!$tokenResult)
            {
                return false;
            }
            else
            {
                return $tokenResult;
            }
        }
        elseif ($username && $password)
        {
            $client = $this->clientDAO->get($username);
            if ($client == null)
            {
                echo "Username not found!\n";
                return false;
            }
            if(!$this->dao->decrypt($client->getAuthId(), $password))
            {
                echo "Wrong password ";
                return false;
            }
            else return true;
        }
        else
        {
            return false;
        }
    }

     protected function validate_client($key): Client
     {
         return $this->clientCtrl->get($this->evaluate($key), null, true);
     }

    abstract public function index_get ();

    abstract public function index_post ();

    abstract public function index_put ();

    abstract public function index_delete ();
}