<?php
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); //no cache
    session_cache_limiter('private_no_expire');
    session_start();
    // front controller
    if((!isset($_SESSION['username']))||(!isset($_SESSION['password']))){
        header('Location: ..\login.php');
        die();
    }
    else{
        header('Location: Home.php');
        die();
    }
    ?>
