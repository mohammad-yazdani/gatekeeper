<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/30/2017
 * Time: 1:52 PM
 */

require_once 'Authentication.php';

use \models\DeviceController;

class DeviceAuth extends Authentication
{
    /**
     * DeviceAuth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->controller = new DeviceController();
    }

    public function index_get()
    {
        $key = $this->uri->segment(2);
        $uid = $this->uri->segment(3);

        if (strlen($key) === 0)
        {
            http_response_code(401);
            echo Authentication::$unauthorized_401;
            return null;
        }

        $deviceResult = null;

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
            if (strlen($uid) === 0)
            {
                // TODO : validate the token and send back
                http_response_code(202);
                return true;
            }
            $deviceResult = $this->controller->REST_GET($uid, $key);
        }
        else
        {
            http_response_code(403);
            echo Authentication::$forbidden_403;
            return false;
        }

        if ($deviceResult == null)
        {
            http_response_code(404);
            echo Authentication::$notFound_404;
            return null;
        }
        http_response_code(202);

        // TODO : FOR TEST
        print_r($deviceResult);

        http_response_code(201);
        echo \Token\DeviceTokenManager::update($key);
        return true;
    }

    public function index_post()
    {
        $json = new stdClass();
        $json->key = $this->uri->segment(2);
        $json->clientId = $this->uri->segment(3);

        if (strlen($json->key) === 0)
        {
            http_response_code(401);
            echo Authentication::$unauthorized_401;
            return null;
        }

        $deviceResult = null;

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

    }

    public function index_delete()
    {
        // TODO: Implement index_delete() method.
    }
}