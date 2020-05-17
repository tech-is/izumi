<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Main extends CI_Controller
{
    public function index()
    {
        $this->login();
    }
    public function login()
    {
        if ($this->session->userdata("is_logged_in")) {
            $this->load->view("crm_view");
        } else {
            $this->load->view('login');
        }
        $this->session->sess_destroy();
    }
    public function logout(){
        $this->session->sess_destroy();		//セッションデータの削除
        redirect ("main/login");		//ログインページにリダイレクトする
    }
    public function login_validation()
    {
        header("Content-type: application/json; charset=UTF-8");
        $this->load->library("form_validation");
        $config = [
            [
                "field" => "mail",
                "label" => "メールアドレス",
                "rules" => "trim|required",
                "errors" => ["required" => "メールアドレスは入力必須です。"]
            ],
            [
                "field" => "pass",
                "label" => "パスワード",
                "rules" => "trim|required",
                "errors" => ["required" => "パスワードを入力してください。",]
            ]
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $this->load->model("model_user");
            $rows = $this->model_user->login();
            if (password_verify($this->input->post("pass"), $rows[0]["password"]) == true) {
                $data = [
                    "id" => $rows[0]["user_id"],
                    "name" => $rows[0]["shop_name"],
                    "zipcode" => $rows[0]["zip_code"],
                    "address" => $rows[0]["address"],
                    "tel" => $rows[0]["tel"],
                    "mail" => $this->input->post("mail"),
                    "is_logged_in" => 1
                ];
                $this->session->set_userdata($data);
                exit(json_encode($data));
            } else {
                $data["error"] = "メールアドレスかパスワードが不正です";
                $this->load->view("login", $data);
            }
        } else {
            $this->load->view("login");
        }
    }
    public function guests()
    {
        $this->load->model("model_guests");	
        $guest['guest_array'] = $this->model_guests->getguests();
        $this->load->view("crm_view", $guest);
    }
    public function users()
    {
        $this->load->model("model_users");	
        $user['user_array'] = $this->model_users->getusers();
        $this->load->view("crm_view", $user);
    }
}
