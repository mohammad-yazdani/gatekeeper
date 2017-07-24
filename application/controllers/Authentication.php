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
require_once APPPATH."helpers\Exceptions\HTTP\HTTP_USER_NOT_FOUND.php";

use \DAO\AuthDAOImpl;
use \models\Client;
use controllers\DeviceController;
use \models\Device;

// TODO : CLEAN-CODE

/**
 * Class Authentication
 */
abstract class Authentication extends \Restserver\Libraries\REST_Controller
{
    /**
     * @var null
     */
    protected $controller;
    /**
     * @var AuthDAOImpl
     */
    protected $dao;
    /**
     * @var \DAO\ClientDAOImpl
     */
    protected $clientDAO;
    /**
     * @var ClientController
     */
    private $clientCtrl;

    /**
     * @var DeviceController
     */
    private $deviceCtrl;

    /**
     * @var string
     */
    static public $badRequest_400 = "bad_request";
    /**
     * @var string
     */
    static public $unauthorized_401 = "unauthorized_access";
    /**
     * @var string
     */
    static public $userNotFound_401 = "username_not_found";
    /**
     * @var string
     */
    static public $invalidToken_401 = "invalid_token";
    /**
     * @var string
     */
    static public $wrongPassword_401 = "wrong_password";
    /**
     * @var string
     */
    static public $forbidden_403 = "access_forbidden";
    /**
     * @var string
     */
    static public $expired_403 = "expired_authentication";
    /**
     * @var string
     */
    static public $notFound_404 = "resource_not_found";
    /**
     * @var string
     */
    static public $notAllowed_405 = "method_not_allowed";
    /**
     * @var string
     */
    static public $notAcceptable_406 = "request_not_acceptable";
    /**
     * @var string
     */
    static public $timeout_408 = "request_timeout";
    /**
     * @var string
     */
    static public $conflict_409 = "conflict";
    /**
     * @var string
     */
    static public $unprocessable_422 = "cannot_process_entity";
    /**
     * @var string
     */
    static public $operation_failed_501 = "operation_failed";

    /**
     * Authentication constructor.
     */
    public function __construct ()
    {
        parent::__construct();
        $this->load->library('doctrine');
        $em = $this->doctrine->em;
        $dao = new \DAO\AuthDAOImpl($em);
        $this->clientDAO = new \DAO\ClientDAOImpl($em);
        $this->dao = $dao;
        $this->controller = null;
        $this->clientCtrl = new ClientController();
        $this->deviceCtrl = new DeviceController();
        $this->load->helper('url');
    }

    /**
     * @param $token
     * @return null|bool
     * @throws \Exceptions\HTTP\HTTP_INVALID_TOKEN
     */
    private function evaluate_token ($token)
    {
        $tokenResult = \Token\DeviceTokenManager::validate($token);
        if (strlen($tokenResult) > 0)
        {
            return $token;
        }
        throw new \Exceptions\HTTP\HTTP_INVALID_TOKEN();
    }

    /**
     * @param $username
     * @param $password
     * @param null|string $device
     * @return string
     * @throws \Exceptions\HTTP\HTTP_USER_NOT_FOUND
     * @throws \Exceptions\HTTP\HTTP_WRONG_PASSWORD
     */
    private function evaluate_credential ($username, $password, $device = "")
    {
        $client = $this->clientDAO->get($username);
        if ($client == null)
        {
            throw new \Exceptions\HTTP\HTTP_USER_NOT_FOUND();
        }
        if(!$this->dao->decrypt($client->getAuthId(), $password))
        {
            throw new \Exceptions\HTTP\HTTP_WRONG_PASSWORD();
        }

        if (!$device)
        {
            $agent = $this->input->request_headers()['User-Agent'];
            $device = new Device($client->getUsername(), $agent);
        }
        else $device = $this->deviceCtrl->get($device);
        return $this->dao->get_key($client, $device);
    }

    /**
     * @return null|object|bool
     */
    protected function authorize()
    {
        try
        {
            $headers = $this->input->request_headers();
            if (!isset($headers['token'])) throw new Exception();
            $token = $headers['token'];
            $result =  $this->evaluate_token($token);
            if ($result)
            {
                $this->output->set_header('token: '.$this->update_token($token));
            }
            return $result;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    /**
     * @return Client|null|bool|object
     */
    protected function register_credentials()
    {
        try
        {
            $headers = $this->input->request_headers();
            if(!isset($headers['username']) || !isset($headers['password'])) throw new Exception();
            $username = $headers['username'];
            $password = $headers['password'];
            die($this->evaluate_credential($username, $password));
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    protected function update_token($token)
    {
        return \Token\DeviceTokenManager::update($token);
    }

    /**
     *
     */
    public function index()
    {
        die("Access Denied");
    }

    /**
     * @return mixed
     */
    abstract public function index_get ();

    /**
     * @return mixed
     */
    abstract public function index_post ();

    /**
     * @return mixed
     */
    abstract public function index_put ();

    /**
     * @return mixed
     */
    abstract public function index_delete ();
}