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

        $client = $this->evaluate($key);
        echo "For client: ".$client."<br/>";
        $client = $this->clientCtrl->get($client, null, true);
        if($client)
        {
            try
            {
                $this->os->setScript($command);
                $result = $this->os->Run();
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