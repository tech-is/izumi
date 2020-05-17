<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Crm extends CI_Controller
{
    public function register()
    {
        $this->load->view("register");
    }
    public function signup()
    {
        $this->load->view("signup");
    }
    public function register_validation()
    {
        header("Content-type: application/json; charset=UTF-8");
        $this->load->library("form_validation");
        $config = [
            [
                "field" => "id",
                "label" => "店番",
                "rules" => 'trim|required',
                "errors" => ["required" => "idは入力必須です。"]
            ],
            [
                "field" => "name",
                "label" => "名前",
                "rules" => 'trim|required',
                "errors" => ["required" => "名前は入力必須です。"]
            ],
            [
                "field" => "zipcode",
                "label" => "郵便番号",
                "rules" => 'trim|required|regex_match[/^[0-9]+$/]',
                "errors" => [
                    "required" => "郵便番号は入力必須です。",
                    "regex_match" => "郵便番号が不正です。"
                ],
            ],
            [
                "field" => "address",
                "label" => "住所",
                "rules" => 'trim|required',
                "errors" => [
                    "required" => "カナは入力必須です。",
                    "errors" => ["required" => "名前は入力必須です。"]
                ],
            ],
            [
                "field" => "tel",
                "label" => "電話番号",
                "rules" => "trim|required|regex_match[/^[0-9]+$/]",
                "errors" => [
                    "required" => "電話番号は入力必須です。",
                    "regex_match" => "電話番号が不正です。"
                ]
            ],
            [
                "field" => "mail",
                "label" => "メールアドレス",
                "rules" => "trim|required|valid_email",
                "errors" => [
                    "required" => "メールアドレスは入力必須です。",
                    "valid_email" => "メールアドレスが不正です。"
                ]
            ]
        ];
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run()) {
            $day = date("Y-m-d");
            $this->load->model("model_guests");
            if ($this->model_guests->add_guests($day)) {
                exit(json_encode(['register_id' =>'登録完了']));
                //redirect("main/guests");
            } else {
                echo "会員登録できませんでした。";
            }
            //ユーザーを temp_users DBに追加する
        } else {
            $this->load->view('register');
        }
    }
    public function signup_validation()
    {
        header("Content-type: application/json; charset=UTF-8");
        $this->load->library("form_validation");
        $config = [
            [
                "field" => "name",
                "label" => "事業所名",
                "rules" => 'trim|required',
                "errors" => ["required" => "事業所名は入力必須です。"]
            ],
            [
                "field" => "zipcode",
                "label" => "郵便番号",
                "rules" => 'trim|required|regex_match[/^[0-9]+$/]',
                "errors" => [
                    "required" => "郵便番号は入力必須です。",
                    "regex_match" => "郵便番号が不正です。"
                ],
            ],
            [
                "field" => "address",
                "label" => "住所",
                "rules" => 'trim|required',
                "errors" => [
                    "required" => "住所は入力必須です。",
                    "errors" => ["required" => "住所は入力必須です。"]
                ],
            ],
            [
                "field" => "tel",
                "label" => "電話番号",
                "rules" => "trim|required|regex_match[/^[0-9]+$/]",
                "errors" => [
                    "required" => "電話番号は入力必須です。",
                    "regex_match" => "電話番号が不正です。"
                ]
            ],
            [
                "field" => "mail",
                "label" => "メールアドレス",
                "rules" => "trim|required|valid_email",
                "errors" => [
                    "required" => "メールアドレスは入力必須です。",
                    "valid_email" => "メールアドレスが不正です。"
                ]
            ],
            [
                "field" => "pass",
                "label" => "パスワード",
                "rules" => "trim|required",
                "errors" => ["required" => "パスワードを入力してください。",]
            ],
            [
                "field" => "chkpass",
                "label" => "パスワード確認",
                "rules" => "trim|required|matches[pass]",
                "errors" => ["required" => "もう一度パスワードを入力してください。",]
            ]
        ];
        $this->form_validation->set_rules($config);
        $days = date("Y-m-d");
        if ($this->form_validation->run()) {
            $this->load->model("model_users");
            if ($this->model_users->add_users($days)) {
                //redirect("main/index");
                exit(json_encode(['signup_id' =>'登録完了']));
            } else {
                echo "顧客登録できませんでした。";
            }
        } else {
            $this->load->view('register');
        }
    }
    public function update()
    {
        $id = $this->input->post('update_id');
        $this->load->model("model_guests");
        $guest['row_array'] =$this->model_guests->getguest($id);
        $this->load->view("update",$guest);
    }
    public function update_crm()
    {
        header("Content-type: application/json; charset=UTF-8");
        $day = date("Y-m-d");
        $this->load->model("model_guests");
        $this->model_guests->update_guest($day);
        //redirect("main/guests");
        exit(json_encode(['update_id' =>'更新完了']));
    }
    public function delete_crm()
    {
        header("Content-type: application/json; charset=UTF-8");
        $day = date("Y-m-d");
        $this->load->model("model_guests");
        $this->model_guests->delete_guest($day);
        exit(json_encode(['delete_id' =>'削除完了']));
    }
}
