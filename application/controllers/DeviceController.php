<?php

/**
 * Created by PhpStorm.
 * User: kieong
 * Date: 2017-05-17
 * Time: 3:05 PM
 */

namespace controllers;

require_once APPPATH.'helpers/DAO/ClientDAOImpl.php';
require_once APPPATH.'helpers/DAO/DeviceDAOImpl.php';
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';

use \DAO\DeviceDAOImpl;
use Exceptions\HTTP\HTTP_NOT_FOUND;
use Exceptions\HTTP\HTTP_OPERATION_FAILED;
use models\Device;

// TODO : CLEAN-CODE

/**
 * Class DeviceController
 * @package controllers
 */
class DeviceController extends \Controller
{
    /**
     * @var DeviceDAOImpl
     */
    private $deviceDAO;

    /**
     * DeviceController constructor.
     */
    function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->deviceDAO = new DeviceDAOImpl($em);
    }

    /**
     * @param string $uid
     * @param null $config
     * @return mixed|void
     */
    public function get(string $uid, $config = NULL)
    {
        $id = (int) $uid;
        die($this->deviceDAO->get($id)->getJSON());
    }

    /**
     * @param string $uid
     * @param null $config
     * @return mixed|void
     */
    public function get_object(string $uid, $config = NULL)
    {
        $id = (int) $uid;
        return $this->deviceDAO->get($id);
    }

    /**
     * @param $data
     * @param null $config
     * @return mixed|void
     * @throws HTTP_OPERATION_FAILED
     */
    public function post($data, $config = NULL)
    {
        $device = new Device($data->clientId);
        if($this->deviceDAO->save($device)){
            http_response_code(\Authentication::HTTP_CREATED);
        } else {
            throw new HTTP_OPERATION_FAILED();
        }
    }

    /**
     * @param $key
     * @param null $xss_clean
     * @return mixed|void
     */
    public function put($key, $xss_clean = NULL)
    {
        $this->post($key);
    }

    /**
     * @param $name
     * @param null $config
     * @return mixed|void
     * @throws HTTP_NOT_FOUND
     * @throws HTTP_OPERATION_FAILED
     */
    public function delete($name, $config = NULL)
    {
        $json = json_decode($name);
        $device = $this->deviceDAO->get($json->id);
        if ($device) {
            if($this->deviceDAO->delete($device)) {
                http_response_code(\Authentication::HTTP_ACCEPTED);
            } else {
                throw new HTTP_OPERATION_FAILED();
            }
        } else {
            throw new HTTP_NOT_FOUND();
        }

    }
}