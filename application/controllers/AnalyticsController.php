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

use \models\Profile;
use \DAO\ProfileDAOImpl;
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
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->dao = new ProfileDAOImpl($em);
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
            $option_file_name = APPPATH."analytics\\temp.json";
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
                shell_exec("echo hey");

                if ($options_json != false && $option_file_name != false)
                {
                    $this->os->setScript($command, $option_file_name);
                    // unlink($option_file_name);
                    // $this->os->setScript($command, $options_json);
                }
                else
                {
                    $this->os->setScript($command, NULL);
                }
                $result = $this->os->Run();
                if (!$result)
                {
                    http_response_code(Authentication::HTTP_UNPROCESSABLE_ENTITY);
                        return;
                }
                else
                {
                    $data = file_get_contents($result);
                    force_download("report.".pathinfo($result)['extension'], $data);
                    force_download($result);
                    http_response_code(202);
                }
            }
            catch (Exception $e)
            {
                http_response_code(Authentication::HTTP_NO_CONTENT);
                echo $e->getMessage();
            }
        }
        else
        {
            http_response_code(Authentication::HTTP_FORBIDDEN);
        }

        if (file_exists($option_file_name))
        {
            //unlink($option_file_name);
        }
    }

    public function index_post()
    {
        $key = $this->uri->segment(2);
        $name = $this->uri->segment(3);
        $type = $this->uri->segment(4);

        $client = null;

        try
        {
            $client = $this->evaluate($key);
            $client = $this->clientCtrl->get($client, null, true);

            if($client)
            {
                try
                {
                    $data = file_get_contents('php://input');
                    $data = json_decode($data);
                    $data = json_encode($data);

                    $profile = new Profile($name, $data, $type);

                    $this->dao->save($profile);

                    print_r($profile);

                    http_response_code(201);
                }
                catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e)
                {
                    echo "Profile already exists!";
                    http_response_code(400);
                    // die($e->getMessage());
                }
                catch (Exception $e)
                {
                    http_response_code(501);
                    die($e->getMessage());
                }
            }
            else
            {
                http_response_code(403);
            }
        }
        catch (UnexpectedValueException $e)
        {
            http_response_code(401);
            die(Authentication::$unauthorized_401);
        }
        catch (Exception $e)
        {
            http_response_code(400);
            die($e->getMessage());
        }
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