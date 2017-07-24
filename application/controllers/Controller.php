<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 12:55 PM
 */

require_once APPPATH.'/libraries/REST_Controller.php';

/**
 * Class Controller
 */
abstract class Controller
{
    /**
     * @var
     */
    protected $dao;

    /**
     * @param string $name
     * @param null $config
     * @return mixed
     */
    abstract public function get(string $name, $config = NULL);

    /**
     * @param $data
     * @param null $config
     * @return mixed
     */
    abstract public function post($data, $config = NULL);

    /**
     * @param $data
     * @param null $config
     * @return mixed
     */
    abstract public function put($data, $config = NULL);

    /**
     * @param $data
     * @param null $config
     * @return mixed
     */
    abstract public function delete($data, $config = NULL);
}