<?php
class Model_users extends CI_Model
{
  public function add_users($days)
  {
    //add_usersのモデルの実行時に、以下のデータを取得して、$dataと紐づける
    $data = [
      "shop_name" => $this->input->post("name"),
      "zip_code" => $this->input->post("zipcode"),
      "address" => $this->input->post("address"),
      "tel" => $this->input->post("tel"),
      "mail" => $this->input->post("mail"),
      "password" => password_hash($this->input->post("pass"), PASSWORD_DEFAULT),
      "insert_time" => $days
    ];
    //$dataをDB内のtemp_usersに挿入後に、$queryと紐づける
    $query = $this->db->insert("user", $data);
    if ($query) {
      return true;
    } else {
      return false;
    }
  }
  public function getusers()
  {
    $guest = $this->db->get('user');
    return $guest->result_array();  //結果を複数表示   
  }
}
