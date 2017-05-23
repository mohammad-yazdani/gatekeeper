<?php
/**
 * Created by Codeanywhere.
 * User: Mohammad Yazdani
 * Date: 5/4/2017
 * Time: 13:08 PM
 */

require_once 'DAO.php';

abstract class DAOImpl implements DAO {
		/**
     * @var \Doctrine\ORM\EntityManager $em
     */
    protected $em;

    /**
     * DAOImpl constructor.
     * @param $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }
}