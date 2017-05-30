<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 10:43 AM
 */

namespace controllers;


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
    }

    public function post($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement post() method.
    }

    public function put($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement put() method.
    }

    public function delete($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement delete() method.
    }

    public function REST_GET($id, $token = NULL)
    {
        // TODO: Implement REST_GET() method.
    }

    public function REST_POST(string $json)
    {
        // TODO: Implement REST_POST() method.
    }

    public function REST_PUT(string $json)
    {
        // TODO: Implement REST_PUT() method.
    }

    public function REST_DELETE(string $json)
    {
        // TODO: Implement REST_DELETE() method.
    }

}