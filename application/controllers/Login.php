<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Officer_model');
	}

	public function index()
	{
		$data['title'] = 'Login';
		$this->load->view('Templates/Login/header.php',$data);
		$this->load->view('Login/login_view.php');
		$this->load->view('Templates/Login/footer.php');
	}

	public function checkLogin(){
		$result = $this->Officer_model->checkLogin();
		echo json_encode($result);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('Login');
	}
}
