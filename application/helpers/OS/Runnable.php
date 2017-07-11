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
    function __construct(string $env, string $name, string $base, array $args = NULL)
    {

        $this->script = $name;
        $this->base_path = $base;
        $this->args = $args;
        if ($this->args == NULL)
        {
            $this->args = [];
        }
        $this->env = $env;
    }

    /**
     * @param string $script
     * @param $args
     */
    public function setScript(string $script, $args)
    {
        $this->script = $script;
        array_push($this->args, $args);
        // print_r($this->args);
    }

    /**
     * @return string
     */
    public function Run()
    {
        //flush(); ob_flush();
        //sleep(3);

        //$command = $this->base_path.$this->script;
        $command = $this->base_path.$this->script;

        // echo "<br/><br/>".$command."<br/>";

        //$command = APPPATH."analytics\\BF_Script.py";
        // $command = "py ".$command;
        // echo "Command: ".$command."<br/>";

        set_time_limit(60 * 5);

        $CI =& get_instance();

        // print_r($this->args);

        foreach ($this->args as $arg)
        {
            $command .= (" ".$arg);
        }

        // $result = exec($command);

        echo "Running: ".$command."<br/>";

        $result = shell_exec($command);

        // echo "Results: ".$result."\n";

        // TODO : Load download

        $CI->load->helper('download');

        $separator = "\r\n";
        $line = strtok($result, $separator);

        # do something with $line
        $line = strtok( $separator );
        echo "<br/>Line: ".$line."<br/>";

        //echo "<br/>LAST LINE: ".$last_line."<br/>";

        //$data = file_get_contents($line);
        //force_download("report.".pathinfo($line)['extension'], $data);
        //force_download($result);

        //echo "Result: \n".$data;

        return $line;
    }
}