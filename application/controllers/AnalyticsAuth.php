<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-07-09
 * Time: 2:25 PM
 */

require_once 'Authentication.php';
require_once 'AnalyticsController.php';
require_once APPPATH.'helpers/os/Analytics/MonthlyReports.php';

use \OS\Analytics\MonthlyReports as MonthlyReports;

class AnalyticsAuth extends Authentication
{

    public function __construct()
    {
        parent::__construct();
        $this->controller = new AnalyticsController();
    }

    public function index_get()
    {
        $key = $this->uri->segment(2);
        $client = $this->evaluate($key);
        // if($client)
        if(true)
        {
            $command = $this->uri->segment(3);
            if ($command == 'profile')
            {
                // TODO : Get profiles
                $profile_name = $this->uri->segment(4);
                echo "$profile_name<br/>";
                $this->controller->REST_GET($profile_name, $profile=true);
                return;
            }
            $input_options = $this->uri->segment(4);
            $this->controller->get($command, $options=$input_options);
        }
        else
        {
            http_response_code(403);
        }
    }

    public function index_post()
    {
        $key = $this->uri->segment(2);
        $client = $this->evaluate($key);
        if($client)
        {
            $input_name = $this->uri->segment(3);
            $input_json = file_get_contents('php://input');

            $this->controller->REST_POST($name=$input_name, $json=$input_json);
        }
        else
        {
            http_response_code(403);
        }
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