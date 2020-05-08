<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["protocol"] = "smtp";
$config["smtp_host"] = "smtp.gmail.com";
$config["smtp_port"] = 587;
$config["smtp_user"] = "hogehoge@gmail.com";
$config["smtp_pass"] = "hoge";
$config['smtp_timeout'] = 5; // SMTP接続のタイムアウト(秒)
$config["mailtype"] = "html";