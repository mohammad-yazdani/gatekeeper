<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 4:21 PM
 */

require_once 'Controller.php';
require_once 'Authentication.php';
require_once 'UserController.php';

class UserAuth extends Authentication
{


    /**
     * TestController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
        $em = $this->doctrine->em;
        $this->controller = new UserController();
    }
}