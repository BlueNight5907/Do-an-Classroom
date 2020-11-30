<?php
$Change_class_announce = '';
if(isset($_POST['TypeUpLoad'])&&isset($_POST['ClassName'])
    && isset($_POST['Subject']) && isset($_POST['Room'])
){
    if(!empty($_POST['ClassName']) && !empty($_POST['Subject']) && !empty($_POST['Room'])){
        $base = new BaseModel();
        $creator = $_SESSION['username'];
        $IDClass = $_SESSION['ClassCode'];
        $classname = $_POST['ClassName'];
        $subject = $_POST['Subject'];
        $classroom = $_POST['Room'];
        $img = $_SESSION["ClassBackGround"];
        //Upload ảnh nền lớp học
        if(isset($_FILES["BackgroundIMG"]) && $_FILES["BackgroundIMG"]["error"] == 0)
            include 'UploadFile.php';
        //Kiểm tra xem mã lớp học có tồn tại hay ko
        $sql = "select count(*) from lophoc where MaLopHoc = ? and NguoiTao = ?";
        $param = array('ss',&$IDClass,&$creator);
        $data = $base->is_exists($sql,$param);
        if($data === true){
            //Thay đổi thông tin lớp học
            $data = $base->updateClassRoom($classname,$subject,$classroom,$img,$IDClass);
            print_r($data);
            if( $data['code']===0){
                $_SESSION['ClassName'] = $classname;
                $Change_class_announce = 'thành công';
                unset($_POST);
            }
            else
                $Change_class_announce =  $data['error'];
        }else{
            $Change_class_announce = 'thất bại';
        }
    }else{
        $Change_class_announce = 'thất bại';
    }
}
?>
