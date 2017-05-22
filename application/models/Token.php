<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 2:06 PM
 */

namespace models;


/**
 * Class Token
 * @package models
 */
class Token extends \Model
{
    private $jwt;

    private $lastValidation;

    private $deviceUID;

    /**
     * Token constructor.
     * @param Device $device
     */
    public function __construct(Device $device)
    {
        parent::__construct();

        $this->deviceUID = $device->getUid();

        $this->lastValidation = $this->getDateCreated();

        $rsa_message = decbin($this->deviceUID) + $this->lastValidation;

        // TODO : Get public key

        // TODO : Generate jwt string

        // TODO : Set as jwt

        $this->auth_string ;
    }

    public function check ()
    {

    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        // TODO: Implement jsonSerialize() method.
    }
}