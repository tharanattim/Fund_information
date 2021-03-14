<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Department_model');
		$this->load->model('System_status_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Department';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Department/dept_admin_view.php');
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

	public function  getDepartment(){
		$result = $this->Department_model->getDepartment();
		echo json_encode($result);
	}

	public function  getDepartmentByid($id){
		$result = $this->Department_model->getDepartmentByid($id);
		echo json_encode($result);
	}

	public function  getStaustByid($id){
		$result = $this->Department_model->getStaustByid($id);
		echo json_encode($result);
	}

	public function deleteDept($id)
	{
		$result = $this->Department_model->deleteDept($id);
		echo json_encode($result);
	}

	public  function getIDDepartment(){
		$result = $this->Department_model->getIDDepartment();
		echo json_encode($result);
	}

	public function saveDepartment()
	{
		$result = $this->Department_model->saveDepartment();
		echo json_encode($result);
	}

	public function getSystem_status()
	{
		$result = $this->System_status_model->getSystem_status();
		echo json_encode($result);
	}

	public function updateDepartment($id)
	{
		$result = $this->Department_model->updateDepartment($id);
		echo json_encode($result);
	}
}
