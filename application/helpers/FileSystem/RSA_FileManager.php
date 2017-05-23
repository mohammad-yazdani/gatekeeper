<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 3:20 PM
 */

namespace FileSystem;

require_once 'FileManager.php';

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
        $publicKey = null;
        $privateKey = null;

        $openssl_res = openssl_pkey_new();

        if ($openssl_res) {
            echo "OPEN_SSL RES: ".$openssl_res."<br/>";
        } else {
            echo "OPEN_SSL RES: Failed<br/>";
        }

        openssl_pkey_export($openssl_res, $privateKey);

        $publicKey = openssl_pkey_get_details($openssl_res);
        $publicKey = $publicKey["key"];

        $keys = [
            'private' => $privateKey,
            'public' => $publicKey
        ];
        $json = json_encode($keys);
        $toSave = base64_encode($json);

        if ($this->fileExists($this->fileName)) $this->deleteFile($this->loadFile($this->fileName));

        $this->newFile($this->fileName, $toSave);

        return $publicKey;
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
            $publicKey = $data['public'];
        }
        return $publicKey;
    }
}