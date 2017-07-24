<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/12/2017
 * Time: 1:19 PM
 */

require_once APPPATH.'helpers\Exceptions\HTTP\HTTP_NOT_FOUND.php';
require_once APPPATH.'helpers/DAO/UserDAOImpl.php';
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';

// TODO : CLEAN-CODE

use \models\User;

class UserController extends \Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->dao = new \DAO\UserDAOImpl($em);
    }

    public function get(string $name, $config = NULL)
    {
        if (!$this->dao->get($name)) throw new \Exceptions\HTTP\HTTP_NOT_FOUND();
        die($this->dao->get($name)->getJSON());
    }

    public function post($data, $config = NULL)
    {
        // TODO: Implement post() method.
    }

    public function put($data, $config = NULL)
    {
        // TODO: Implement put() method.
    }

    public function delete($data, $config = NULL)
    {
        // TODO: Implement delete() method.
    }


}