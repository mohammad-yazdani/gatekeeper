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
require_once APPPATH.'controllers\DeviceController.php';
require_once APPPATH.'helpers\FileSystem\RSA_FileManager.php';
require_once APPPATH.'helpers\JWT\JWT.php';

use DateTime;
use FileSystem\RSA_FileManager;
use Firebase\JWT\JWT;
use models\Auth;
use models\Client;
use models\Device;
use models\DeviceController;
use models\Token;
use Symfony\Component\Config\Definition\Exception\Exception;
use Token\DeviceTokenManager;

class AuthDAOImpl extends \DAOImpl implements AuthDAO
{
    /**
     * AuthDAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        parent::__construct($em, 'models\Auth');
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
            $auth = $this->em->find($this->repository, $id);
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

    public function get_key($client, $device)
    {
        return DeviceTokenManager::generate($device, $client);
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
        $auth_string = password_hash($password, PASSWORD_BCRYPT);
        $auth->setAuthString(base64_encode($auth_string));

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
        $result = password_verify($password, base64_decode($auth->getAuthString()));
        return $result;
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