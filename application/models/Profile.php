<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/6/2017
 * Time: 8:55 AM
 */

namespace models;

use Doctrine\ORM\Mapping as ORM;
require_once 'Model.php';

// TODO : Find non-casting solution

/**
 * @ORM\Entity(repositoryClass="Profile")
 * @ORM\Table(name="profile",uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"name"})})
 */

class Profile extends \Model
{

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @ORM\Id
     */
    private $name;

    /**
     * @ORM\Column(name="json_data", type="string", nullable=false)
     */
    private $json_data;

    /**
     * Client constructor.
     * @param string $name
     * @param string $json
     */
    public function __construct(string $name, string $json)
    {
        parent::__construct();

        $this->name = $name;
        $this->json_data = $json;

        $this->setJSON(json_encode($this->jsonSerialize()));
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'name' =>  $this->name,
            'json'=> $this->json_data
        ];
    }
}