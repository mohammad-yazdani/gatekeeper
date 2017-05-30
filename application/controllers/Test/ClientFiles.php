<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 12:30 PM
 */

require_once APPPATH.'controllers\Authentication.php';
require_once APPPATH.'controllers\ClientController.php';
require_once APPPATH.'helpers\FileSystem\Inspector.php';

class ClientFiles extends Authentication
{
    private $inspector;

    private $clientCtrl;
    /**
     * ClientFiles constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->inspector = new \FileSystem\Inspector();
        $this->clientCtrl = new ClientController();
    }

    public function index_get()
    {
        echo "Client files get.";
    }

    public function index_post()
    {
        $client = $this->uri->segment(3);
        $category = $this->uri->segment(4);
        $client = $this->clientCtrl->get($client, null, true);
        if($client)
        {
            $this->inspector->upload($client, $category);
        }
        else
        {
            http_response_code(401);
        }
    }

    public function index_put()
    {
        echo "Client files put.";
    }

    public function index_delete()
    {
        echo "Client files delete.";
    }
}