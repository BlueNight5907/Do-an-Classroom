<?php
session_start();
include_once '../../vendor/autoload.php';
if(isset($_POST['remove_class'])){
    if(!empty($_POST['remove_class'])){
        if($_SESSION['role']===1 || $_SESSION['ClassRole'] === 'creator'){
            $db = new BaseModel();
            $data = $db->remove_class($_SESSION['ClassCode']);
            if($data===true){
                unset($_SESSION['ClassCode']);
                unset($_SESSION['ClassRole']);
                echo $data;
            }
            else
                echo  'Đã xảy ra lỗi';
        }
    }
}
