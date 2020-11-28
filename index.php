<?php
    session_start();
    // front controller
    if((!isset($_SESSION['username']))||(!isset($_SESSION['password']))){
        header('Location: ./login.php');
        die();
    }
    if((isset($_SESSION['username']))&&(isset($_SESSION['password']))){

        if($_SESSION['role']===1){

        }
        if($_SESSION['role']===2){
            header('Location: .\Teacher\Home.php');
            die();

        }
        if($_SESSION['role']===3){

        }
    }
