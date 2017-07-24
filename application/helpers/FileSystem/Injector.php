<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 7/24/2017
 * Time: 12:06 PM
 */

namespace FileSystem;

// TODO : CLEAN-CODE

/**
 * Class Injector
 * @package FileSystem
 */
class Injector extends FileManager
{
    /**
     * Injector constructor.
     * @param string $destination
     */
    public function __construct(string $destination)
    {
        parent::__construct();
        $this->dirPath = $destination;
        $this->logHeader = "Injector: ";
    }

    /**
     * @param string $name
     * @param string $data
     * @return string
     */
    public function send_distinct(string $name, string $data): string
    {
        $final_name = $name;
        $count = 0;
        while ($this->fileExists($final_name))
        {
            $count += 1;
            $final_name = $name."_".$count;
        }
        $file = $this->newFile($final_name, $data);
        return $file->getPath();
    }

    /**
     * @param string $name
     * @param string $data
     * @return string
     */
    public function send_unique(string $name, string $data): string
    {
        if ($this->fileExists($name))
        {
            $this->deleteFile($this->loadFile($name));
        }
        $file = $this->newFile($name, $data);
        return $file->getPath();
    }
}