<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/12/2017
 * Time: 4:18 PM
 */

namespace DAO;


use models\Auth;
use models\Client;
use models\Device;

interface AuthDAO
{
    public function save(Auth $auth);

    public function get($id);

    public function delete(Auth $auth);

    public function encrypt(string $password, int $id);

    public function decrypt(int $id, string $password);

    static public function validateKey (string $key) : bool;

    static public function generateKey (Device $device, Client $client) : string;

    static public function updateKey (string $key) : string;
}