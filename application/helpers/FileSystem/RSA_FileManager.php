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
    private $publicKeyFileName;

    private $privateKeyFileName;

    private $rsa;

    /**
     * RSA_FileManager constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->publicKeyFileName = 'publicKey.pem';
        $this->privateKeyFileName = 'privateKey.pem';
        if(!($this->fileExists("auth\\"))) $this->newDir("auth\\");
        $this->dirPath = $this->dirPath."auth\\";
        $this->rsa = new \Crypt_RSA();
        $this->logHeader = "RSA".$this->logHeader;
    }


    /**
     *
     */
    private function newPublicKey ()
    {
        $publicKey = null;
        $privateKey = null;

        /* TODO : Using PHPSecLib
        $this->rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
        $this->rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);

        define('CRYPT_RSA_EXPONENT', 65537);
        define('CRYPT_RSA_SMALLEST_PRIME', 64);

        extract($this->rsa->createKey());

        if ($this->fileExists($this->publicKeyFileName)) $this->deleteFile($this->loadFile($this->publicKeyFileName));
        if ($this->fileExists($this->privateKeyFileName)) $this->deleteFile($this->loadFile($this->privateKeyFileName));
        */

        // TODO : Using OpenSSL
        $opensslConfigPath = "C:\\xampp\apache\conf\openssl.cnf";
        $config = array(
            "config" => $opensslConfigPath,
            "digest_alg" => "sha512",
            "private_key_bits" => 4096,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        );
        $res = openssl_pkey_new($config);
        echo "Error: ".openssl_error_string()."<br/>";
        openssl_pkey_export($res, $privateKey);
        $details = openssl_pkey_get_details($privateKey);
        $publicKey = $details['key'];

        //$this->newFile($this->privateKeyFileName, $privateKey);
        //$this->newFile($this->publicKeyFileName, $publicKey);
    }


    /**
     * @param bool $private
     * @return string
     */
    public function getKey (bool $private = false): string
    {
        $key = null;
        $fileName = null;

        if($private) $fileName = $this->privateKeyFileName;
        else $fileName = $this->publicKeyFileName;

        if (!$this->fileExists($fileName)) $this->newPublicKey();
        $key = $this->loadFile($fileName)->getData();

        return $key;
    }
}