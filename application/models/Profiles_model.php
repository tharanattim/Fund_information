<?php
class Profiles_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function  uploadProfiles()
	{
		// Set preference
		$config['upload_path'] = 'assets/images/profiles/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif'; // ไฟล์ที่อนุญาติ
		$config['max_size']    = '1024';	// max_size in kb
		$config['remove_spaces'] = TRUE;	//ลบช่องว่าง
		$config['encrypt_name'] = TRUE;	//ชื่อเข้ารหัส
		$config['file_name'] = $_FILES['file']['name']; //$_FILES คือไฟล์ที่ POST มาจากหน้าบ้าน

		//Load upload library
		$this->load->library('upload',$config);

		// File upload
		if($this->upload->do_upload('file')){
			// Get data about the file
			$uploadData = $this->upload->data();
			return $uploadData['file_name'];
		}else {
			return false;
		}
	}

	public function delProfiles()
	{
		$files = directory_map('assets/images/profiles/');	//directory_map คือ All file ใน directory profiles
		$this->db->select('profile');	//select จากคอลัมน์ profile
		foreach ($this->db->get('officer')->result_array() as $row) // get profile จากตาราง officer มาในรูปแบบ array ที่ตัวแปร $row
		{
			$files_use[] = $row['profile']; //$row เก็บไว้ใน $files_use[] ในลักษณะของ array
		}
		$result = array_diff($files,$files_use); //array_diff คือ หาผลต่างของ array
		foreach ($result as $filename)
		{
			unlink('assets/images/profiles/'.$filename); // ลบ $filename ออกจาก directory profiles
		}
	}
}
