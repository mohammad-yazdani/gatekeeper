<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/19/2017
 * Time: 4:30 PM
 */

require_once 'Authentication.php';
require_once 'AnalyticsController.php';

// TODO : CLEAN CODE

/**
 * @property ClientController clientCtrl
 * @property AnalyticsController controller
 */
class AnalyticsAuth extends Authentication
{

    /**
     * AnalyticsAuth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->clientCtrl = new ClientController();
        $this->controller = new AnalyticsController();
    }

    /**
     * Input:
     * /type/{{type name}}/action/{{action name}}/{{associative input}}
     */
    public function index_get()
    {
        if ($this->authorize())
        {
            $params =  $this->uri->uri_to_assoc(2);
            $input =  $this->uri->uri_to_assoc(4);

            if ($params['type'] === 'command')
            {
                $this->controller->get($input, $params['action']);
            }
        }
        else
        {
            throw new \Exceptions\HTTP\HTTP_FORBIDDEN();
        }
    }

    /**
     * Sample input: JSON
     * Input name: 'json'
     */
    public function index_post()
    {
        if ($this->authorize())
        {
            $input = json_decode($this->input->post('json'));
            $this->controller->post($input);
        }
        else
        {
            throw new \Exceptions\HTTP\HTTP_FORBIDDEN();
        }
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

    }
}