<?php
    require_once('vendor/autoload.php');
    $db = new BaseModel();
    $result = $db->generateRandomString();
    echo $result;
    ?>