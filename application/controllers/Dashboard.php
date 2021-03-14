<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Dashboard';
		if ($this->session->has_userdata('user')){ //has_userdata ตรวจสอบว่ามี session user อยู่ไหม
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Dashboard/dashboard_admin_view');
				$this->load->view('Templates/Admin/footer.php');
			}else{
				/* staff*/
				$this->load->view('Dashboard/dashboard_staff_view' ,$data);
				$this->load->view('Templates/Staff/footer.php');
			}
		}else{
			redirect('Login');
		}
	}
}


