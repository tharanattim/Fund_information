<?php
class User_type_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function  getUserType(){
		return $this->db->get('user_type')->result();
	}
}
