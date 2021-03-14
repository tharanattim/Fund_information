<?php
class System_status_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getSystem_status()
	{
		return $this->db->get('system_status')->result();
	}

	public function getSystemStatusByID($id)
	{
		return $this->db->get_where('system_status', array('id' => $id))->result();
	}

	public function deleteSystemStatus($id)
	{
		$this->db->delete('system_status', array('id' => $id));
		return $this->db->affected_rows();
	}

	public  function getIDSystemStatus()
	{
		$this->db->select_max('id');
		return $this->db->get('system_status')->result();
	}

	public function saveSystemStatus()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		return $this->db->insert('system_status', $data);
	}

	public function updateSystemStatus($id)
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->db->where('id', $id);
		$this->db->update('system_status', $data);
		return $this->db->affected_rows();
	}

	public function closeDepartment()
	{
		$data = array('status' => '02');
		$this->db->update('department', $data);
		return $this->db->affected_rows();
	}
}
