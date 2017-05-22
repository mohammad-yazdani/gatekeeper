<?php

/**
 * Created by PhpStorm.
 * User: kieong
 * Date: 2017-05-17
 * Time: 3:05 PM
 */

namespace models;
require_once APPPATH.'helpers/DAO/ClientDAOImpl.php';
require_once APPPATH.'helpers/DAO/DeviceDAOImpl.php';
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';



class DeviceController extends \Controller
{
    private $deviceDAO;

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $the_dao = new \DAO\DeviceDAOImpl($em);
    }

    public function get($key=NULL): Device
    {
        $id = (int) $key;
        $device = $this->dao->get($id);
        if ($device == NULL) {
            return NULL;
            //echo "<br/><br/>";
            //echo $device->getJSON();
        } else {
            return $device;
        }

    }

    public function post($key)
    {
        $json = json_decode($key);
        $device = new Device($json->data);
        if($this->dao->save($device)){
            return true;
        } else {
            return false;
        }
    }

    public function put($key)
    {
        post($key);
    }

    public function delete($key)
    {
        $json = json_decode($key);
        $device = $this->dao->get($json->id);
        if ($device) {
            if($this->dao->delete($device)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }


    public function REST_GET ($id)
    {
        $this->get($id);
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