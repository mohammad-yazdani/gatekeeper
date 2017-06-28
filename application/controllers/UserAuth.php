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
        $this->controller = new UserController();
    }

    public function index_get()
    {
        $key = $this->uri->segment(2);
        $id = $this->uri->segment(3);

        if (strlen($key) === 0)
        {
            http_response_code(401);
            echo Authentication::$unauthorized_401;
            return null;
        }

        $userResult = null;

        try
        {
            $evaluation_result = $this->evaluate($key);
        }
        catch (UnexpectedValueException $e)
        {
            log_message('error', $e->getMessage());
            http_response_code(400);
            echo Authentication::$badRequest_400;
            return false;
        }

        if ($evaluation_result)
        {
            if (strlen($id) === 0)
            {
                http_response_code(400);
                echo Authentication::$badRequest_400;
                return false;
            }
            $userResult = $this->controller->REST_GET($id, $key);
        }
        else
        {
            http_response_code(403);
            echo Authentication::$forbidden_403;
            return false;
        }

        if ($userResult == null)
        {
            http_response_code(404);
            echo Authentication::$notFound_404;
            return null;
        }
        http_response_code(202);

        // TODO : FOR TEST
        print_r($userResult);

        http_response_code(201);
        echo \Token\DeviceTokenManager::update($key);
        return true;
    }

    public function index_post()
    {
        $json = new stdClass();
        $json->key = $this->uri->segment(2);
        $json->userId = $this->uri->segment(3);

        if (strlen($json->key) === 0)
        {
            http_response_code(401);
            echo Authentication::$unauthorized_401;
            return null;
        }

        $userResult = null;

        try
        {
            $evaluation_result = $this->evaluate($json->key);
        }
        catch (UnexpectedValueException $e)
        {
            log_message('error', $e->getMessage());
            http_response_code(400);
            echo Authentication::$badRequest_400;
            return false;
        }

        if ($evaluation_result)
        {
            if ($this->controller->post(json_encode($json)))
            {
                http_response_code(201);
                \Token\DeviceTokenManager::update($json->key);
                return true;
            }
            else false;
        }
        return false;
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