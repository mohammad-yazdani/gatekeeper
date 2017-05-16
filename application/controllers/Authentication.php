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

use application\helpers\DAO\ClientDAOImpl;

// TODO : DOCUMENTATION

class Authentication extends \Restserver\Libraries\REST_Controller
{
    protected $controller;

    private $clientDAO;

    private function evaluate ($key, $username, $password) : bool
    {
        if ($key) {
            return $this->dao->validateKey($key);
        } elseif ($username && $password) {
            $client = $this->clientDAO->get($username);
            return $this->dao->decrypt($client->getAuthId(), $password);
        } else {
            return false;
        }
    }

    /**
     * Authentication constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
        $em = $this->doctrine->em;
        $dao = new \DAO\AuthDAOImpl($em);
        $this->clientDAO = new ClientDAOImpl($em);
        $this->dao = $dao;
        //$this->dao = n
        $this->controller = null;
        $this->load->helper('url');
    }

    public function index_get()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $id = $this->uri->segment(4);

        if ($this->evaluate($key, $username, $password))
        {
            return $this->controller->REST_GET($id);
        }
    }

    public function index_post()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $json = $this->uri->segment(4);

        if ($this->evaluate($key, $username, $password))
        {
            return $this->controller->REST_POST($json);
        }
    }

    public function index_put()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $json = $this->uri->segment(4);
        if ($this->evaluate($key, $username, $password))
        {
            return $this->controller->REST_PUT($json);
        }
    }

    public function index_delete()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $json = $this->uri->segment(4);
        if ($this->evaluate($key, $username, $password))
        {
            return $this->controller->REST_DELETE($json);
        }
    }
}