<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:59 PM
 */

// TODO : CLEAN CODE

require_once 'Authentication.php';
require_once APPPATH.'helpers/os/Analytics/MonthlyReports.php';
require_once APPPATH.'helpers/DAO/ProfileDAOImpl.php';

use \models\Profile;
use \DAO\ProfileDAOImpl;
use \OS\Analytics\MonthlyReports as MonthlyReports;

/**
 * Class AnalyticsController
 */
class AnalyticsController extends Controller
{

    /**
     * @var MonthlyReports
     */
    private $os;

    /**
     * @var
     */
    private $clientCtrl;

    /**
     * AnalyticsController constructor.
     */
    public function __construct()
    {
        $this->os = new MonthlyReports();
        $CI =& get_instance();
        $CI->load->library('doctrine');
        $em = $CI->doctrine->em;
        $this->dao = new ProfileDAOImpl($em);
    }

    /**
     * @param null $json_input
     * @param null $config
     * Sample input = { 'command', 'subject', other fields}
     */
    public function get($json_input = NULL, $config = NULL)
    {
        try
        {
            $options_json = json_encode($json_input);
            $option_file_name = APPPATH."analytics\\temp.json";
            $option_file = fopen($option_file_name, "w") or die("Unable to open file!");
            fwrite($option_file, $options_json);
            fclose($option_file);

            if ($options_json != false && $option_file_name != false)
            {
                $this->os->setScript($json_input['command'], $option_file_name);
                $result = $this->os->Run();
                if (!$result)
                {
                    http_response_code(Authentication::HTTP_UNPROCESSABLE_ENTITY);
                    return;
                }
                else
                {
                    $data = file_get_contents($result);
                    force_download($json_input["subject"].".".pathinfo($result)['extension'], $data);
                    force_download($result);
                    http_response_code(Authentication::HTTP_ACCEPTED);
                }
            }
            else
            {
                http_response_code(Authentication::HTTP_BAD_REQUEST);
                die(Authentication::$badRequest_400);
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            http_response_code(Authentication::HTTP_NO_CONTENT);
        }
    }


    /**
     * @param null $input
     * @param null $config
     * Sample input = { 'info': { key, name, type }, 'data': { Input data }}
     */
    public function post($input = NULL, $config = NULL)
    {
        $input = json_decode($input)['info'];
        $data = json_decode($input)['data'];
        $client = null;
        try
        {
            $client = $this->evaluate($input['key']);
            $client = $this->clientCtrl->get($client, null, true);
            if($client)
            {
                try
                {
                    $data = json_decode($data);
                    $data = json_encode($data);

                    $profile = new Profile($input['name'], $data, $input['type']);
                    $this->dao->save($profile);
                    http_response_code(201);
                }
                catch (\Doctrine\DBAL\Exception\UniqueConstraintViolationException $e)
                {
                    http_response_code(400);
                    die("Profile already exists!");
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
                die(Authentication::$forbidden_403);
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
            die(Authentication::$badRequest_400);
        }
    }

    /**
     * @param null $key
     * @param null $xss_clean
     */
    public function put($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement put() method.
    }

    /**
     * @param null $key
     * @param null $xss_clean
     */
    public function delete($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param null $json_input
     * @param null $config
     */
    public function REST_GET($json_input = NULL, $config = NULL)
    {
        $this->get($json_input, $config);
    }

    /**
     * @param string $json
     */
    public function REST_POST(string $json)
    {
        $this->post($json, NUll);
    }

    /**
     * @param string $json
     */
    public function REST_PUT(string $json)
    {
        // TODO: Implement REST_PUT() method.
    }

    /**
     * @param string $json
     */
    public function REST_DELETE(string $json)
    {
        // TODO: Implement REST_DELETE() method.
    }


}