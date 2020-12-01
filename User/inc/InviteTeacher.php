<?php
session_start();
include_once '../../vendor/autoload.php';
$result =array('result' => 'error');
if(isset($_POST['Teacher_email'])){
    if(!empty($_POST['Teacher_email'])){
        $base = new BaseModel();
        $teacher_email = $_POST['Teacher_email'];
        $data = $base->invite_teacher($_SESSION['fullname'],$teacher_email,$_SESSION['ClassCode']);
        if($data===true){
            $result =array('result' => 'success');
        }
    }
}
echo json_encode($result);
die();