<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:59 PM
 */

require_once 'Authentication.php';
require_once APPPATH.'helpers/os/Analytics/MonthlyReports.php';
require_once APPPATH.'helpers/DAO/ProfileDAOImpl.php';
require_once APPPATH.'models/Profile.php';

use \OS\Analytics\MonthlyReports as MonthlyReports;
use \models\Profile as Profile;

class AnalyticsController extends Controller
{
    private $os;

    private $profileDAO;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->os = new MonthlyReports();
        $this->profileDAO = new \DAO\ProfileDAOImpl($em);
    }

    public function get($key = NULL, $options = NULL, $xss_clean = NULL)
    {
        try
        {
            $this->os->setScript($key, $options);
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

    public function get_profile($name)
    {
        try
        {
            $profile = $this->profileDAO->get($name);
            echo $profile->json_data;
            http_response_code(200);
        }
        catch (Exception $e)
        {
            http_response_code(404);
            echo $e->getMessage();
        }
    }

    public function post($profile_name = NULL, $profile_json = NULL)
    {
        $profile = new Profile($profile_name, $profile_json);
        if ($this->profileDAO->save($profile))
        {
            http_response_code(201);
            return true;
        }
        else
        {
            http_response_code(400);
            echo Authentication::$badRequest_400;
            return false;
        }
    }

    public function put($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement put() method.
    }

    public function delete($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement delete() method.
    }

    public function REST_GET($command, $options = NULL, bool $profile = false)
    {
        if ($profile)
        {
            $this->get_profile($command);
        }
        $this->get($command, $options);
    }

    public function REST_POST(string $name, string $json = "N/A")
    {
        $this->post($profile_name=$name, $profile_json=$json);
    }

    public function REST_PUT(string $json)
    {
        // TODO: Implement REST_PUT() method.
    }

    public function REST_DELETE(string $json)
    {
        // TODO: Implement REST_DELETE() method.
    }

}