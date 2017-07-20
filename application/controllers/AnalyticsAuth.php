<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/19/2017
 * Time: 4:30 PM
 */
class AnalyticsAuth extends Authentication
{

    public function __construct()
    {
        parent::__construct();
        $this->clientCtrl = new ClientController();
    }

    public function index_get()
    {
        $key = $this->uri->segment(2);
        $command = $this->uri->segment(3);
        $options_json = [];
        $option_file_name = false;

        $client = $this->validate_client($key);
        if ($client)
        {
            try
            {
                $options_json = json_decode($this->input->post('json'));
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }
    }

    public function index_post()
    {

    }

    public function index_put()
    {

    }

    public function index_delete()
    {

    }
}