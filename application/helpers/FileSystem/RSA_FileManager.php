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
class RSA_FileManager implements FileManager
{

    /**
     * @var string
     */
    private static $dirPath = APPPATH."auth/";

    /**
     * @var string
     */
    private static $logHeader = "RSA File manager: ";

    /**
     * @param string $name
     * @return File
     */
    public function loadFile(string $name): File
    {
        $filePath = self::$dirPath.$name;
        $openedFile = null;
        try
        {
            if ($this->fileExists($name))
            {
                // TODO : Read data
                $handle = fopen($filePath, "r");
                $data = fread($handle, filesize($filePath));

                $dates = null;
                $dates = [filemtime($filePath), fileatime($filePath)];

                fclose($handle);

                $openedFile = new File($filePath, $name, $data, $dates);
            }
            else
            {
                log_message(self::$logHeader.$name." does not exist!", '
                error');
                return null;
            }
        }
        catch (Exception $e)
        {
            log_message($e->getMessage(), 'error');
        }

        return $openedFile;
    }

    /**
     * @param string $name
     * @param string $data
     * @return File
     */
    public function newFile(string $name, string $data): File
    {
        $filePath = self::$dirPath.$name;
        $newFile = null;

        try
        {
            if (!$this->fileExists($filePath))
            {
                $handle = fopen($filePath, 'w+');
                if (fputs($handle, $data))
                {
                    $newFile = new File($filePath, $name, $data);
                }
                else
                {
                    log_message(self::$logHeader."Cannot write to newly created file!", 'error');
                }
                fclose($handle);
            }
            else
            {
                log_message(self::$logHeader."File already exists!", 'error');
                return NULL;
            }
        }
        catch (Exception $e)
        {
            log_message(self::$logHeader.$e->getMessage(), 'error');
            return NULL;
        }

        return $newFile;
    }


    /**
     * @param File $file
     * @return bool
     */
    public function deleteFile(File $file): bool
    {
        $result = false;
        try
        {
            if ($file)
            {
                $result = unlink($file->getPath());
            }
            else
            {
                $result = false;
                log_message(self::$logHeader."Cannot delete non-existing file ".$file->getPath(), 'error');
            }
        }
        catch (Exception $e)
        {
            log_message(self::$logHeader.$e->getMessage(), 'error');
        }
        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function fileExists(string $name): bool
    {
        $filePath = self::$dirPath.$name;
        return file_exists($filePath);
    }


    /**
     * @param File $file
     * @param string $newData
     * @param bool $append
     * @return File
     */
    public function updateFile(File $file, string $newData, bool $append = false): File
    {
        try
        {
            if ($file)
            {
                $handle = fopen($file->getPath(), 'w+');
                if (fputs($handle, $newData))
                {
                    if ($append)
                    {
                        $file->setData($file->getData().$newData);
                    }
                    else
                    {
                        $file->setData($newData);
                    }
                }
                else
                {
                    log_message(self::$logHeader."Cannot update/write to file!", 'error');
                }
                fclose($handle);
            }
            else
            {
                log_message(self::$logHeader."File does not exist!", 'error');
                return NULL;
            }
        }
        catch (Exception $e)
        {
            log_message(self::$logHeader.$e->getMessage(), 'error');
            return NULL;
        }

        return $file;
    }

    /**
     * @return string
     */
    public function newPublicKey (): string
    {
        $publicKey = null;

        // TODO : Generate public and private key
        // TODO : Save both
        // TODO : Delete previous key pair
        // TODO : Return public

        return $publicKey;
    }
}