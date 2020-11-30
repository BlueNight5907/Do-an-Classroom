<?php
    $create_class_announce = '';
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['TypeUpLoad'])&&isset($_POST['ClassName'])
            && isset($_POST['Subject']) && isset($_POST['Room'])
            ){
            if(!empty($_POST['ClassName']) && !empty($_POST['Subject']) && !empty($_POST['Room'])){
                $base = new BaseModel();
                $creator = $_SESSION['username'];
                $IDClass = $base->generateRandomString(7);
                $classname = $_POST['ClassName'];
                $subject = $_POST['Subject'];
                $classroom = $_POST['Room'];
                $img = '';
                //Upload ảnh nền lớp học
                if(isset($_FILES["BackgroundIMG"]) && $_FILES["BackgroundIMG"]["error"] == 0)
                    include 'UploadFile.php';
                //Kiểm tra xem mã lớp học có tồn tại hay ko
                $sql = "select count(*) from lophoc where TenLopHoc = ? and NguoiTao = ?";
                $param = array('ss',&$classname,&$creator);
                $data = $base->is_exists($sql,$param);
                if($data === false){
                    //Tạo lớp học
                    $sql = "insert into lophoc value(?,?,?,?,?,?,b'1')";
                    $param = array('ssssss',&$creator,&$IDClass,&$classname,&$subject,&$classroom,&$img);
                    $data = $base->query_prepared_nonquery($sql,$param);
                    //Them nguoi tao vao tham gia lop hoc
                    $JoinClassID = $base->generateRandomString();
                    $userrole = 1;
                    $sql = "insert into thamgialophoc value(?,?,?,?,b'1')";
                    $param = array('ssss',&$JoinClassID,&$IDClass,&$creator,&$userrole);
                    $data = $base->query_prepared_nonquery($sql,$param);
                    if( $data['code']===0){
                        $create_class_announce = 'thành công';
                        unset($_POST);
                    }
                    else
                        $create_class_announce =  $data['error'];
                }else{
                    $create_class_announce = 'thất bại';
                }
            }
        }
    }
?>