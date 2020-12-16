<?php
session_start();
include '../../vendor/autoload.php';
$state = array('result'=>'error');
if(isset($_POST['code']) && isset($_POST['action']) && $_SESSION['role']!== 3){
    if(!empty($_POST['code']) && !empty($_POST['action'])){
        $action = $_POST['action'];
        $ID = $_POST['code'];
        $base = new BaseModel();
        $data = $base->confirm_student_attend($ID,$action);
        if($data['code']===0){
            $state = array('result'=>'success');
        }
        else{
            $state = array('result'=>'error','reason'=>$data['error']);
        }
    }
    echo json_encode($state);
    die();
}
?>
