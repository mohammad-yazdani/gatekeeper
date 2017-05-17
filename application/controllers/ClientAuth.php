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

    public function index_get()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $id = $this->uri->segment(4);

        if ($this->evaluate($key, $username, $password))
        {
            $this->controller->REST_GET($id);
        }
    }

    public function index_post()
    {
        $key = $this->uri->segment(2);
        $username = $this->uri->segment(3);
        $email = $this->uri->segment(4);
        $password = $this->uri->segment(5);
        $data = $this->uri->segment(6);
        $uid = $this->uri->segment(7);

        $json = new stdClass();
        $json->key = $key;
        $json->username = $username;
        $json->email = $email;
        $json->password = $password;
        $json->data = $data;
        $json->uid = $uid;

        // TODO : Make sign up secure
        //if ($this->evaluate($key, $username, $password))
        //{
            //echo "Posting client 1<br/>";
            //return null;

        $authId = $this->dao->encrypt($json->password)->getId();
        $json->authId = $authId;

        /*
        // TODO : FOR TEST
        echo "TEST index_get(): <br/>";
        echo $json->key." 1<br/>";
        echo $json->username." 2<br/>";
        echo $json->email." 3<br/>";
        echo $json->password." 4<br/>";
        echo $json->data." 5<br/>";
        echo $json->uid." 6<br/>";
        echo $json->authId."<br/>";
        return null;
        */

        $this->controller->REST_POST(json_encode($json));
        //}
    }

    public function index_put()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $json = $this->uri->segment(4);
        if ($this->evaluate($key, $username, $password))
        {
            $this->controller->REST_PUT($json);
        }
    }

    public function index_delete()
    {
        $key = $this->uri->segment(1);
        $username = $this->uri->segment(2);
        $password = $this->uri->segment(3);
        $json = $this->uri->segment(4);
        if ($this->evaluate($key, $username, $password))
        {
            $this->controller->REST_DELETE($json);
        }
    }
}