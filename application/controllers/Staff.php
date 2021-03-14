<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Officer_model');
		$this->load->model('Department_model');
		$this->load->model('Profiles_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Staff';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Staff/staff_view.php');
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

	public function  getStaff(){
		$result = $this->Officer_model->getStaff();
		echo json_encode($result);
	}

	public function  getStaffByid($id){
		$result = $this->Officer_model->getStaffByid($id);
		echo json_encode($result);
	}

	public function  getStaffNoneAdmin(){
		$result = $this->Officer_model->getStaffNoneAdmin();
		echo json_encode($result);
	}

	public function deleteStaff($id)
	{
		$result = $this->Officer_model->deleteStaff($id);
		echo json_encode($result);
	}

	public  function getIDStaff(){
		$result = $this->Officer_model->getIDStaff();
		echo json_encode($result);
	}

	public function saveStaff()
	{
		$result = $this->Officer_model->saveStaff();
		echo json_encode($result);
	}

	public function genPassWord($password)
	{
		$result = $this->Officer_model->genPassWord($password);
		echo json_encode($result);
	}

	public function dePassWord($password)
	{
		$result = $this->Officer_model->dePassWord($password);
		echo json_encode($result);
	}

	public function updateStaff($id)
	{
		$result = $this->Officer_model->updateStaff($id);
		echo json_encode($result);
	}

	public function  getDepartment()
	{
		$result = $this->Department_model->getDepartment();
		echo json_encode($result);
	}

	public function  uploadProfiles()
	{
		$result = $this->Profiles_model->uploadProfiles();
		echo json_encode($result);
	}

	public function  delProfiles()
	{
		$result = $this->Profiles_model->delProfiles();
		echo json_encode($result);
	}
}

