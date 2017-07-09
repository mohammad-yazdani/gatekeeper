<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/6/2017
 * Time: 9:08 AM
 */

namespace DAO;

require_once 'DAO.php';

use models\Profile;

/**
 * Interface ProfileDAO
 * @package DAO
 */
interface ProfileDAO extends \DAO
{
    /**
     * @param Profile $profile
     * @return mixed
     */
    public function save(Profile $profile);

    /**
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param Profile $profile
     * @return mixed
     */
    public function delete(Profile $profile);
}