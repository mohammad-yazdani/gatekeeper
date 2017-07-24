<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/30/2017
 * Time: 1:52 PM
 */

require_once 'Authentication.php';

use controllers\DeviceController;

// TODO : CLEAN-CODE

/**
 * Class DeviceAuth
 */
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

    /**
     * @throws \Exceptions\HTTP\HTTP_NOT_ACCEPTABLE
     * @throws \Exceptions\HTTP\HTTP_UNAUTHORIZED
     */
    public function index_get()
    {

        $uid = $this->uri->segment(2);
        $token_result = $this->authorize();
        if (strlen($uid) > 0)
        {
            if ($token_result)
            {
                http_response_code(Authentication::HTTP_ACCEPTED);
                die($this->controller->get($uid)->getJSON());
            }
            else
            {
                throw new \Exceptions\HTTP\HTTP_UNAUTHORIZED();
            }
        }
        else
        {
            throw new \Exceptions\HTTP\HTTP_NOT_ACCEPTABLE();
        }
    }

    /**
     * Sample json input: { username }
     */
    public function index_post()
    {
        if ($this->authorize())
        {
            $json = json_decode($this->input->raw_input_stream);
            try
            {
                $this->controller->post($json);
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
                throw new \Exceptions\HTTP\HTTP_OPERATION_FAILED();
            }
        }
        else throw new \Exceptions\HTTP\HTTP_UNAUTHORIZED();
    }

    /**
     *
     */
    public function index_put()
    {

    }

    /**
     *
     */
    public function index_delete()
    {
        // TODO: Implement index_delete() method.
    }
}