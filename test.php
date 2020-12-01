<?php
    require_once('vendor/autoload.php');
    $db = new BaseModel();
    $result = $db->student_attend_class_by_code('admin','Huydepzai','1ab');
    print_r($result);
    ?>