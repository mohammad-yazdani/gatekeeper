<?php

/**
 * Created by PhpStorm.
 * User: myazdani
 * Date: 6/22/2017
 * Time: 3:59 PM
 */

// TODO : CODE CLEANED (EXCEPT POST)

require_once 'Authentication.php';
require_once APPPATH.'helpers/os/Analytics/MonthlyReports.php';
require_once APPPATH.'helpers/DAO/ProfileDAOImpl.php';

use \models\Profile;
use \DAO\ProfileDAOImpl;
use \OS\Analytics\MonthlyReports as MonthlyReports;
use \FileSystem\Injector;

/**
 * Class AnalyticsController
 * @property ProfileDAOImpl dao
 */
class AnalyticsController extends Controller
{

    /**
     * @var MonthlyReports
     */
    private $os;

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
     * @param null|string $json_input
     * @param null $action
     * Sample input = { 'command', 'subject', other fields}
     * @return mixed|void
     * @throws \Exceptions\HTTP\HTTP_OPERATION_FAILED
     */
    public function get(string $json_input, $action = NULL)
    {
        try
        {
            $options_json = json_encode($json_input);
            $option_file_dir = APPPATH."analytics\\";
            $option_file_name = "temp.json";
            $injector = new Injector($option_file_dir);
            $option_file = $injector->send_unique($option_file_name, $options_json);

            if ($options_json != false && $option_file != false)
            {
                $this->os->setScript($action, $option_file);
                $result = $this->os->Run();
                if (!$result)
                {
                    throw new \Exceptions\HTTP\HTTP_UNPROCESSABLE_ENTITY();
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
                throw new \Exceptions\HTTP\HTTP_BAD_REQUEST();
            }
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            throw new \Exceptions\HTTP\HTTP_OPERATION_FAILED();
        }
    }


    // TODO : LATER
    /**
     * @param null $input
     * @param null $config
     * Sample input = { 'info': { key, name, type }, 'data': { Input data }}*
     * @return mixed|void
     */
    public function post($input, $config = NULL)
    {
        $input = json_decode($input)['info'];
        $data = json_decode($input)['data'];
        $client = null;
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
            http_response_code(Authentication::HTTP_BAD_REQUEST);
            die("Profile already exists!");
        }
        catch (Exception $e)
        {
            http_response_code(Authentication::HTTP_INTERNAL_SERVER_ERROR);
            die($e->getMessage());
        }
    }

    /**
     * @param null $key
     * @param null $xss_clean
     * @return mixed|void
     */
    public function put($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement put() method.
    }

    /**
     * @param null $key
     * @param null $xss_clean
     * @return mixed|void
     */
    public function delete($key = NULL, $xss_clean = NULL)
    {
        // TODO: Implement delete() method.
    }
}