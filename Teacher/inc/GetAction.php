<?php
    session_start();
    $Action= array("action"=>'Lỗi');
    if(isset($_SESSION['Action'])){
        $Action['action'] = $_SESSION['Action'];
    }
    echo json_encode($Action);

