<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 12:45 PM
 */

namespace FileSystem;

use DAO\ClientFileDAOImpl;
use models\Client;
use models\File;


require_once 'FileManager.php';
require_once APPPATH.'helpers\DAO\ClientFileDAOImpl.php';

class Inspector extends FileManager
{

    private $fileDAO;

    private $accessDenied;

    /**
     * Inspector constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->fileDAO = new ClientFileDAOImpl($em);
        if(!($this->fileExists("clientFiles\\"))) $this->newDir("clientFiles\\");
        $this->dirPath = $this->dirPath."clientFiles\\";

        $this->accessDenied = new \stdClass();
        $this->accessDenied->msg = " access denied for ";
        $this->accessDenied->code = 403;
    }

    protected function upload(Client $uploader, string $category): File
    {
        if (!$uploader->getScope()['w'])
        {
            $error = "Upload.".$this->accessDenied->msg.$uploader->getUsername();

            log_message('error', $error);
            http_response_code($this->accessDenied->code);

            echo $error;
            return null;
        }
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
            $result = array('upload_data' => $this->upload->data());
        }

        // TODO : Create file object from upload results and save to DB

    }
}