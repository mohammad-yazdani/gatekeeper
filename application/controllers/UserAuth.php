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

    public function index_get()
    {
        // TODO: Implement index_get() method.
    }

    public function index_post()
    {
        // TODO: Implement index_post() method.
    }

    public function index_put()
    {
        // TODO: Implement index_put() method.
    }

    public function index_delete()
    {
        // TODO: Implement index_delete() method.
    }


}