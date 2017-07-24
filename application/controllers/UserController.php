<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/12/2017
 * Time: 1:19 PM
 */

require_once APPPATH.'helpers/DAO/ClientDAOImpl.php';
require_once APPPATH.'helpers/DAO/UserDAOImpl.php';
require_once APPPATH.'libraries/REST_Controller.php';
require_once 'Controller.php';

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


    /**
     * Retrieve a value from a GET request
     *
     * @access public
     * @param NULL $key Key to retrieve from the GET request
     * If NULL an array of arguments is returned
     * @param NULL $xss_clean Whether to apply XSS filtering
     * @return array|string|NULL Value from the GET request; otherwise, NULL
     */
    public function get(string $key, $xss_clean = NULL)
    {
        $id = (int) $key;
        $user = $this->dao->get($id);
        // TODO : TEST
        if ($user == NULL) return NULL;
        echo "<br/><br/>";
        echo $user->getJSON();

        if ($user == NULL) return null;
        else return $user;
    }

    /**
     * Retrieve a value from a POST request
     *
     * @access public
     * @param NULL $key Key to retrieve from the POST request
     * If NULL an array of arguments is returned
     * @param NULL $xss_clean Whether to apply XSS filtering
     * @return array|string|NULL Value from the POST request; otherwise, NULL
     */
    public function post($key = NULL, $xss_clean = NULL)
    {
        $json = json_decode($key);
        $user = new User($json->data);
        if($this->dao->save($user)) return $user->getId();
        else return false;
    }

    /**
     * Retrieve a value from a PUT request
     *
     * @access public
     * @param NULL $key Key to retrieve from the PUT request
     * If NULL an array of arguments is returned
     * @param NULL $xss_clean Whether to apply XSS filtering
     * @return array|string|NULL Value from the PUT request; otherwise, NULL
     */
    public function put($key = NULL, $xss_clean = NULL)
    {
        // TODO : WARNING -> TEMPORARY
        $this->post($key);
    }

    /**
     * Retrieve a value from a DELETE request
     *
     * @access public
     * @param NULL $key Key to retrieve from the DELETE request
     * If NULL an array of arguments is returned
     * @param NULL $xss_clean Whether to apply XSS filtering
     * @return array|string|NULL Value from the DELETE request; otherwise, NULL
     */
    public function delete($key = NULL, $xss_clean = NULL)
    {
        $json = json_decode($key);
        $user = $this->dao->get($json->id);
        if ($user) {
            if($this->dao->delete($user)) return true;
            else return false;
        } else return false;
    }


    // TODO : Do the token part later
    public function REST_GET($id, $token = NULL)
    {
        $id = ( int ) $id;
        return $this->get($id);
    }

    public function REST_POST(string $json)
    {
        return $this->post($json);
    }

    public function REST_PUT(string $json)
    {
        $this->put($json);
    }

    public function REST_DELETE(string $json)
    {
        $this->delete($json);
    }
}