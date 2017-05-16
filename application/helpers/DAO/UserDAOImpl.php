<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/15/2017
 * Time: 3:25 PM
 */

namespace DAO;

require_once 'UserDAO.php';

use DateTime;
use models\User;
use Symfony\Component\Config\Definition\Exception\Exception;

class UserDAOImpl extends \DAOImpl implements UserDAO
{

    /**
     * UserDAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        parent::__construct($em);
    }

    public function save(User $user)
    {
        $this->em->persist($user);

        $this->em->flush();

        $user->updateJSON();

        $this->em->persist($user);

        $this->em->flush();
    }

    public function get($id)
    {
        $user = null;
        try
        {
            $user = $this->em->find('models\User', $id);
        }
        catch (Exception $e)
        {
            // TODO : Handle exceptions
        }
        return $user;
    }

    public function delete(User $user)
    {
        $this->em->remove($user);
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