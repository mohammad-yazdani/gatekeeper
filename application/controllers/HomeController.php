<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 1/27/2017
 * Time: 3:21 PM
 */
class HomeController extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */

    function __construct ()
    {
        // TODO : TEST

        parent::__construct();
        $this->load->helper('url');
    }

    public function index ()
    {
        // $this->load->view('home');
        //redirect("http://192.168.68.145:9000");
        //redirect("http://localhost:9000");
        $this->load->view('ng');
    }

    public function inProgress ()
    {
        $this->load->view('inProgress');
    }

    public function Introduction ()
    {

    }

    public function Documentation ()
    {

    }

    public function GitHub ()
    {
        redirect('https://github.com/mohammad-yazdani/gatekeeper', 'refresh');
    }

    public function Registration ()
    {

    }

    public function Login ()
    {
        $this->load->view('Login');
    }

    public function Admin ()
    {
        $this->load->view('Admin');
    }

    public function Register ()
    {
        $this->load->view('Register');
    }

    public function ClientPortal ()
    {
        // $this->load->view('ClientPortal');
        redirect("http://192.168.68.145:9000");
    }

    public function UploadUtility ()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->view('Test/FileUploadTest');
    }

    public function Apps ()
    {
        //$this->load->view("AppMenu");
        // redirect("http://localhost:9000");
        redirect("http://192.168.68.145:9000");
        //$this->load->view("app/app/redirect");
        //$this->load->view("app/app/index");
        //$this->load->view("_shared/_layout");
        //$this->load->view("_shared/_catalog");
        //$this->load->view("_shared/index.html");
    }

    public function Loading ()
    {
        $this->load->view('Loading');
    }
}