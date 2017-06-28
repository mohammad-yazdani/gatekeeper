<?php
/**
 * Created by Codeanywhere.
 * User: Mohammad Yazdani
 * Date: 5/4/2017
 * Time: 13:08 PM
 */

require_once 'DAO.php';

/**
 * Class DAOImpl
 */
abstract class DAOImpl implements DAO {
    /**
     * @var \Doctrine\ORM\EntityManager $em
     */
    protected $em;


    /**
     * @var string
     */
    protected $repository;


    /**
     * DAOImpl constructor.
     * @param $em
     * @param string $repository
     */
    public function __construct($em, string $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }
}