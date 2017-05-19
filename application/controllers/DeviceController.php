<?php

/**
 * Created by PhpStorm.
 * User: kieong
 * Date: 2017-05-17
 * Time: 3:05 PM
 */

require_once APPPATH.'helpers/DAO/DeviceDAOImpl.php';
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';


class DeviceController extends \Controller
{
    private $deviceDAO;

    function __construct()
    {
    }

    public function get($key=NULL)
    {

    }

    public function post($key)
    {

    }

    public function put($key)
    {

    }

    public function delete($key)
    {

    }


    public function REST_GET ($id){
        $this->get($id);
    }
    public function REST_POST (string $json){
        $this->post($json);
    }
    public function REST_PUT (string $json){
        $this->put($json);
    }
    public function REST_DELETE (string $json){
        $this->delete($json);
    }


}