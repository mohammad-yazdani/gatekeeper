<?php
/**
 * Created by PhpStorm.
 * Date: 2017-05-12
 * Time: 11:09 AM
 */
namespace models;
use Doctrine\ORM\Mapping as ORM;
require_once 'Model.php';
require_once 'Client.php';

/**
 * @ORM\Entity(repositoryClass="Device")
 * @ORM\Table(name="device")
 *
 */
class Device extends \Model
{
    /** @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $uid;

    /** @ORM\Column(type="string") */
    private $clientId;

    /** @ORM\Column(type="boolean") */
    private $isPassSaved;

    /**
     * Constructor
     * @param string $clientId
     */
    public function __construct(string $clientId)
    {
        parent::__construct();
        $this->clientId = $clientId;
        $this->setPassIsSaved(false);
        $this->setJSON(json_encode($this->jsonSerialize()));
    }

    /**
     * @return boolean
     */
    public function getPassIsSaved()
    {
        return $this->isPassSaved;
    }

    /**
     * @param boolean $isPassSaved
     */
    public function setPassIsSaved($isPassSaved)
    {
        $this->isPassSaved = $isPassSaved;
    }

    /**
     * @return int
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        return [
            'uid' => $this->uid,
            'client' => $this->clientId,
            'passSaved' => ($this->isPassSaved)? 'true' : 'false'
        ];
    }


}
