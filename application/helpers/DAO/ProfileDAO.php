<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/6/2017
 * Time: 9:08 AM
 */

namespace DAO;


use models\Profile;

interface ProfileDAO extends \DAO
{
    public function save(Profile $profile);

    public function get($name);

    public function delete(Profile $profile);

    public function check(string $name);
}