<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/23/2017
 * Time: 2:15 PM
 */

require_once APPPATH.'controllers\Authentication.php';
require_once APPPATH.'helpers\FileSystem\RSA_FileManager.php';

use \FileSystem\RSA_FileManager;

class RSA_Key extends Authentication
{

    private $rsa_manager;

    /**
     * RSA_Key constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->rsa_manager = new RSA_FileManager();
    }


    public function index_get()
    {
        echo "RSA GET:<br/>";
        echo $this->rsa_manager->newPublicKey();
    }

    public function index_post()
    {
        echo "RSA POST:<br/>";
    }

    public function index_put()
    {
        echo "RSA PUT:<br/>";
    }

    public function index_delete()
    {
        echo "RSA DELETE:<br/>";
    }
}