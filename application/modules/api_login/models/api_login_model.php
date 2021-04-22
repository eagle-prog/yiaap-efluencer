<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_login_model extends BaseModel {

    function __construct() {
        $this->tableName = 'user';
		$this->column_name = 'username';
    }

	public function checkUser($username){
		$this->db->select($this->column_name);
		$this->db->from($this->tableName);
        $this->db->where('username', $username);
        $query = $this->db->get();
        $check = $query->num_rows();
		
		return $check;
	}

}
