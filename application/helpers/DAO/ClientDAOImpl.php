<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 3/7/2017
 * Time: 5:49 PM
 */


// TODO : DOCS

namespace DAO;

require_once "DAOImpl.php";
require_once "ClientDAO.php";
require_once APPPATH."models/Client.php";

use models\Client;
use DAOImpl;
use Symfony\Component\Config\Definition\Exception\Exception;

class ClientDAOImpl extends DAOImpl implements ClientDAO
{
    /**
     * ClientDAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        parent::__construct($em, 'models\Client');
    }
	
    public function save(Client $client)
    {
        // The object to be saved is the parameter $client of type "model/Client"
        // TODO : FIX DESIGN
        try
        {
            // TODO : DOC
            $this->em->persist($client);

            // TODO : DOC
            $this->em->flush($client);

            $client->updateJSON();

            // TODO : DOC
            $this->em->persist($client);
            // TODO : DOC
            $this->em->flush();
        } // TODO : DOC
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        // Method returns true so that the caller code can determine the success of operation.
        // Returned if no exception is thrown/handled.
        return true;
    }

    public function get($id)
    {
      	// TODO: Implement get() method.
      	$client = null;  
        try
        {
            $client = $this->em->find($this->repository, $id);
        }
        catch (Exception $e)
      	{
            // TODO : Handle exceptions
        }
        return $client;
    }

    public function checkForUsername($username) : bool
    {
        $result = NULL;
        try
        {
            $result = $this->em->find($this->repository, $username);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
            $result = NULL;
        }
        if ($result == null) return false;
        else return true;
    }

    public function checkForEmail($email) : bool
    {
        $result = $this->em->find($this->repository, $email);
        if ($result == null) return false;
        else return true;
    }


    public function delete(Client $client)
    {
      	// TODO : Implement delete() method.
        // TODO : Handle FAILURE
        $this->em->remove($client);
        $this->em->flush();
    }
    

    public function getByDateCreated(\DateTime $date)
    {
        try
        {

        }
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return null;
    }

    public function getByDateModified(\DateTime $date)
    {
        try
        {}
        catch (Exception $e)
        {}
        return null;
    }
  
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