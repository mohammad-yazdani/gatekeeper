<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 3:20 PM
 */

namespace FileSystem;


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
     * @param $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct();
        $this->dirPath = $this->dirPath."auth/";
        if (!$this->fileExists($this->dirPath)) $this->newDir($this->dirPath);
        $this->logHeader = "RSA".$this->logHeader;
        $this->fileName = $fileName;
    }


    /**
     * @return string
     */
    public function newPublicKey (): string
    {
        $publicKey = null;
        $privateKey = null;

        $openssl_res = openssl_pkey_new();
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

        if ($this->fileExists('key'))
        {
            $data = $this->loadFile($this->fileName)->getData();
            $data = json_decode(base64_decode($data));
            $publicKey = $data['public'];
        }
        return $publicKey;
    }
}