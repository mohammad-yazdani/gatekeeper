<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/16/2017
 * Time: 3:45 PM
 */

require_once 'Controller.php';
require_once 'Authentication.php';
require_once 'ClientController.php';

class ClientAuth extends Authentication
{


    /**
     * TestController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->controller = new ClientController();
    }
}