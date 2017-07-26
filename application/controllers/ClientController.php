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
require_once APPPATH.'helpers\Exceptions\HTTP\HTTP_NOT_ACCEPTABLE.php';


use models\Client;
use controllers\DeviceController;
use models\Token;
use models\Device;
use \models\User;
use \Firebase\JWT\JWT;
use \FileSystem\RSA_FileManager;
use Exceptions\HTTP;

// TODO : CLEAN CODE

/**
 * @property \DAO\ClientDAOImpl dao
 */
class ClientController extends \Controller
{
    /**
     * @var \DAO\DeviceDAOImpl
     */
    private $deviceDAO;
    /**
     * @var \DAO\UserDAOImpl
     */
    private $userDAO;

    /**
     * ClientController constructor.
     */
    function __construct ()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $the_dao = new \DAO\ClientDAOImpl($em);
        $this->dao = $the_dao;
        $this->deviceDAO = new \DAO\DeviceDAOImpl($em);
        $this->userDAO = new \DAO\UserDAOImpl($em);
    }

    /**
     * @param string $name
     * @param null $config
     * @return null|object
     * @throws HTTP\HTTP_USER_NOT_FOUND
     */
    public function get (string $name, $config = NULL)
    {
        $client = $this->dao->get($name);
        if (!$client) throw new HTTP\HTTP_USER_NOT_FOUND();
        http_response_code(Authentication::HTTP_ACCEPTED);
        die($client->getJSON());
    }

    /**
     * @param string $name
     * @param null $config
     * @return null|object
     * @throws HTTP\HTTP_USER_NOT_FOUND
     */
    public function get_object (string $name, $config = NULL)
    {
        $client = $this->dao->get($name);
        if (!$client) throw new HTTP\HTTP_USER_NOT_FOUND();
        http_response_code(Authentication::HTTP_ACCEPTED);
        return $client;
    }

    /**
     * If name exists, it's 302 other wise 200
     * @param string $name
     * @throws HTTP\HTTP_NOT_ACCEPTABLE
     */
    public function unauthorized_get($name)
    {
        if (!$name) throw new HTTP\HTTP_NOT_ACCEPTABLE();
        $username = $this->dao->checkForUsername($name);
        $email = $this->dao->checkForEmail($name);
        if (!$username && !$email)
        {
            http_response_code(Authentication::HTTP_OK);
            die("");
        }
        if ($username)
        {
            http_response_code(Authentication::HTTP_FOUND);
            echo "username";
        }
        echo "\n";
        if ($email)
        {
            http_response_code(Authentication::HTTP_FOUND);
            die("email");
        }
    }

    /**
     * @param $json
     * @param null $config
     * @return array|mixed
     * @throws HTTP\HTTP_OPERATION_FAILED
     */
    public function post ($json, $config = NULL)
    {
        $username = $json->username;
        $email = $json->email;
        $data = $json->data;
        $uid = $json->uid;
        $authId = $json->authId;

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
        else
        {
            throw new HTTP\HTTP_OPERATION_FAILED();
        }

        $jwt = null;
        $saveResult = $this->dao->save($client);
        if ($saveResult)
        {
            $device = null;
            if ($uid != null)
            {
                $device = $this->deviceDAO->get($json->uid);
            }
            if ($device == null)
            {
                $device = new Device($client->getUsername());
                if (!$this->deviceDAO->save($device))
                {
                    throw new HTTP\HTTP_OPERATION_FAILED();
                }
            }

            if($this->dao->save($client))
            {
                http_response_code(201);
                return [
                    'client' => $client,
                    'device' => $device
                ];
            }
            else
            {
                throw new HTTP\HTTP_OPERATION_FAILED();
            }
        }
        throw new HTTP\HTTP_OPERATION_FAILED();
    }

    /**
     * @param $json
     * @param null $config
     * @return void
     * @throws HTTP\HTTP_NOT_FOUND
     * @throws HTTP\HTTP_OPERATION_FAILED
     */
    public function delete($json, $config = NULL)
    {
        $clientId = null;
        if ($json->username) $clientId = $json->username;
        elseif ($json->email) $clientId = $json->email;
        else
        {
            throw new HTTP\HTTP_NOT_FOUND();
        }

        $client = $this->dao->get($clientId);
        $device[] = $this->deviceDAO->getByClient($client->getJSON());
        foreach ($device as $dev)
        {
            $this->deviceDAO->delete($dev);
        }
        if($this->dao->delete($client)) http_response_code(Authentication::HTTP_ACCEPTED);
        else
        {
            throw new HTTP\HTTP_OPERATION_FAILED();
        }
    }

    /**
     * @param $data
     * @param null $config
     * @return mixed|void
     */
    public function put ($data, $config = NULL)
    {
        // TODO : WARNING! -> TEMPORARY
        $this->post($data);
    }
}