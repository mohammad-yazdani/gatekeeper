<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/12/2017
 * Time: 11:45 AM
 */

namespace models;

use Doctrine\ORM\Mapping as ORM;

require_once 'Model.php';

/**
 * @ORM\Entity(repositoryClass="Auth")
 * @ORM\Table(name="auth")
 *
 */
class Auth extends \Model
{

    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /** @ORM\Column(type="string") */
    private $salt;

    /** @ORM\Column(type="string") */
    private $auth_string;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getAuthString(): string
    {
        return $this->auth_string;
    }

    /**
     * @param string $auth_string
     */
    public function setAuthString(string $auth_string)
    {
        $this->auth_string = $auth_string;
    }
    
    

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return [
            'dateCreated' => $this->getDateCreated()->format('Y-m-d H:i:s'),
            'dateModified' => $this->getDateModified()->format('Y-m-d H:i:s'),
            'salt' => $this->salt,
            'auth_string' => $this->auth_string
        ];
    }
}