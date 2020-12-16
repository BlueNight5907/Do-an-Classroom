<?php
session_start();
include_once '../../vendor/autoload.php';
$state = array('result'=>'error');
if(isset($_POST['code'])){
    if(!empty($_POST['code'])){
        $username = $_SESSION['username'];
        $classID = $_POST['code'];
        $base = new BaseModel();
        $fullname = $_SESSION['fullname'];
        $data = $base->student_attend_class_by_code($username,$fullname,$classID);
        if($data['code']===0){
            $state = array('result'=>'success');
        }
        else{
            $state = array('result'=>'error','reason'=>$data['error']);
        }
    }
    echo json_encode($state);
    if($data['code']===0){
        $base->classAnounce($username,$classID);
    }
    die();
}
