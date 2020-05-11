<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//http://flame.com/index.php/user/profile
class User extends CI_Controller 
{
	public function profile()
    {
      echo "<h1>welcome ci!</h1>";
    }
  public function detail()
    {
        $date=[
          "name"=>"和泉",
          "pref"=>"愛媛県"
        ];
      $this->load->view("tutorial/user_detail",$date);
    }
  public function url()
    {
      $this->load->helper("url");
      echo auto_link("googleのurlは、https://google.comです");
      echo "<br>";
      echo site_url();
    }
  public function agent()
    {
      $this->load->library("user_agent");
      echo $this->agent->agent_string();
      echo "<br>";
      echo $this->agent->browser();
      echo "<br>";
      echo $this->agent->platform();
    }
}
