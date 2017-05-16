<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 3/3/2017
 * Time: 7:41 PM
 */

namespace models;

use Doctrine\ORM\Mapping as ORM;
require_once 'Model.php';

// TODO : Find non-casting solution

/**
 * @ORM\Entity(repositoryClass="Client")
 * @ORM\Table(name="client",uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"username"})}, uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"email"})})
 * 
 */
class Client extends \Model
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $username;

    /** @ORM\Column(type="string") */
    private $email;

    /** @ORM\Column(type="integer") */
    private $user;

    /** @ORM\Column(type="integer") */
    private $authId;

    /**
    * Constructor
     * @param string $username
     * @param string $email
     * @param int $userId
     * @param int $authId
    */
    public function __construct(string $username, string $email, int $userId, int $authId)
    {
        parent::__construct();

        $this->username = $username;
        $this->email = $email;
        $this->user = $userId;
        $this->authId = $authId;
        $this->setJSON(json_encode($this->jsonSerialize()));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAuthId()
    {
        return $this->authId;
    }

    /**
     * @param int $authId
     */
    public function setAuthId($authId)
    {
        $this->authId = $authId;
    }



    /**
     * @return string
     */
    public function getUsername() : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user)
    {
        $this->user = $user;
    }



    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }


  
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'dateCreated' => $this->getDateCreated()->format('Y-m-d H:i:s'),
            'dateModified' => $this->getDateModified()->format('Y-m-d H:i:s'),
            'username' => $this->username,
            'email' => $this->email
        ];
    }
}