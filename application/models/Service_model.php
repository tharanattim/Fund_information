<?php
class Service_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function  getService()
	{
		$this->db->select('service.*,department.dept_name');
		$this->db->from('service');
		$this->db->join('department', 'service.department = department.id');
		return $this->db->get()->result();
	}

	public function  getServiceByDept($id)
	{
		return $this->db->get_where('service', array('department' => $id))->result();
	}

	public function  getServiceByid($id)
	{
		return  $this->db->get_where('service', array('id' => $id))->result();
	}

	public function deleteService($id)
	{
		$this->db->delete('service', array('id' => $id));
		return $this->db->affected_rows();
	}

	public  function getIDservice()
	{
		$this->db->select_max('id');
		return $this->db->get('service')->result();
	}

	public function saveService()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		return $this->db->insert('service', $data);
	}

	public function updateService($id)
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$this->db->where('id', $id);
		$this->db->update('service', $data);
		return $this->db->affected_rows();
	}
}
