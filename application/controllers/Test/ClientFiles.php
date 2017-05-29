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
        }
        else
        {
            $result = array('upload_data' => $this->upload->data());
        }
        print_r($result);
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