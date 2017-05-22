<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 3:13 PM
 */

namespace FileSystem;


use models\File;

/**
 * Interface FileManager
 * @package FileSystem
 */
interface FileManager
{
    /**
     * @param string $name
     * @return File
     */
    public function loadFile (string $name): File;


    /**
     * @param string $name
     * @param string $data
     * @return File
     */
    public function newFile (string $name, string $data): File;

    /**
     * @param File $file
     * @return bool
     */
    public function deleteFile (File $file): bool;

    /**
     * @param string $name
     * @return bool
     */
    public function fileExists (string $name): bool;


    /**
     * @param File $file
     * @param string $newData
     * @param bool $append
     * @return File
     */
    public function updateFile (File $file, string $newData, bool $append = false): File;
}