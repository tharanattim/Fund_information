<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Service_model');
		$this->load->model('Department_model');
	}

	public function index()
	{
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Service';
				$this->load->view('Templates/Admin/header.php', $data);
				$this->load->view('Service/service_view.php');
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

	public function getService()
	{
		$result = $this->Service_model->getService();
		echo json_encode($result);
	}

	public function getServiceByDept($id)
	{
		$result = $this->Service_model->getDepartmentByid($id);
		echo json_encode($result);
	}

	public function  getServiceByid($id){
		$result = $this->Service_model->getServiceByid($id);
		echo json_encode($result);
	}

	public function deleteService($id)
	{
		$result = $this->Service_model->deleteService($id);
		echo json_encode($result);
	}

	public  function getIDservice()
	{
		$result = $this->Service_model->getIDservice();
		echo json_encode($result);
	}

	public function saveService()
	{
		$result = $this->Service_model->saveService();
		echo json_encode($result);
	}

	public function  getDepartment()
	{
		$result = $this->Department_model->getDepartment();
		echo json_encode($result);
	}

	public function  updateService($id)
	{
		$result = $this->Service_model->updateService($id);
		echo json_encode($result);
	}
}

