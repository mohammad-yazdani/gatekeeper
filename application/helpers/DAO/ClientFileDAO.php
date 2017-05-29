<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 5/29/2017
 * Time: 11:52 AM
 */

namespace DAO;


interface ClientFileDAO extends \DAO
{
    public function save(\ClientFile $clientFile) : bool;

    public function get(int $uid);

    public function delete(\ClientFile $clientFile);

    public function getByCategory(string $category) : array ;

    public function getByName(string $name) : array ;
}