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

// TODO : CLEAN-CODE

class UserAuth extends Authentication
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('doctrine');
        $this->controller = new UserController();
    }

    /**
     * Input:
     * /name
     */
    public function index_get()
    {
        if ($this->authorize())
        {
            $name =  $this->uri->segment(2);
            $this->controller->get($name);
        }
        else
        {
            throw new \Exceptions\HTTP\HTTP_UNAUTHORIZED();
        }
    }

    public function index_post()
    {
        die("not implemented yet");
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