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
        $key = $this->uri->segment(2);

        if ($key == "check")
        {
            $statusReturn = 1;
            $id = $this->uri->segment(3);
            try
            {
                if (!$this->controller->get($id, true)) {
                    $statusReturn = 1;
                } else {
                    $statusReturn = 0;
                }
            }
            catch (Exception $e)
            {
                log_message('error', $e->getMessage());
                $statusReturn = 1;
            }
            echo $statusReturn;
            return $statusReturn;
        }

        if ($key == "null") $key = null;

        $username = $this->uri->segment(3);
        $password = $this->uri->segment(4);
        $id = $this->uri->segment(3);

        $evaluation_result = $this->evaluate($key, $username, $password);

        $clientResult = null;

        if ($evaluation_result)
        {
            $clientResult =  $this->controller->REST_GET($id, $key);
        }
        else
        {
            http_response_code(403);
            echo Authentication::$forbidden_403;
            return false;
        }

        http_response_code(202);
        return $clientResult;
    }

    // TODO : DONE
    public function index_post()
    {
        $json = new stdClass();
        $json->key = $this->uri->segment(2);
        $json->username = $this->uri->segment(3);
        $json->email = $this->uri->segment(4);
        $json->password = $this->uri->segment(5);
        $json->data = $this->uri->segment(6);
        $json->uid = $this->uri->segment(7);

        if ($json->uid == "null") $json->uid = null;

        $authId = $this->dao->encrypt($json->password)->getId();
        $json->authId = $authId;

        try
        {
            $jwt = $this->controller->REST_POST(json_encode($json));
            if ($jwt)
            {
                http_response_code(200);
                echo $jwt;
            }
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            http_response_code(409);
            echo Authentication::$conflict_409;
        }
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