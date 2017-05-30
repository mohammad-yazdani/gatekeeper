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

use \DAO\AuthDAOImpl;

// TODO : DOCUMENTATION

abstract class Authentication extends \Restserver\Libraries\REST_Controller
{
    protected $controller;

    protected $dao;

    protected $clientDAO;

    static protected $badRequest_400 = "<h1>Bad request! (400)</h1>";
    static protected $unauthorized_401 = "<h1>Unauthorized access! (401)</h1>";
    static protected $forbidden_403 = "<h1>Access forbidden! (403)</h1>";
    static protected $notFound_404 = "<h1>Resource not found! (404)</h1>";
    static protected $notAllowed_405 = "<h1>Method not allowed! (405)</h1>";
    static protected $notAcceptable_406 = "<h1>Request not acceptable! (406)</h1>";
    static protected $timeout_408 = "<h1>Request timeout! (408)</h1>";
    static protected $conflict_409 = "<h1>Conflict! (409)</h1>";

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
        //$this->dao = n
        $this->controller = null;
        $this->load->helper('url');
    }

    protected function evaluate ($key = NULL, $username = NULL, $password = NULL) : bool
    {
        if ($key)
        {
            // TODO : If not validated report corrupt key: Forbidden!
            if(!AuthDAOImpl::validateKey($key))
            {
                //http_response_code(403);
                echo " token ";
                return false;
            }
            else return true;
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

    abstract public function index_get ();

    abstract public function index_post ();

    abstract public function index_put ();

    abstract public function index_delete ();
}