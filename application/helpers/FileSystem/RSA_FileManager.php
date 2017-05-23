<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 3:20 PM
 */

namespace FileSystem;

require_once 'FileManager.php';

require_once APPPATH."third_party\phpseclib\Crypt\RSA.php";
include_once APPPATH."third_party\phpseclib\Math\BigInteger.php";

use models\File;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class RSA_FileManager
 * @package FileSystem
 */
class RSA_FileManager extends FileManager
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * RSA_FileManager constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->fileName = 'key';
        if(!($this->fileExists("auth\\"))) $this->newDir("auth\\");
        $this->dirPath = $this->dirPath."auth\\";
        $this->logHeader = "RSA".$this->logHeader;
    }


    /**
     * @return string
     */
    public function newPublicKey (): string
    {
        $publickey = null;
        $privatekey = null;

        $rsa = new \Crypt_RSA();

        $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
        $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);

        define('CRYPT_RSA_EXPONENT', 65537);
        define('CRYPT_RSA_SMALLEST_PRIME', 64);

        extract($rsa->createKey());

        $keys = [
            'private' => $privatekey,
            'public' => $publickey
        ];
        $json = json_encode($keys);
        $toSave = base64_encode($json);

        if ($this->fileExists($this->fileName)) $this->deleteFile($this->loadFile($this->fileName));

        $this->newFile($this->fileName, $toSave);

        return $publickey;
    }

    /**
     * @return string
     */
    public function getPublicKey (): string
    {
        $publicKey = null;

        if ($this->fileExists($this->fileName))
        {
            $data = $this->loadFile($this->fileName)->getData();
            $data = json_decode(base64_decode($data));
            $publicKey = $data->public;
        }
        return $publicKey;
    }
}