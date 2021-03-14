<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('User_type_model');
		$this->load->model('Department_model');
		$this->load->model('Service_model');
		$this->load->model('Queue_model');
	}

	public function index()
	{
		$data['title'] = 'Booking Queue';
		$this->load->view('Templates/User/header.php',$data);
		$this->load->view('Booking/booking_view');
		$this->load->view('Templates/User/footer');
	}

	public  function getUserType(){
		$result = $this->User_type_model->getUserType();
		echo json_encode($result);
	}

	public function  getDepartment(){
		$result = $this->Department_model->getDepartment();
		echo json_encode($result);
	}

	public function getServiceByDept($id){
		$result = $this->Service_model->getServiceByDept($id);
		echo json_encode($result);
	}

	public function  getService(){
		$result = $this->Service_model->getService();
		echo json_encode($result);
	}

	public function getQueueByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getQueueByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function getQueueByPhoneNumberAndDate($phone,$date)
	{
		$result = $this->Queue_model->getQueueByPhoneNumberAndDate($phone,$date);
		echo json_encode($result);
	}

	public function postBookingQueue()
	{
		$data=$this->Queue_model->postBookingQueue();
		echo json_encode($data);
	}

	public function updateBookingQueue($id)
	{
		$data=$this->Queue_model->updateBookingQueue($id);
		echo json_encode($data);
	}
}
