<?php
class Queue_status_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getStatus()
	{
		return $this->db->get('queue_status')->result();
	}

	public function getStatusByID($id)
	{
		return $this->db->get_where('queue_status', array('id' => $id))->result();
	}

	public function deleteStatus($id)
	{
		$this->db->delete('queue_status', array('id' => $id));
		return $this->db->affected_rows();
	}

	public  function getIDStatus(){
		$this->db->select_max('id');
		return $this->db->get('queue_status')->result();
	}

	public function saveStatus()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		return $this->db->insert('queue_status', $data);
	}

	public function updateStatus($id)
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->db->where('id', $id);
		$this->db->update('queue_status', $data);
		return $this->db->affected_rows();
	}
}
