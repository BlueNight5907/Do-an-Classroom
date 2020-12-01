<?php
    session_start();
    // front controller
    if((!isset($_SESSION['username']))||(!isset($_SESSION['password']))){
        header('Location: ./login.php');
        die();
    }
    if(isset($_SESSION['username'])&&isset($_SESSION['password'])){
        header('Location: ./user/Home.php');
        die();
    }
