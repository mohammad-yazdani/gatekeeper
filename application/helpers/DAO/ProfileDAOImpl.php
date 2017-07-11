<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/6/2017
 * Time: 9:10 AM
 */

namespace DAO;

require_once 'ProfileDAO.php';

use DateTime;
use models\Profile;

class ProfileDAOImpl extends \DAOImpl implements ProfileDAO
{
    public function __construct($em)
    {
        parent::__construct($em, 'models\Profile');
    }

    public function save(Profile $profile)
    {
        try
        {
            $this->em->persist($profile);
            $this->em->flush();
            $profile->updateJSON();
            $this->em->persist($profile);
            $this->em->flush();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        return true;
    }

    public function get($name)
    {
        $profile = null;
        try
        {
            $profile = $this->em->find($this->repository, $name);
        }
        catch (Exception $e)
        {
            return null;
        }
        return $profile;
    }

    public function delete(Profile $profile)
    {
        // TODO: Implement delete() method.
    }

    public function check(string $name)
    {
        // TODO: Implement check() method.
    }

    public function getByDateCreated(DateTime $date)
    {
        // TODO: Implement getByDateCreated() method.
    }

    public function getByDateModified(DateTime $date)
    {
        // TODO: Implement getByDateModified() method.
    }

    public function getByJSON(string $json)
    {
        // TODO: Implement getByJSON() method.
    }
}