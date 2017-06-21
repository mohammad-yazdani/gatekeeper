<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 12:45 PM
 */

namespace FileSystem;

use DAO\ClientDAOImpl;
use DAO\ClientFileDAOImpl;
use models\Client;
use models\File;


require_once 'FileManager.php';
require_once APPPATH.'helpers\DAO\ClientFileDAOImpl.php';
require_once APPPATH.'models\ClientFile.php';

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

    public function checkAccess (Client $client, string $category) : bool
    {
        if (!$client->getWriteAccess())
        {
            $error = "Upload".$this->accessDenied->msg."for user: ".$client->getUsername().".";

            log_message('error', $error);
            http_response_code($this->accessDenied->code);

            echo $error;
            return false;
        }
        if (!$client->hasAccessToCategory($category))
        {
            $error = "Upload".$this->accessDenied->msg."for user: ".$client->getUsername()
                ." for category ".$category.".";

            log_message('error', $error);
            http_response_code($this->accessDenied->code);

            echo $error;
            return false;
        }

        return true;
    }

    public function upload(Client $uploader, string $category)
    {
        if (!$this->checkAccess($uploader, $category))
        {
            http_response_code(401);
            echo \Authentication::$unauthorized_401;
            return false;
        }


        $config['upload_path'] = APPPATH.'files\clientFiles';
        $config['allowed_types'] = 'xlsx|txt';

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
        }

        // TODO : Create file object from upload results and save to DB
        $result = $result['upload_data'];

        $file_name = $result['file_name'];
        $file_path = $result['full_path'];
        $owner = $uploader->getUsername();
        $file_size = $result['file_size'];

        $file = new \ClientFile($file_path, $file_name, $owner, $category, $file_size);

        $this->fileDAO->save($file);

        if ($file)
        {
            http_response_code(201);
            return true;
        }
        else
        {
            http_response_code(409);
            return false;
        }
    }
}