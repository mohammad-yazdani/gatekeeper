<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:59 PM
 */

require_once 'Authentication.php';
require_once APPPATH.'helpers/os/Analytics/MonthlyReports.php';

use \OS\Analytics\MonthlyReports as MonthlyReports;

class AnalyticsController extends Authentication
{

    private $os;

    private $clientCtrl;

    public function __construct()
    {
        parent::__construct();
        $this->os = new MonthlyReports();
        $this->clientCtrl = new ClientController();
    }

    public function index_get()
    {
        $key = $this->uri->segment(2);
        $command = $this->uri->segment(3);

        $options_json = [];

        $option_file_name = false;

        if ($this->uri->segment(4) == "dict_start")
        {
            $index = 5;
            while (!($this->uri->segment($index) == "dict_end"))
            {
                $dict_key = $this->uri->segment($index);
                $dict_value = $this->uri->segment($index + 1);

                $dict_key = str_replace("_", " ", $dict_key);
                // echo "<br/>";
                // echo $dict_key;
                // echo "<br/>";

                if ($dict_key && $dict_value)
                {
                    $options_json[$dict_key] = $dict_value;
                }
                else
                {
                    break;
                }
                $index += 2;
            }

            $options_json = json_encode($options_json);

            /*echo "Options: ";
            echo $options_json;
            echo "<br/>";*/

            $option_file_name = APPPATH."analytics\\options_".(round(microtime(true) * 1000)).".json";

            $option_file = fopen($option_file_name, "w") or die("Unable to open file!");
            fwrite($option_file, $options_json);
            fclose($option_file);
        }
        else
        {
            $options_json = false;
        }

        // TODO : WARNING: REMOVE AFTER TEST $client = $this->evaluate($key);

        $client = true; // TODO : WARNING: REMOVE AFTER TEST

        // echo "For client: ".$client."<br/>";
        // TODO : WARNING: REMOVE AFTER TEST $client = $this->clientCtrl->get($client, null, true);
        if($client)
        {
            try
            {
                if ($options_json != false && $option_file_name != false)
                {
                    $this->os->setScript($command, $option_file_name);
                }
                else
                {
                    $this->os->setScript($command, NULL);
                }
                $result = $this->os->Run();
                echo $result;
                http_response_code(202);
            }
            catch (Exception $e)
            {
                http_response_code(204);
                echo $e->getMessage();
            }
        }
        else
        {
            http_response_code(403);
        }
    }

    public function index_post()
    {
        // TODO : PASS FOR NOW
    }

    public function index_put()
    {
        // TODO: Implement index_put() method.
    }

    public function index_delete()
    {
        // TODO: Implement index_delete() method.
    }

}