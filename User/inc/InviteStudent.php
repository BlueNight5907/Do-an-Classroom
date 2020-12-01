<?php
session_start();
include_once '../../vendor/autoload.php';
$result =array('result' => 'error');
if(isset($_POST['Student_email'])){
    if(!empty($_POST['Student_email'])){
        $base = new BaseModel();
        $student_email = $_POST['Student_email'];
        $data = $base->invite_student($_SESSION['fullname'],$student_email,$_SESSION['ClassCode']);
        if($data===true){
            $result =array('result' => 'success');
        }
    }
}
echo json_encode($result);
die();
