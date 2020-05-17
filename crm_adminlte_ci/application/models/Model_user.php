<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Model_user extends CI_Model
{
  public function login()
  {
    $this->db->where("mail", $this->input->post("mail"));
    $query = $this->db->get('user');
    if ($query->num_rows() == 1) {
      return $query->result_array();
    } else {
      return false;
    }
  }
}
