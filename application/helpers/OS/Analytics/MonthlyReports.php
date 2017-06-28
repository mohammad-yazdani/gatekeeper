<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:31 PM
 */

namespace OS\Analytics;

require_once APPPATH.'helpers/os/Runnable.php';

use OS\Runnable;

/**
 * Class MonthlyReports
 * @package OS\Analytics
 */
class MonthlyReports extends Runnable
{
    /**
     * MonthlyReports constructor.
     * @param string|null $name
     * @param array $args
     */
    function __construct(string $name = "", $args = array())
    {
        parent::__construct("", $name, APPPATH."analytics\\", $args);
    }
}