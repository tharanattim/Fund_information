<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_status extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('System_status_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'System';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('System/system_view.php');
				$this->load->view('Templates/Admin/footer.php');
			}else{
				/* staff*/
				$data['title'] = 'Dashboard';
				$this->load->view('Dashboard/dashboard_staff_view' ,$data);
				$this->load->view('Templates/Staff/footer.php');
			}
		}else{
			redirect('Login');
		}
	}

	public function  getSystem_status()
	{
		$result = $this->System_status_model->getSystem_status();
		echo json_encode($result);
	}

	public function getSystemStatusByID($id)
	{
		$result = $this->System_status_model->getSystemStatusByID($id);
		echo json_encode($result);
	}

	public function deleteSystemStatus($id)
	{
		$result = $this->System_status_model->deleteSystemStatus($id);
		echo json_encode($result);
	}

	public  function getIDSystemStatus(){
		$result = $this->System_status_model->getIDSystemStatus();
		echo json_encode($result);
	}

	public function saveSystemStatus()
	{
		$result = $this->System_status_model->saveSystemStatus();
		echo json_encode($result);
	}

	public function updateSystemStatus($id)
	{
		$result = $this->System_status_model->updateSystemStatus($id);
		echo json_encode($result);
	}

	public function closeDepartment()
	{
		$result = $this->System_status_model->closeDepartment();
		echo json_encode($result);
	}
}
