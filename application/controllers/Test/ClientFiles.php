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
        //$this->inspector->upload();

        $config['upload_path'] = APPPATH.'files\clientFiles';
        $config['allowed_types'] = 'xls|txt';

        $CI =& get_instance();
        $CI->load->library('upload', $config);

        $CI->upload->initialize($config);

        $result = $CI->upload->do_upload('file');

        if (!$result)
        {
            $result = $CI->upload->display_errors();
            log_message('error', $result);
            echo $result;
        }
        else
        {
            $result = array('upload_data' => $CI->upload->data());

            print_r($result);
        }

        // TODO : Create file object from upload results and save to DB
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