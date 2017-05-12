<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 3/7/2017
 * Time: 5:48 PM
 */

namespace application\helpers\DAO;


use models\Client;

interface ClientDAO extends \DAO
{
    public function save(Client $client);

    public function get($id);

    public function delete(Client $client);
}