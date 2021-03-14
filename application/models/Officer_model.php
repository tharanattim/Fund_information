<?php
class Officer_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
	}

	public function getStaff()
	{
		return $this->db->get('officer')->result();
	}

	public function getStaffByid($id)
	{
		return $this->db->get_where('officer', array('id' => $id))->result();
	}

	public function getStaffNoneAdmin()
	{
		$this->db->select('officer.*,department.dept_name');
		$this->db->from('officer');
		$this->db->join('department', 'officer.department = department.id');
		$this->db->where('officer.rloe', 'staff');
		return $this->db->get()->result();
	}

	public function deleteStaff($id)
	{
		$this->db->delete('officer', array('id' => $id));
		return $this->db->affected_rows();
	}

	public function getIDStaff()
	{
		$this->db->select_max('id');
		return $this->db->get('officer')->result();
	}

	public function saveStaff()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if ($this->checkDupUsername($data['username'])->num_rows() > 0) {
			return false;
		} else {
			$data['password'] = $this->encrypt->encode($data['password']);
			return $this->db->insert('officer', $data);
		}
	}

	public function updateStaff($id)
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		if (($this->checkDupUsername($data['username'])->num_rows() > 0) && ($this->checkDupUsername($data['username'])->result()[0]->id != $id)) {
			return false;
		} else {
			$data['password'] = $this->encrypt->encode($data['password']);
			$this->db->where('id', $id);
			$this->db->update('officer', $data);
			return $this->db->affected_rows();
		}
	}

	public function checkDupUsername($username)
	{
		return $this->db->get_where('officer', array('username' => $username));
	}

	public function checkLogin()
	{
		$data = json_decode(trim(file_get_contents('php://input')), true);
		$username = $this->db->get_where('officer', array('username' => $data['username']));
		if ($username->num_rows() > 0) {
			$user = $username->result();
			$password = $this->encrypt->decode($user[0]->password);    //decode การถอดรหัส
			if ($data['password'] == $password) {
				unset($user[0]->username);    //unset การลบออฟเจ็ค ลบ username ออกจาก session จะไม่เก็บไว้ใน session
				unset($user[0]->password);
				$this->session->set_userdata('user', $user[0]);    //set_userdata กำหนด session user
				return true;
			} else {
				return 'password not equal';
			}
		} else {
			return 'user not found';
		}
	}

	public function genPassWord($password)
	{
		return $this->encrypt->encode($password);
	}

	public function dePassWord($password)
	{
		return $this->encrypt->decode('BjYCZgUyWGE=');
	}
}
