<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 12:30 PM
 */

require_once APPPATH.'controllers\Authentication.php';
require_once APPPATH.'helpers\FileSystem\Inspector.php';

class ClientFiles extends Authentication
{
    /**
     * ClientFiles constructor.
     */
    public function __construct()
    {
        parent::__construct();
        new \FileSystem\Inspector();
    }

    public function index_get()
    {
        echo "Client files get.";
    }

    public function index_post()
    {

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