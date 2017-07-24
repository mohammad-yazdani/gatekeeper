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
use models\Device;


class DeviceController extends \Controller
{
    private $deviceDAO;

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->deviceDAO = new DeviceDAOImpl($em);
    }

    public function get(string $key, $xss_clean = NULL) : Device
    {
        $id = (int) $key;
        return $this->deviceDAO->get($id);
    }

    public function post($key = NULL, $xss_clean = NULL)
    {
        $json = json_decode($key);
        $device = new Device($json->clientId);
        if($this->deviceDAO->save($device)){
            return true;
        } else {
            return false;
        }
    }

    public function put($key = NULL, $xss_clean = NULL)
    {
        $this->post($key);
    }

    public function delete($key = NULL, $xss_clean = NULL)
    {
        $json = json_decode($key);
        $device = $this->deviceDAO->get($json->id);
        if ($device) {
            if($this->deviceDAO->delete($device)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }


    // TODO : Do token part later
    public function REST_GET ($id, $token = NULL)
    {
        return $this->get($id);
    }
    public function REST_POST (string $json)
    {
        $this->post($json);
    }
    public function REST_PUT (string $json)
    {
        $this->put($json);
    }
    public function REST_DELETE (string $json)
    {
        $this->delete($json);
    }


}