<?php
session_start();
include '../../vendor/autoload.php';
$state = array('result'=>'error');
if(isset($_POST['username']) && isset($_POST['role']) && $_SESSION['role'] === 1){
    if(!empty($_POST['username']) && !empty($_POST['role'])){
        $user = $_POST['username'];
        $role = $_POST['role'];
        $base = new BaseModel();
        $data = $base->change_permission($user,$role);
        if($data['code']===0){
            $state = array('result'=>'success');
        }
        else{
            $state = array('result'=>'error','reason'=>$data['error']);
        }
    }
    echo json_encode($state);
    if($data['code']===0)
        $base->permissionAnounce($user);
    die();
}
?>
