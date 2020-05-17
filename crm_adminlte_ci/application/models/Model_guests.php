<?php
class Model_guests extends CI_Model
{
  public function add_guests($day)
  {
    //add_guestsのモデルの実行時に、以下のデータを取得して、$dataと紐づける
    $data = [
      "shop_id" => $this->input->post("id"),
      "user_name" => $this->input->post("name"),
      "zipcode" => $this->input->post("zipcode"),
      "address" => $this->input->post("address"),
      "tel" => $this->input->post("tel"),
      "mail" => $this->input->post("mail"),
      "flag" => 0 ,
      "insert_date" => $day
    ];

    $query = $this->db->insert("guest", $data);
    if ($query) {
      return true;
    } else {
      return false;
    }
  }
  public function getguests()
  {
    $guest = $this->db->get('guest');
    return $guest->result_array();  //結果を複数表示   
  }
  public function getguest($id)
  {
    $this->db->where('guest_id', $id);
    $guest = $this->db->get('guest');
    return $guest->row_array();  //結果を表示   
  }
  public function update_guest($day)
  {
    $date=[
      "user_name" => $this->input->post("name"),
      "zipcode" => $this->input->post("zipcode"),
      "address" => $this->input->post("address"),
      "tel" => $this->input->post("tel"),
      "mail" => $this->input->post("mail"),
      "update_date" => $day     
    ];
    return $this->db->where('guest_id', $this->input->post("id"))
      ->update('guest',$date);
  }
  public function delete_guest($day)
  {
    $date=[
      "flag" => "1",
      "update_date" => $day     
    ];
    return $this->db->where('guest_id', $this->input->post("delete_id"))
      ->update('guest',$date);
  }
}
