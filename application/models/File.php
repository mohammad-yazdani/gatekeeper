<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 2017-05-22
 * Time: 3:14 PM
 */

namespace models;


/**
 * Class File
 * @package models
 */
class File extends \Model
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $data;

    /**
     * File constructor.
     * @param string $path
     * @param string $name
     * @param string $data
     * @param null $dates
     */
    public function __construct(string $path, string $name, string $data, $dates = NULL)
    {
        parent::__construct();
        $this->path = $path;
        $this->name = $name;
        $this->data = $data;
        if ($dates)
        {
            $this->setDateCreated($dates['dateCreated']);
            $this->setDateModified($dates['dateModified']);
        }
        $this->setJSON(json_encode($this->jsonSerialize()));
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
            'dateCreated' => $this->getDateCreated()->format('Y-m-d H:i:s'),
            'dateModified' => $this->getDateModified()->format('Y-m-d H:i:s')
        ];
    }
}