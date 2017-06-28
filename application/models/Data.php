<?php
/**
 * Created by PhpStorm.
 * Date: 2017-05-12
 * Time: 11:15 AM
 */
namespace models;
use Doctrine\ORM\Mapping as ORM;
require_once 'Model.php';

/**
 * @ORM\Entity(repositoryClass="Data")
 * @ORM\Table(name="data")
 *
 */
class Data extends \Model
{
    /** @ORM\Column(type="string") */
    private $data;


    /**
     * Constructor
     * @param string $data
     */
    public function __construct(string $data)
    {
        parent::__construct();
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
          'data' => $this->data
        ];
    }


}
