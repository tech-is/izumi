<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

defined('BASEPATH') or exit('No direct script access allowed');
class Main extends CI_Controller
{
    /*
     * index
     * @param none
     * @return login()
     */
    public function index()
    {
        $this->login();
    }
    public function login()
    {
        if ($this->session->userdata("is_logged_in")) {
            $this->load->view("members");
        } else {
            $this->load->view('login');
        }
        $this->session->sess_destroy();
    }
    /*
     * Undocumented function
     * @param $_SESSION["is_logged_in"]
     * @return include login.php
     */
    // public function members()
    // {
    //     if($this->session->userdata("is_logged_in")){
    //         //
    //     } else {
    //         //
    //     }
    // }
    public function signup()
    {
        $this->load->view("signup");
    }
    public function register()
    {
        $this->load->view("register");
    }
    public function login_validation()
    {
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
            $this->load->model("model_member");
            $rows = $this->model_member->login();
            if (password_verify($this->input->post("pass"), $rows[0]["password"]) == true) {
                $data = [
                    "name" => $rows[0]["name"],
                    "mail" => $this->input->post("mail"),
                    "is_logged_in" => 1
                ];
                $this->session->set_userdata($data);
                redirect("main/members");
            } else {
                $data["error"] = "メールアドレスかパスワードが不正です";
                $this->load->view("login", $data);
            }
        } else {
            $this->load->view("login");
        }
    }
    public function logout()
    {
        $this->session->sess_destroy();        //セッションデータの削除
        redirect("main/login");        //ログインページにリダイレクトする
    }
    public function signup_validation()
    {
        $this->load->library("form_validation");
        /*"field" => "",
                    "label" => "",
                    "rules" => "" */
        $config = [
            [
                "field" => "name",
                "label" => "名前",
                "rules" => 'trim|required',
                "errors" => ["required" => "名前は入力必須です。"]
            ],
            [
                "field" => "kana",
                "label" => "カナ",
                "rules" => 'trim|required|regex_match[/^[ァ-ヾ]+$/u]',
                "errors" => [
                    "required" => "カナは入力必須です。",
                    "regex_match" => "全角カタカナで入力してください。"
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
            //ランダムキーを生成する
            $key = md5(uniqid());
            // PHPMailerオブジェクト生成
            $mail = new PHPMailer(true);
            // 送信設定
            $mail->SMTPDebug = 0; // 0：デバッグOFF 1：デバッグON
            $mail->isSMTP();
            $mail->SMTPAuth = true; // SMTP認証を利用するか
            $mail->Host = 'smtp.gmail.com';
            $mail->Username = 'hogehoge@gmail.com';
            $mail->Password = 'hoge';
            $mail->SMTPSecure = 'tls'; // sslの場合はssl
            $mail->Port = 587; // sslの場合は465(普通は)
            // ここからがポイント
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    // 'allow_self_signed' => true
                )
            );
            // ここまで

            // 送信内容設定
            $mail->CharSet = 'utf-8';
            $mail->setFrom('noreply@gmail.com', mb_encode_mimeheader('送信元'));
            $mail->addAddress($this->input->post("mail"));
            $mail->Subject = "仮会員登録が完了しました。";
            $mail->Body = "<p>会員登録ありがとうございます。</p>";
            $mail->Body .=  "<p><a href='" . base_url() . "index.php/main/check_signup_user/$key'>こちらをクリックして、会員登録を完了してください。</a></p>";           
            
            //ユーザーに確認メールを送信する
            $this->load->model("model_users");
            if ($this->model_users->add_temp_users($key)) {
                if ($mail->send()) {
                    echo "仮登録完了のお知らせメールを送信しました。";
                } else {
                    echo "メールを送信できませんでした。";
                }
            } else {
                echo "会員登録できませんでした。";
            }
            //ユーザーを temp_users DBに追加する
        } else {
            $this->load->view('signup');
        }
    }

    public function check_signup_user($key)
    {
        //add_temp_usersモデルが書かれている、model_uses.phpをロードする
        $this->load->model("model_users");
        if ($this->model_users->is_valid_key($key)) {    //キーが正しい場合は、以下を実行
            // echo "valid key";
            $data["key"] = $key;
            $this->load->view("register", $data);
        } else {
            echo "不正なキーが使われています。";
        }
    }
    public function register_password()
    {
        $key = $this->input->post("key");
        $this->load->model("model_users");
        if ($this->model_users->is_valid_key($key)) {
            $this->load->library("form_validation");
            $config = [
                [
                    "field" => "pass",
                    "label" => "パスワード",
                    "rules" => "trim|required",
                    "errors" => ["required" => "パスワードは入力必須です。"]
                ],
                [
                    "field" => "chkpass",
                    "label" => "パスワード確認",
                    "rules" => "trim|required",
                    "errors" => ["required" => "もう一度パスワードを入力してください。",]
                ]
            ];
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run()) {
                $this->model_users->register_user();
                echo "本登録が完了しました！";
            } else {
                $data["key"] = $key;
                $this->load->view("register", $data);
            }
        } else {
            echo "不正なキーが使われています";
        }
    }
    public function members()
    {
        $this->load->model("model_member");
        $data['result_array'] = $this->model_member->getdata();
        $this->load->view("members", $data);
    }
}
