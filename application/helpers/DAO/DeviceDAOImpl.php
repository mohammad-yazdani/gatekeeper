<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 1:21 PM
 */

namespace DAO;

require_once APPPATH.'helpers/DAO/DeviceDAO.php';

use DateTime;
use models\Device;
use Symfony\Component\Config\Definition\Exception\Exception;

class DeviceDAOImpl extends \DAOImpl implements DeviceDAO
{
    /**
     * ClientDAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        parent::__construct($em);
    }

    public function save(Device $device)
    {
        // TODO : FIX DESIGN
        try
        {
            $this->em->persist($device);

            $this->em->flush();

            $device->updateJSON();

            $this->em->persist($device);

            $this->em->flush();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        return true;
    }

    public function get($uid)
    {
        $device = null;
        try
        {
            $device = $this->em->find('models\Device', $uid);
        }
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return $device;
    }

    public function getByClient($clientId)
    {
        $device[] = $this->em->getRepository('models\Device')->findBy('');
    }


    public function delete(Device $device)
    {
        $this->em->remove($device);
        $this->em->flush();
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