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

    /** @ORM\Column(type="integer") */
    private $clientId;

    /** @ORM\Column(type="boolean") */
    private $isPassSaved;

    /**
     * Constructor
     * @param int $clientId
     */
    public function __construct(int $clientId)
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
     * @return array
     */
    public function jsonSerialize() : array
    {
        return [
            'uid' => $this->uid,
            'client' => $this->clientId
        ];
    }


}
