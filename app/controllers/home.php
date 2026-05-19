<?php 
class home 
 {    public function index(){
    echo "Đây là trang chủ"
 }
      public function create(){
        echo "Đây là trang tạo mới"
      }
      public function login(){
        require_once '../app/views/auth/Login.php';
        }
 }
?>