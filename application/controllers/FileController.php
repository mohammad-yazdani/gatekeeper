<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 10:43 AM
 */

namespace controllers;
namespace models;
require_once 'File.php';


use DAO\ClientFileDAOImpl;

class FileController extends \Controller
{
    private $fileDAO;

    /**
     * FileController constructor.
     */
    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        // TODO : Change to FileDAOImpl
        $this->dao = new ClientFileDAOImpl($em);
    }

    public function get($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement get() method.
        $id = (int) $key;
        return $this->fileDAO->get($id);
    }

    public function post($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement post() method.
        $json = json_decode($key);
        $file = new File($json->clientId);
        if($this->fileDAO->save($file)){
            return true;
        } else {
            return false;
        }
    }

    public function put($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement put() method.
        $this->post($key); //temporary
    }

    public function delete($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement delete() method.
        $json = json_decode($key);
        $file = $this->fileDAO->get($json->id);
        if ($file) {
            if($this->fileDAO->delete($file)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function REST_GET($id, $token = NULL)
    {
        // TODO: Implement REST_GET() method.
        $this->get($id);
    }

    public function REST_POST(string $json)
    {
        // TODO: Implement REST_POST() method.
        $this->post($json);
    }

    public function REST_PUT(string $json)
    {
        // TODO: Implement REST_PUT() method.
        $this->put($json);
    }

    public function REST_DELETE(string $json)
    {
        // TODO: Implement REST_DELETE() method.
        $this->delete($json);
    }

}