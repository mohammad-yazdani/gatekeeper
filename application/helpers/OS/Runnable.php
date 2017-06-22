<?php
/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:31 PM
 */

namespace OS;


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
     */
    public function setScript(string $script)
    {
        $this->script = $script;
    }

    /**
     * @return string
     */
    public function Run()
    {
        //$command = $this->base_path.$this->script;
        $command = $this->base_path.$this->script;

        foreach ($this->args as $arg )
        {
            $command = $command." ".$arg;
        }

        $command = $this->env." ".$command;

        echo "Command: ".$command."\n";

        $result = exec($command);

        echo "Result: ".$result;

        return $result;
    }
}