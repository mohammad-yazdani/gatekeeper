<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/12/2017
 * Time: 4:17 PM
 */

namespace DAO;

use models\User;

interface UserDAO extends \DAO
{
    public function save(User $user);

    public function get($id);

    public function delete(User $user);
}