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


// TODO : DOCUMENTATION

abstract class Authentication extends \Restserver\Libraries\REST_Controller
{
    protected $controller;

    protected $dao;

    protected $clientDAO;

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

    protected function evaluate ($key, $username, $password) : bool
    {
        if ($key) {
            return $this->dao->validateKey($key);
        } elseif ($username && $password) {
            $client = $this->clientDAO->get($username);
            if ($client == null) {
                echo "Username not found!\n";
                return false;
            }
            return $this->dao->decrypt($client->getAuthId(), $password);
        } else {
            return false;
        }
    }

    abstract public function index_get ();

    abstract public function index_post ();

    abstract public function index_put ();

    abstract public function index_delete ();
}