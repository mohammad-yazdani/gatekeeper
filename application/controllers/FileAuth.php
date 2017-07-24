<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/30/2017
 * Time: 1:52 PM
 */

require_once 'Authentication.php';
require_once 'ClientController.php';
require_once APPPATH.'helpers\FileSystem\Inspector.php';
require_once APPPATH.'helpers\Exceptions\HTTP\HTTP_UNAUTHORIZED.php';
require_once 'Controller.php';
require_once 'FileController.php';

use controllers\FileController;
use Exceptions\HTTP\HTTP_UNAUTHORIZED;

// TODO : CLEAN-CODE

/**
 * Class DeviceAuth
 */
class FileAuth extends \Authentication
{
    /**
     * FileAuth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->controller = new FileController();
    }

    /**
     *
     */
    public function index_get()
    {
        echo "not completed yet";
    }

    /**
     * Sample input: client/{{}}/category/{{}}}/directory
     */
    public function index_post()
    {
        if ($this->authorize())
        {
            $input = json_decode(json_encode($this->uri->uri_to_assoc(2)));
            $this->controller->post($input);
        }
        else
        {
            throw new HTTP_UNAUTHORIZED();
        }
    }

    /**
     *
     */
    public function index_put()
    {
        // TODO: Implement index_put() method.
    }

    /**
     *
     */
    public function index_delete()
    {
        // TODO: Implement index_delete() method.
    }
}