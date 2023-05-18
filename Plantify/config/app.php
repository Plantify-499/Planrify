<?php
// require_once makes an odd errors
include 'database.php';

$settings = $mysqli->query("select * from settings where id=1")->fetch_assoc();

if(count($settings)){
  $app_name = $settings['app_name'];
  $admin_email = $settings['admin_email'];
}else {
  $app_name = "Plantify ";
  $admin_email ="nawaf@admin.com";
}

$config=[
  'app_name'=>  $app_name ,
  'lang'=>'en',
  'dir'=>'ltr',
  'app_url'=>'http://127.0.0.1/Plantify/',
  'admin_email' =>  $admin_email ,
  'admin_assets' => 'http://127.0.0.1/Plantify/admin/template/assets/'
];
