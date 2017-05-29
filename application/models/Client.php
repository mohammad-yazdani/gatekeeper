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
     * @var string
     *
     * @ORM\Column(name="username", type="string", nullable=false)
     * @ORM\Id
     */
    private $username;

    /** @ORM\Column(type="string") */
    private $email;

    /** @ORM\Column(type="integer") */
    private $user;

    /** @ORM\Column(type="integer") */
    private $authId;

    /** @ORM\Column(type="boolean") */
    private $readAccess;

    /** @ORM\Column(type="boolean") */
    private $writeAccess;

    /** @ORM\Column(type="array") */
    private $scope;


    /**
     * Client constructor.
     * @param string $username
     * @param string $email
     * @param int $userId
     * @param int $authId
     * @param bool $read
     * @param bool $write
     * @param array|null $scope
     */
    public function __construct(string $username, string $email, int $userId, int $authId, bool $read = false, bool $write = false, array $scope = null)
    {
        parent::__construct();

        $this->username = $username;
        $this->email = $email;
        $this->user = $userId;
        $this->authId = $authId;
        $this->readAccess = $read;
        $this->writeAccess = $write;
        $this->scope = $scope;
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

    /**+
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


    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'read' => $this->readAccess,
            'write' => $this->writeAccess,
            'scope' => $this->scope,
            'dateCreated' => $this->getDateCreated()->format('Y-m-d H:i:s'),
            'dateModified' => $this->getDateModified()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @return array
     */
    public function getScope() : array
    {
        return $this->scope;
    }

    /**
     * @param array $scope
     */
    public function setScope(array $scope)
    {
        $this->scope = $scope;
    }


}