<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 12:55 PM
 */

require_once APPPATH.'/libraries/REST_Controller.php';

abstract class Controller
{
    protected $dao;

    public function index_get($id)
    {
        echo "In index_get()";
        try
        {
            $this->REST_GET($id);
        } catch(exception $e) {
            echo 'Exception Caught: ', $e->getMessage();
        }
    }

    public function index_post($json)
    {
        try
        {
            $this->REST_POST($json);
        } catch(exception $e) {
            echo 'Exception Caught: ', $e->getMessage();
        }
    }
    public function index_put($json)
    {
        try
        {
            $this->REST_PUT($json);
        } catch(exception $e) {
            echo 'Exception Caught: ', $e->getMessage();
        }
    }
    public function index_delete($json)
    {
        try
        {
            $this->REST_DELETE($json);
        } catch(exception $e) {
            echo 'Exception Caught: ', $e->getMessage();
        }
    }

    abstract public function REST_GET ($id, $token = NULL);
    abstract public function REST_POST (string $json);
    abstract public function REST_PUT (string $json);
    abstract public function REST_DELETE (string $json);
}