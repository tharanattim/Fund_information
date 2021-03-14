<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class Queue extends CI_Controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		parent::__construct();
		$this->load->model('Queue_model');
		$this->load->model('Department_model');
	}

	public function queueDeptRegis(){
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Dashboard';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Dashboard/dashboard_admin_view');
				$this->load->view('Templates/Admin/footer.php');
			}else{
				/* staff*/
				$data['title'] = 'Queue';
				$this->load->view('Queue/queue_dept_regis_view.php',$data);
				$this->load->view('Templates/Staff/footer.php');
			}
		}else{
			redirect('Login');
		}
	}

	public function queueDeptCheck(){
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Dashboard';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Dashboard/dashboard_admin_view');
				$this->load->view('Templates/Admin/footer.php');
			}else{
				/* staff*/
				$data['title'] = 'Queue';
				$this->load->view('Queue/queue_dept_check_view.php',$data);
				$this->load->view('Templates/Staff/footer.php');
			}
		}else{
			redirect('Login');
		}
	}

	public function queueDeptSuccess(){
		if ($this->session->has_userdata('user')){
			if ($_SESSION['user']->rloe == 'admin'){
				/* admin*/
				$data['title'] = 'Dashboard';
				$this->load->view('Templates/Admin/header.php',$data);
				$this->load->view('Dashboard/dashboard_admin_view');
				$this->load->view('Templates/Admin/footer.php');
			}else{
				/* staff*/
				$data['title'] = 'Queue';
				$this->load->view('Queue/queue_dept_success_view.php',$data);
				$this->load->view('Templates/Staff/footer.php');
			}
		}else{
			redirect('Login');
		}
	}

	public function dashboardUser(){
		$data['title'] = 'Dashboard User';
		$this->load->view('Dashboard/dashboard_user_view.php',$data);
	}

	public function getAllQueueByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getAllQueueByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function getCountAllQueueByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getCountAllQueueByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function getCountSuccessQueueByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getCountSuccessQueueByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function getCountQueueByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getCountQueueByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function getNextQueueByByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getNextQueueByByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function getCurrentQueueByByDeptAndDate($dept,$date)
	{
		$result = $this->Queue_model->getCurrentQueueByByDeptAndDate($dept,$date);
		echo json_encode($result);
	}

	public function updateBookingQueue($id)
	{
		$result = $this->Queue_model->updateBookingQueue($id);
		echo json_encode($result);
	}

	public function updatePauseTime($id)
	{
		$result = $this->Department_model->updateDepartment($id);
		echo json_encode($result);
	}

	public function  getPauseTime($id){
		$result = $this->Department_model->getDepartmentByid($id);
		echo json_encode($result);
	}

	public function getQueueLogsByDate($date_from, $date_to)
	{
		$result = $this->Queue_model->getQueueLogsByDate($date_from, $date_to);
		echo json_encode($result);
	}

	public function downloadQueueLogs($date_from, $date_to)
	{
		$result = $this->Queue_model->getQueueLogsByDate($date_from, $date_to);
		$row = 3;
		$spreadsheet = new Spreadsheet();
		$borderStyleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => Border::BORDER_THIN
				]
			]
		];
		$spreadsheet->getDefaultStyle()->getFont()->setName('TH SarabunPSK');
		$spreadsheet->getDefaultStyle()->getFont()->setSize(16);
		$spreadsheet->getActiveSheet()->mergeCells('$A1:$I1');
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'ประวัติบัตรคิวอิเล็กทรอนิกส์');
		$sheet->setCellValue('A2', 'คิว');
		$sheet->setCellValue('B2', 'แผนกงาน');
		$sheet->setCellValue('C2', 'ประเภทผู้ใช้งาน');
		$sheet->setCellValue('D2', 'รายการตืดต่อ');
		$sheet->setCellValue('E2', 'หมายเลขโทรศัพท์มือถือ');
		$sheet->setCellValue('F2', 'วันที่เข้าใช้บริการ');
		$sheet->setCellValue('G2', 'สถานะ');
		$sheet->setCellValue('H2', 'เวลาที่ใช้งาน (นาที)');
		$sheet->setCellValue('I2', 'เจ้าหน้าที่ที่ให้บริการ');
		foreach ($result as $key => $value){
			$sheet->getStyle('A'.$row.':I'.$row)->applyFromArray($borderStyleArray);
			$sheet->getStyle('A'.$row)->getAlignment()->setHorizontal('center');
			$sheet->setCellValue('A'.$row, $value->queue_no);
			$sheet->setCellValue('B'.$row, $value->dept_name);
			$sheet->setCellValue('C'.$row, $value->type_name);
			$sheet->setCellValue('D'.$row, $value->service_name);
			$sheet->setCellValue('E'.$row, $value->phone_number);
			$sheet->setCellValue('F'.$row, $value->time_stamp);
			$sheet->setCellValue('G'.$row, $value->status);
			$sheet->setCellValue('H'.$row, $value->process_time);
			$sheet->setCellValue('I'.$row, $value->staff_name);
			$row += 1;
		}
		$sheet->getStyle('A1:I1')->applyFromArray($borderStyleArray);
		$sheet->getStyle('A2:I2')->applyFromArray($borderStyleArray);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center');
		$sheet->getStyle('A1')->getFont()->setSize(20)->setBold(true);
		$sheet->getStyle('A2:I2')->getFont()->setSize(18)->setBold(true);
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(40);
		$sheet->getColumnDimension('C')->setWidth(20);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(25);
		$sheet->getColumnDimension('F')->setWidth(25);
		$sheet->getColumnDimension('G')->setWidth(20);
		$sheet->getColumnDimension('H')->setWidth(18);
		$sheet->getColumnDimension('I')->setWidth(25);

		$writer = new Xlsx($spreadsheet);
		$filename = 'queues_logs_report';

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
