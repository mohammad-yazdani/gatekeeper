<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 3:13 PM
 */

namespace FileSystem;


use models\File;
use Symfony\Component\Config\Definition\Exception\Exception;


/**
 * Class FileManager
 * @package FileSystem
 */
abstract class FileManager
{
    /**
     * @var string
     */
    protected $dirPath;

    /**
     * @var string
     */
    protected $logHeader;

    /**
     * FileManager constructor.
     */
    protected function __construct()
    {
        $this->dirPath = APPPATH."files\\";
        if (!file_exists($this->dirPath)) mkdir($this->dirPath);
        $this->logHeader = " File manager: ";
    }


    /**
     * @param string $name
     * @return File
     */
    protected function loadFile(string $name): File
    {
        $filePath = $this->dirPath.$name;
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
                log_message($this->logHeader.$name." does not exist!", '
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
    protected function newFile(string $name, string $data): File
    {
        $filePath = $this->dirPath.$name;
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
                    log_message($this->logHeader."Cannot write to newly created file!", 'error');
                }
                fclose($handle);
            }
            else
            {
                log_message($this->logHeader."File already exists!", 'error');
                return NULL;
            }
        }
        catch (Exception $e)
        {
            log_message($this->logHeader.$e->getMessage(), 'error');
            return NULL;
        }

        return $newFile;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function newDir (string $name): bool
    {
        $result = null;
        try
        {
            $result = mkdir($this->dirPath.$name);
        }
        catch (Exception $e)
        {
            log_message('error', $e->getMessage());
        }
        return $result;
    }

    /**
     * @param File $file
     * @return bool
     */
    protected function deleteFile(File $file): bool
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
                log_message($this->logHeader."Cannot delete non-existing file ".$file->getPath(), 'error');
            }
        }
        catch (Exception $e)
        {
            log_message($this->logHeader.$e->getMessage(), 'error');
        }
        return $result;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function fileExists(string $name): bool
    {
        $filePath = $this->dirPath.$name;
        return file_exists($filePath);
    }


    /**
     * @param File $file
     * @param string $newData
     * @param bool $append
     * @return File
     */
    protected function updateFile(File $file, string $newData, bool $append = false): File
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
                    log_message($this->logHeader."Cannot update/write to file!", 'error');
                }
                fclose($handle);
            }
            else
            {
                log_message($this->logHeader."File does not exist!", 'error');
                return NULL;
            }
        }
        catch (Exception $e)
        {
            log_message($this->logHeader.$e->getMessage(), 'error');
            return NULL;
        }

        return $file;
    }
}