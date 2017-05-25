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

use DateTime;
use FileSystem\RSA_FileManager;
use Firebase\JWT\JWT;
use models\Auth;
use models\DeviceController;
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
        $result = ($password."".$auth->getSalt() == base64_decode($auth->getAuthString()));
        return $result;
    }

    public function validateKey(string $key) : bool
    {
        $result = 1;
        // TODO : Validate JWT:
        // TODO : Validate the issuer, and the info
        $key_res = new RSA_FileManager();
        // TODO : THE DECODE PART
        $decoded = (array) JWT::decode($key, $key_res->getKey(), array('RS256'));

        //print_r($decoded);

        $iss = $decoded['iss'];
        $aud = $decoded['aud'];
        $init = (int) $decoded['init'];
        $exp = (int) $decoded['exp'];
        $uid = $decoded['deviceInfo']->uid;
        $username = $decoded['deviceInfo']->client;
        $passSaved = $decoded['deviceInfo']->passSaved;

        if (!($iss == "gatekeeper")) $result = 0;
        if (!($username == $aud)) $result = 0;
        $deviceCtrl = new DeviceController();
        $device = $deviceCtrl->get($uid);
        if (!$device) $result = 0;
        else $device = $device->getPassIsSaved();

        if (time() > ($init + $exp))
        {
            $result = 2;
        }

        if ($passSaved == 'true') $passSaved = true;
        else $passSaved = false;
        if ($passSaved !== $device) $result = 0;

        /* TODO : FOR TEST
        $passSavedString = "false";
        if ($passSaved) $passSavedString = "true";

        echo "[iss] ".$iss."\n";
        echo "[aud] ".$aud."\n";
        echo "[init] ".$init."\n";
        echo "[exp] ".$exp."\n";

        // TODO : Will be changed for development.
        // echo "[deviceInfo][uid] ".$uid."\n";

        echo "[deviceInfo][client] ".$username."\n";
        echo "[deviceInfo][passSaved] ".$passSavedString."\n";
        */
        // TODO : Compare save password against database

        switch ($result)
        {
            case 0:
                echo "Corrupted";
                return false;
                break;
            case 2:
                echo "Expired";
                return false;
                break;
            default:
                return true;
        }
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