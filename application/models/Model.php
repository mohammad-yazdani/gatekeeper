<?php

/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 3/24/2017
 * Time: 8:59 PM
 */

/*
 * This class is used to allow dynamic dispatch for DAO services.
 * Every model inherits the model class.
 */

// TODO : Find non-casting solution (setJSON param should enforce string)

require_once APPPATH.'../system/core/Model.php';
use Doctrine\ORM\Tools\SchemaTool as SchemaTool;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Tools\ToolsException as ToolsException;

/** @ORM\MappedSuperclass */
abstract class Model extends CI_Model implements JsonSerializable
{
    /*
     * For every model class field JSON is to
     * store it's appropriate data in form of
     * stringify JSON object.
     */
    /** @ORM\Column(type="string") */
    private $JSON;
  
    /** @ORM\Column(type="date")  */
    private $dateCreated;

    /** @ORM\Column(type="date")  */
    private $dateModified;
  
  
    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();

        $this->setDateCreated(new DateTime());
        $this->setDateModified(new DateTime());

        // TODO : TEST
        //echo "Model ctor running (pre create)<br/>";
        // TODO : Create table (IF DOESN'T EXIST) using schema tools HERE!
        try {
            $tool = new SchemaTool($this->doctrine->em);
            $class = array(
                $this->doctrine->em->getClassMetadata(get_class($this))
            );
            $tool->createSchema($class);
            //echo get_class($this)." Table Now Exists <br/>";
        }
        catch (Exception $e) {
            //echo $e->getMessage()."<br/";
        }
        // TODO : TEST
        //echo "<br/>Model Ctor finished<br/>";
    }
  
    /**
     * @return string
     */
    public function getJSON()
    {
        return $this->JSON;
    }

    /**
     * @param string $json
     */
    protected function setJSON(string $json)
    {
        $this->JSON = $json;
    }
  
    /**
     * @return DateTime
     */
    protected function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param DateTime $dateCreated
     */
    protected function setDateCreated(DateTime $dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return DateTime
     */
    protected function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param DateTime $dateModified
     */
    protected function setDateModified(DateTime $dateModified)
    {
        $this->dateModified = $dateModified;
    }

    /**
     * @return array
     */
    abstract public function jsonSerialize() : array ;

    /**
     * @return void
     */
    public function updateJSON()
    {
        $this->setJSON(json_encode($this->jsonSerialize()));
    }
}