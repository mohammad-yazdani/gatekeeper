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
/**
 * Class Token
 * @package models
 */
class Token extends \Model
{
    /**
     * @var int
     */
    private $availableAt;

    /**
     * @var int
     */
    private $expiresAt;

    /**
     * @var string
     */
    private $issuedBy;

    /**
     * @var string
     */
    private $issuedTo;

    /**
     * @var array
     */
    private $deviceInfo;

    /**
     * Token constructor.
     * @param Device $device
     * @param string $issuedTo
     */
    public function __construct(Device $device, string $issuedTo)
    {
        parent::__construct();

        $this->issuedTo = $issuedTo;

        $this->issuedBy = "gatekeeper";

        $this->availableAt = 60;

        $this->expiresAt = 10800;

        $this->deviceInfo = $device->jsonSerialize();

        $this->setJSON(json_encode($this->jsonSerialize()));
    }

    /**
     * @return string
     */
    public function getIssuedTo(): string
    {
        return $this->issuedTo;
    }

    /**
     * @return array
     */
    public function getDeviceInfo(): array
    {
        return $this->deviceInfo;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'iss' => $this->issuedBy,
            'aud' => $this->issuedTo,
            'init' => $this->availableAt,
            'exp' => $this->expiresAt,
            'deviceInfo' => $this->deviceInfo
        ];
    }
}