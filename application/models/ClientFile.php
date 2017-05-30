<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 11:46 AM
 */

require_once 'File.php';

use Doctrine\ORM\Mapping as ORM;
use \models\File;

/**
 * @ORM\Entity(repositoryClass="ClientFile")
 * @ORM\Table(name="client_files")
 *
 */
class ClientFile extends File
{

    /**
     *
     * @ORM\Column(name="uid", type="integer", nullable=false)
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    private $uid;

    /** @ORM\Column(type="string") */
    private $category;

    /** @ORM\Column(type="integer") */
    private $details;

    /** @ORM\Column(type="string") */
    private $owner;

    public function __construct($path, $name, string $owner, string $category,
                                string $details, $data = "", $dates = NULL)
    {
        $path = substr($path, strlen(APPPATH), strlen($path));
        parent::__construct($path, $name, $data, $dates);
        $this->category = $category;
        $this->details = $details;
        $this->owner = $owner;
        $this->setJSON(json_encode($this->jsonSerialize()));
    }

    public function jsonSerialize(): array
    {
        return [
            'uid' => $this->uid,
            'name' => $this->getName(),
            'owner' => $this->owner,
            'path' => $this->getPath(),
            'category' => $this->category,
            'details' => $this->details,
            'dateCreated' => $this->getDateCreated()->format('Y-m-d H:i:s'),
            'dateModified' => $this->getDateModified()->format('Y-m-d H:i:s')
        ];
    }


}