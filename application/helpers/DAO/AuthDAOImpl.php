<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 4:38 PM
 */

namespace DAO;

require_once 'DAOImpl.php';
require_once 'AuthDAO.php';

use DateTime;
use models\Auth;
use Symfony\Component\Config\Definition\Exception\Exception;

class AuthDAOImpl extends \DAOImpl implements AuthDAO
{
    /**
     * AuthDAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        parent::__construct($em);
    }

    public function save(Auth $auth)
    {
        $this->em->persist($auth);

        $this->em->flush();

        $auth->updateJSON();

        $this->em->persist($auth);

        $this->em->flush();
    }

    public function get($id)
    {
        $auth = null;
        try
        {
            $auth = $this->em->find('models\auth', $id);
        }
        catch (Exception $e)
        {
            log_message('error',
                "Failed to get Auth object from database. Exception: ".$e->getMessage());
            $auth = null;
        }
        return $auth;
    }

    public function delete(Auth $auth)
    {
        $auth = $this->get($auth->getId());
        if ($auth != null)
        {
            try
            {
                $this->em->remove($auth);
            }
            catch (Exception $e)
            {
                log_message('error',
                    "Failed to delete Auth object with from database. Exception: ".$e->getMessage());
                return false;
            }
        }
        return true;
    }

    /**
     * @param int $id
     * @param string $password
     * @return Auth
     */
    public function encrypt(string $password, int $id = null) : Auth
    {
        $auth = null;
        if ($id)
        {
            $auth = $this->get($id);
        }
        else
        {
            $auth = new Auth();
        }
        // TODO : Implement algorithms for authentication
        // TODO : Generate salt

        // TODO : WARNING! -> NOT SECURE / TEMPORARY
        $auth->setSalt("saltVal");
        $auth->setAuthString(base64_encode($password.$auth->getSalt()));

        $this->save($auth);

        return $auth;
    }

    /**
     * @param int $id
     * @param string $password
     * @return boolean
     */
    public function decrypt(int $id, string $password) : bool
    {
        $auth = $this->get($id);
        // TODO : Implement algorithms for authentication

        // TODO : WARNING! -> NOT SECURE / TEMPORARY
        return ($password."".$auth->getSalt() == base64_decode($auth->getAuthString()));
    }

    public function validateKey(string $key)
    {
        return strpos($key, "saltVal");
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