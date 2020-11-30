<?php
    session_start();
    include_once '../../vendor/autoload.php';
    $return_param = '';
    if(isset($_POST['ID'])){
        if(!empty($_POST['ID'])){
            $db = new BaseModel();
            $ID = $_POST['ID'];
            $sql = 'delete from thamgialophoc where JoinClassID = ?';
            $param = array('s',&$ID);
            $result = $db->query_prepared_nonquery($sql,$param);
            if($result['code']===0)
                $return_param = 'success';
            else
                $return_param = $result['error'];
        }
    }
    else{
        echo 'failed';
    }
    echo json_encode(array('result'=>$return_param));
    die();