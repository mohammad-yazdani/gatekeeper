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

// TODO : For test remove return null

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
        return null;
        /*echo "RSA GET:<br/>";
        $output = $this->rsa_manager->getPublicKey();
        echo $output;*/
    }

    public function index_post()
    {
        return null;
        /*echo "RSA POST:<br/>";
        $output = $this->rsa_manager->newPublicKey();
        echo $output;*/
    }

    public function index_put()
    {
        return null;
        /*echo "RSA PUT:<br/>";*/
    }

    public function index_delete()
    {
        return null;
        /*echo "RSA DELETE:<br/>";*/
    }
}