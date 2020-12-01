<?php


if(isset($_GET['search']) && !empty($_GET['search'])){
    $search = '%'.$_GET['search'].'%';
    $database = new BaseModel();
    $sql='';
    $param='';
    if($_SESSION['role']===1){
        $sql = "select * from lophoc inner join account on lophoc.NguoiTao = account.username where lophoc.activated = b'1' and (TenLopHoc like ? or MonHoc like ? or PhongHoc like ? or CONCAT(Ho,' ',Ten) like ? or MaLopHoc like ?)";
        $param = array('sssss',&$search,&$search,&$search,&$search,&$search);
    }else{
        $sql = "select * from lophoc inner join account on account.username = lophoc.NguoiTao inner join thamgialophoc on lophoc.MaLopHoc = thamgialophoc.MaLopHoc where thamgialophoc.username = ? and 
        thamgialophoc.activated = b'1' and (TenLopHoc like ? or MonHoc like ? or PhongHoc like ? or CONCAT(Ho,' ',Ten) like ? or lophoc.MaLopHoc like ?)";
        $param = array('ssssss',&$_SESSION['username'],&$search,&$search,&$search,&$search,&$search);
    }
    $data = $database->query_prepared($sql, $param);
    $ClassInfor = $data['data'];
}
else{
    $database = new BaseModel();
    $sql='';
    $param = '';
    $data = '';
    if($_SESSION['role']===1){
        $sql = "select * from lophoc where activated=b'1'";
        $data = $database->query($sql);
    }else{
        $sql = "select * from lophoc inner join thamgialophoc on lophoc.MaLopHoc = thamgialophoc.MaLopHoc where thamgialophoc.username = ? and lophoc.activated=b'1' and thamgialophoc.activated = b'1'";
        $param = array('s', &$_SESSION['username']);
        $data = $database->query_prepared($sql, $param);
    }
    $ClassInfor = $data['data'];
}

