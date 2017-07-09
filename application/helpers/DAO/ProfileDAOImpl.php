<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/6/2017
 * Time: 9:10 AM
 */

namespace DAO;

require_once 'ProfileDAO.php';
require_once 'DAOImpl.php';

use DateTime;
use Exception;
use models\Profile;

/**
 * Class ProfileDAOImpl
 * @package DAO
 */
class ProfileDAOImpl extends \DAOImpl implements ProfileDAO
{
    /**
     * ProfileDAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        parent::__construct($em, 'models\Profile');
    }

    /**
     * @param Profile $profile
     * @return mixed
     */
    public function save(Profile $profile)
    {
        try
        {
            // TODO : DOC
            $this->em->persist($profile);
            $this->em->flush($profile);
            $profile->updateJSON();
            $this->em->persist($profile);
            $this->em->flush();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        // Method returns true so that the caller code can determine the success of operation.
        // Returned if no exception is thrown/handled.
        return true;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        // TODO: Implement get() method.
        $profile = null;
        try
        {
            $profile = $this->em->find($this->repository, $id);
        }
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return $profile;
    }

    /**
     * @param Profile $profile
     * @return mixed
     */
    public function delete(Profile $profile)
    {
        // TODO : Implement delete() method.
        // TODO : Handle FAILURE
        $this->em->remove($profile);
        $this->em->flush();
        return true;
    }

    /**
     * @param DateTime $date
     * @return null
     */
    public function getByDateCreated(DateTime $date)
    {
        try
        {}
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return null;
    }

    /**
     * @param DateTime $date
     * @return null
     */
    public function getByDateModified(DateTime $date)
    {
        try
        {}
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return null;
    }

    /**
     * @param string $json
     * @return null
     */
    public function getByJSON(string $json)
    {
        try
        {}
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return null;
    }
}