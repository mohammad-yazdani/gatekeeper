<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 1:19 PM
 */

namespace DAO;

use models\Device;

// TODO : DOCUMENTATION

interface DeviceDAO extends \DAO
{
    public function save (Device $device);

    public function get ($uid);

    public function getByClient ($clientId);

    public function delete (Device $device);
}