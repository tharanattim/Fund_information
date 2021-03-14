<?php
class Department_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function  getDepartment()
	{
		$this->db->select('department.*,system_status.status');
		$this->db->from('department');
		$this->db->join('system_status', 'department.status = system_status.id');
		return $this->db->get()->result();
	}

	public function  getDepartmentByid($id){
		return  $this->db->get_where('department', array('id' => $id))->result();
	}

	public function  getStaustByid($id){
		$this->db->select('status');
		return  $this->db->get_where('department', array('id' => $id))->result();
	}

	public function deleteDept($id){
		$this->db->delete('department', array('id' => $id));
		return $this->db->affected_rows();
	}

	public  function getIDDepartment(){
		$this->db->select_max('id');
		return $this->db->get('department')->result();
	}

	public function saveDepartment()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		return $this->db->insert('department', $data);
	}

	public function updateDepartment($id)
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->db->where('id', $id);
		$this->db->update('department', $data);
		return $this->db->affected_rows();
	}
}
