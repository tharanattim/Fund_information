<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Queue_status_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Status';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Status/status_view.php');
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

	public function getStatus()
	{
		$result = $this->Queue_status_model->getStatus();
		echo json_encode($result);
	}

	public function getStatusByID($id)
	{
		$result = $this->Queue_status_model->getStatusByID($id);
		echo json_encode($result);
	}

	public function deleteStatus($id)
	{
		$result = $this->Queue_status_model->deleteStatus($id);
		echo json_encode($result);
	}

	public  function getIDStatus(){
		$result = $this->Queue_status_model->getIDStatus();
		echo json_encode($result);
	}

	public function saveStatus()
	{
		$result = $this->Queue_status_model->saveStatus();
		echo json_encode($result);
	}

	public function updateStatus($id)
	{
		$result = $this->Queue_status_model->updateStatus($id);
		echo json_encode($result);
	}
}
