<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/19/2017
 * Time: 4:30 PM
 */

require_once 'Authentication.php';
require_once 'AnalyticsController.php';

class AnalyticsAuth extends Authentication
{

    public function __construct()
    {
        parent::__construct();
        $this->clientCtrl = new ClientController();
        $this->controller = new AnalyticsController();
    }

    /**
     * Sample json input: { "data" }
     * Input name: 'json'
     * Sample URL input:
     */
    public function index_get()
    {
        $headers = $this->input->request_headers();
        print_r($headers['authorization']);
        return;
        $type = $this->uri->segment[2];
        $action = $this->uri->segment[3];

        $input = json_decode($this->input->post('json'));
        // TODO : Get token from header
        $token = NULL;
        $client = $this->validate_client($token);
        if ($client)
        {
            if ($type === 'command')
            {
                $this->controller->get($input, $action);
            }
            // TODO : MORE TYPES TO COME
        }
        else
        {
            http_response_code(Authentication::HTTP_FORBIDDEN);
            die(Authentication::$forbidden_403);
        }
    }

    /**
     * Sample input: { "key", "data" }
     * Input name: 'json'
     */
    public function index_post()
    {
        $input = json_decode($this->input->post('json'));
        $client = $this->validate_client($input['key']);
        if ($client)
        {
            $this->controller->post($input['data']);
        }
        else
        {
            http_response_code(Authentication::HTTP_FORBIDDEN);
            die(Authentication::$forbidden_403);
        }
    }

    public function index_put()
    {

    }

    public function index_delete()
    {

    }
}