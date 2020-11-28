<?php


if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = '%'.$_GET['search'].'%';


    $database = new BaseModel();
    $sql = "select * from lophoc inner join account on account.username = lophoc.NguoiTao inner join thamgialophoc on lophoc.MaLopHoc = thamgialophoc.MaLopHoc where thamgialophoc.username = ? and 
thamgialophoc.activated = b'1' and (TenLopHoc like ? or MonHoc like ? or PhongHoc like ? or CONCAT(Ho,' ',Ten) like ? or lophoc.MaLopHoc like ?)";
    $param = array('ssssss',&$_SESSION['username'],&$search,&$search,&$search,&$search,&$search);

    $data = $database->query_prepared($sql, $param);
    $ClassInfor = $data['data'];
    print_r($ClassInfor);
}
else{
    $database = new BaseModel();
    $sql = 'select * from lophoc inner join thamgialophoc on lophoc.MaLopHoc = thamgialophoc.MaLopHoc where thamgialophoc.username = ?';
    $param = array('s', &$_SESSION['username']);
    $data = $database->query_prepared($sql, $param);
    $ClassInfor = $data['data'];
}

