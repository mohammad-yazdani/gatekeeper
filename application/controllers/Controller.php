<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 12:55 PM
 */

require_once APPPATH.'/libraries/REST_Controller.php';
use \Restserver\Libraries\REST_Controller;

abstract class Controller extends REST_Controller
{
    protected $dao;

    /**
     * Controller constructor.
     * @param \DAO $dao
     */
    public function __construct(\DAO $dao = null)
    {
        parent::__construct();
        $this->dao = $dao;
    }

    public function index_get($id)
    {
        try
        {
            $this->REST_GET($id);
        } catch(exception $e) {
            echo 'Exception Caught: ', $e->getMessage();
        }
    }

    abstract public function REST_GET ($id);
    abstract public function REST_POST (string $json);
    abstract public function REST_PUT (string $json);
    abstract public function REST_DELETE (string $json);
}