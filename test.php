<?php
    require_once('vendor/autoload.php');
    $db = new BaseModel();
    $result = $db->invite_student('Huydepzai','henrypoter22@gmail.com','8ab');
    print_r($result);
    ?>