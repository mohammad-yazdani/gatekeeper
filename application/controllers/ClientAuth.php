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
require_once APPPATH.'helpers\Exceptions\HTTP\HTTP_OPERATION_FAILED.php';

// TODO : CLEAN CODE

/**
 * @property ClientController controller
 */
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

    /**
     *
     */
    public function index_get()
    {
        $name = $this->uri->segment(2);
        $token_result = $this->authorize();
        if (strlen($name) > 0)
        {
            if ($token_result)
            {
                $this->controller->get($name);
            }
            else
            {
                $this->controller->unauthorized_get($name);
            }
        }
        else if ($token_result)
        {
            http_response_code(Authentication::HTTP_ACCEPTED);
            // die($this->update_token($token_result));
        }
        else
        {
            $this->register_credentials();
        }
    }

    /**
     * Sample json input: { username, email, password, data, uid }
     */
    public function index_post()
    {
        $json = json_decode($this->input->raw_input_stream);
        $json->uid = null;
        $authId = $this->dao->encrypt($json->password)->getId();
        $json->authId = $authId;
        try
        {
            $params = $this->controller->post($json);
            $this->new_token($params['client'], $params['device']);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            throw new \Exceptions\HTTP\HTTP_OPERATION_FAILED();
        }
    }

    /**
     *
     */
    public function index_put()
    {
        if ($this->authorize())
        {
            $json = json_decode($this->input->raw_input_stream);
            $this->controller->put($json);
        }
    }

    /**
     *
     */
    public function index_delete()
    {
        if ($this->authorize())
        {
            $json = json_decode($this->input->raw_input_stream);
            $this->controller->delete($json);
        }
    }
}