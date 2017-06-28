<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 12:01 PM
 */

namespace DAO;

require_once 'ClientFileDAO.php';

use DateTime;
use Symfony\Component\Config\Definition\Exception\Exception;

class ClientFileDAOImpl extends \DAOImpl implements ClientFileDAO
{
    public function __construct($em)
    {
        parent::__construct($em, 'models\ClientFile');
    }

    public function save(\ClientFile $clientFile): bool
    {
        try
        {
            $this->em->persist($clientFile);
            $this->em->flush();
            $clientFile->updateJSON();
            $this->em->persist($clientFile);
            $this->em->flush();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        return true;
    }

    public function get(int $uid)
    {
        $clientFile = null;
        try
        {
            $clientFile = $this->em->find($this->repository, $uid);
        }
        catch (Exception $e)
        {
            // TODO : Handle exceptions
            log_message('error', $e->getMessage());
        }
        return $clientFile;
    }

    public function delete(\ClientFile $clientFile): bool
    {
        try
        {
            // TODO : Implement delete() method.
            // TODO : Handle FAILURE
            $this->em->remove($clientFile);
            $this->em->flush();
        }
        catch (Exception $e)
        {
            // TODO : Handle exceptions
            log_message('error', $e->getMessage());
        }
        return true;
    }

    public function getByCategory(string $category): array
    {
        return $this->em->getRepository($this->repository)->findBy(array('category' => $category));
    }

    public function getByName(string $name): array
    {
        return $this->em->getRepository($this->repository)->findBy(array('name' => $name));
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