<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:31 PM
 */

namespace OS;

require_once APPPATH."controllers\\HomeController.php";

/**
 * Class Runnable
 * @package OS
 */
abstract class Runnable
{
    /**
     * @var string
     */
    protected $base_path;

    /**
     * @var string
     */
    protected $script;

    /**
     * @var array
     */
    protected $args;

    protected $env;

    /**
     * Runnable constructor.
     * @param string $env
     * @param string $name
     * @param string $base
     * @param array $args
     */
    function __construct(string $env, string $name, string $base, array $args)
    {

        $this->script = $name;
        $this->base_path = $base;
        $this->args = $args;
        $this->env = $env;
    }

    /**
     * @param string $script
     * @param null $args
     */
    public function setScript(string $script, $args = NULL)
    {
        $this->script = $script;
        $this->args = $args;
    }

    /**
     * @return string
     */
    public function Run()
    {
        echo "Running ".$this->script;

        //flush(); ob_flush();
        //sleep(3);

        //$command = $this->base_path.$this->script;
        $command = $this->base_path.$this->script;

        foreach ($this->args as $arg )
        {
            $command = $command." ".$arg;
        }

        $command = $this->env." ".$command;

        //$command = APPPATH."analytics\\BF_Script.py";
        // $command = "py ".$command;
        // echo "Command: ".$command."<br/>";

        set_time_limit(60 * 5);

        $CI =& get_instance();

        $result = exec($command);

        // echo "Results: ".$result."\n";

        // TODO : Load download

        $CI->load->helper('download');

        if (!strpos($result, APPPATH)) {
             return $result;
        }

        $data = file_get_contents($result);
        force_download("report.xlsx", $data);
        force_download($result);

        //echo "Result: \n".$result;

        return $result;
    }
}