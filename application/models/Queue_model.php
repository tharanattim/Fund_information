<?php
class Queue_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getQueueByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, queue.department, queue.service, queue.service_time, service.service_name, service.time, queue.status, queue.time_stamp, department.pause_time, department.status as dept_status
			FROM queue,service,department
			WHERE queue.service = service.id
			AND queue.department  = department.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
		";
		return $this->db->query($sql)->result();
	}

	public function getAllQueueByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, user_type.type_name, queue.phone_number, service.service_name, service.time, queue.status, queue_status.status as status_name, queue.waiting_time
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
			AND queue.id IN (
			SELECT id 
			FROM queue
			WHERE queue.status = '01' )
		";
		return $this->db->query($sql)->result();
	}

	public function getCountAllQueueByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, user_type.type_name, queue.phone_number, service.service_name, service.time, queue.status, queue_status.status as status_name, queue.waiting_time
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
		";
		return $this->db->query($sql)->num_rows();
	}

	public function getCountSuccessQueueByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, user_type.type_name, queue.phone_number, service.service_name, service.time, queue.status, queue_status.status as status_name, queue.waiting_time
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
			AND queue.id IN (
			SELECT id 
			FROM queue
			WHERE queue.status = '03' 
			OR queue.status = '04'
			OR queue.status = '05')
		";
		return $this->db->query($sql)->num_rows();
	}

	public function getCountQueueByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
			AND queue.id IN (
			SELECT id 
			FROM queue
			WHERE queue.status = '01' )
		";
		return $this->db->query($sql)->num_rows();
	}

	public function getQueueByPhoneNumberAndDate($phone,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, queue.department, queue.waiting_time, department.dept_name, service.service_name, service.time, queue.status
			FROM queue,service,department
			WHERE queue.service = service.id
			AND queue.department = department.id
			AND queue.phone_number = '$phone'
			AND queue.time_stamp LIKE '$date%'
			ORDER BY queue.id ASC
		";
		return $this->db->query($sql)->result();
	}

	public function postBookingQueue()
	{
		$this->db->trans_start();
		date_default_timezone_set('Asia/Bangkok');
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$max_queue = $this->getMaxQueueByByDeptAndDate($data['department'], date('Y-m-d'));
		if (empty($max_queue)) {
			$now = date('Y-m-d H:i:s');
			$data['time_stamp'] = $now;
			$this->db->insert('queue', $data);
			$id = $this->db->insert_id();
		} else {
			$waiting_time = 0;
			$all_queue = $this->getQueueByDeptAndDate($data['department'], date('Y-m-d'));
			if ($all_queue[0]->dept_status == '03') {
				$waiting_time += $all_queue[0]->pause_time;
			}
			foreach ($all_queue as $value) {
				if ($value->status == '01' || $value->status == '02'){
					$waiting_time += $value->service_time;
				}
			}
			$data['waiting_time'] = $waiting_time;
			$dept = substr($max_queue[0]->queue_no,0,1);
			$max_queue = substr($max_queue[0]->queue_no,1,3);
			$max_queue += 1;
			$max_queue = str_pad($max_queue, 3, '0', STR_PAD_LEFT);
			$queue_no = $dept.$max_queue;
			$data['queue_no'] = $queue_no;
			$now = date('Y-m-d H:i:s');
			$data['time_stamp'] = $now;
			$this->db->insert('queue', $data);
			$id = $this->db->insert_id();
		}
		$this->db->trans_complete();
		$result = $this->updateServiceTime($id);
		return $result;
	}

	public function updateServiceTime($id)
	{
		$sql = "
			SELECT service.time
			FROM queue,service
			WHERE queue.service = service.id
			AND queue.id  = $id
		";
		$result =  $this->db->query($sql)->result_array();
		$time = $result[0]['time'];
		$sql2 = "
		   	UPDATE queue
			SET service_time = $time
			WHERE id = $id
		";
		$this->db->query($sql2);
		return $this->db->affected_rows();
	}

	public function updateBookingQueue($id)
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->db->where('id', $id);
		$this->db->update('queue', $data);
		return $this->db->affected_rows();
	}

	public function getNextQueueByByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, user_type.type_name, queue.phone_number, service.service_name, service.time, queue.status, queue_status.status as status_name, queue.waiting_time
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
			AND queue.id IN (
			SELECT id 
			FROM queue
			WHERE queue.status = '01' )
			ORDER BY queue.id ASC
			LIMIT 1
		";
		return $this->db->query($sql)->result();
	}

	public function getCurrentQueueByByDeptAndDate($dept,$date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, user_type.type_name, queue.phone_number, service.service_name, service.time, queue.status, queue_status.status as status_name, queue.waiting_time
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
			AND queue.id IN (
			SELECT id 
			FROM queue
			WHERE queue.status = '02' )
			ORDER BY queue.id ASC
			LIMIT 1
		";
		return $this->db->query($sql)->result();
	}

	public function getQueueLogsByDate($date_from, $date_to)
	{
		$sql = "
			SELECT queue.queue_no, queue.department, department.dept_name, user_type.type_name, service.service_name, queue.phone_number, queue.time_stamp, queue.process_time, queue.staff_name, queue_status.status
			FROM queue 
			INNER JOIN department ON queue.department = department.id
			INNER JOIN queue_status ON queue.status = queue_status.id
			INNER JOIN service on queue.service = service.id
			INNER JOIN user_type on queue.user_type = user_type.id
			AND (queue.time_stamp BETWEEN '$date_from' AND '$date_to') 
			OR queue.time_stamp LIKE '$date_to%'
			GROUP BY queue.id
		";
		return $this->db->query($sql)->result();
	}

	public function getMaxQueueByByDeptAndDate($dept, $date)
	{
		$sql = "
			SELECT queue.id, queue.queue_no, user_type.type_name, queue.phone_number, service.service_name, service.time, queue.status, queue_status.status as status_name, queue.waiting_time
			FROM queue,service,user_type,queue_status
			WHERE queue.service = service.id
			AND queue.user_type  = user_type.id 
			AND queue.status  = queue_status.id 
			AND queue.department = '$dept' 
			AND queue.time_stamp LIKE '$date%'
			ORDER BY queue.id DESC
			LIMIT 1
		";
		return $this->db->query($sql)->result();
	}
}
