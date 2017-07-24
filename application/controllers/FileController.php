<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 10:43 AM
 */

namespace controllers;

use DAO\ClientFileDAOImpl;
use Exceptions\HTTP\HTTP_OPERATION_FAILED;
use Symfony\Component\Config\Definition\Exception\Exception;
use \FileSystem\Inspector;
use ClientController;

// TODO : CLEAN-CODE

/**
 * Class FileController
 * @package controllers
 */
class FileController extends \Controller
{
    /**
     * @var Inspector
     */
    private $inspector;

    /**
     * @var ClientController
     */
    private $clientCtrl;

    /**
     * FileController constructor.
     */
    public function __construct()
    {
        $this->inspector = new Inspector();
        $this->clientCtrl = new ClientController();
    }

    /**
     * @param string $name
     * @param null $config
     * @return mixed|void
     */
    public function get(string $name, $config = NULL) {}

    /**
     * @param $data
     * @param null $config
     * @return mixed|void
     * @throws HTTP_OPERATION_FAILED
     */
    public function post($data, $config = NULL)
    {
        $client = $this->clientCtrl->get_object($data->client);
        $category = $data->category;
        if (!isset($data->directory)) $directory = "";
        else $directory = $data->directory;
        try
        {
            $this->inspector->upload($client, $category, $directory);
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            throw new HTTP_OPERATION_FAILED();
        }
    }

    /**
     * @param $data
     * @param null $config
     * @return mixed|void
     */
    public function put($data, $config = NULL)
    {
        // TODO: Implement put() method.
    }

    /**
     * @param $data
     * @param null $config
     * @return mixed|void
     */
    public function delete($data, $config = NULL)
    {
        // TODO: Implement delete() method.
    }
}