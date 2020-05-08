<?php
class Model_member extends CI_Model
{
    public function login()
    {
        $this->db->where("mail", $this->input->post("mail"));
        $this->db->select("name, password");
        $query = $this->db->get('member');
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function getdata(){	        
		$query = $this->db->get('member');	
		return $query->result_array();	//結果を複数表示   
    }
}