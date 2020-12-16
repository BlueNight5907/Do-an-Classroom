<?php
    session_start();
    require_once('vendor/autoload.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Icon -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- My style -->
    <link rel="stylesheet" href="./style.css">
    <title>Tham gia lớp học</title>
</head>
<body class="bg-light">
<?php
    $error = '';
    $success='';
    $state = '';
    if(isset($_GET['user'])&&isset($_GET['token'])&&isset($_GET['classID'])){
        $state = 'something';
        $username = $_GET['user'];
        $token = $_GET['token'];
        $classID = $_GET['classID'];
        $database = new BaseModel();
        $sql = 'select TenLopHoc from lophoc where MaLopHoc = ?';
        $param = array('s', &$classID);
        $stm = $database->query_prepared($sql, $param);
        if($stm['data'] != array()){
            $className = $stm['data'][0]['TenLopHoc'];
        }
        if($stm['code']!==0){
            die();
            $error = 'Xác minh thất bại';
        }else if($stm['data'] == array()){
            $error = 'Xác minh thất bại';
        }
        else if (strlen($token)!=32){
            $error = 'Sai định dạng token';
        }
        else{
            if(isset($_POST['confirm'])){
                if($_POST['confirm'] ==='accept'){
                    $database = new BaseModel();
                    $sql = 'select expire_on from attend_class_token where token = ? and username = ? and MaLopHoc = ?';
                    $param = array('sss', &$token,&$username,&$classID);
                    $stm = $database->query_prepared($sql, $param);
                    $exp = time();
                    if($stm['code']!==0){
                        $error = 'Xác minh thất bại';
                    }
                    else if($stm['data']!=array() && $stm['data'][0]['expire_on'] > $exp){
                        $database = new BaseModel();
                        $sql = "update thamgialophoc set activated = b'1' where username = ? and MaLopHoc = ?";
                        $param = array('ss',&$username,&$classID);
                        $data = $database->query_prepared_nonquery($sql, $param);
                        if($data===false){
                            $error = "Xác minh thất bại";
                        }
                    }
                    else{
                        $error = "Lời mời hết hạn";
                    }
                    $success = 'Thành công';
                }
                else{
                    die();
                }
            }
        }
    }
?>
<!-- Login-form -->
<div class="login-form-container ">
    <div class="form-container-div">
        <div class="form-header-text"><h1 class="mx-auto text-info">Classroom</h1></div>
        <form action='' method="post" class="login-form border-0 bg-white">
            <div class="form-container">
                <?php
                if(empty($error) && empty($success) && !empty($state)){
                ?>
                    <h3 class="text-success">Bạn được mời tham gia lớp học <?php echo $className ?></h3>
                    <div class="form-group pt-3">
                        <button type="submit" name="confirm" value="refuse" class="btn btn-danger">
                            Từ chối
                        </button>
                        <button type="submit" name="confirm" value="accept" class="btn btn-primary">
                            Đồng ý
                        </button>
                    </div>
                <?php
                }
                ?>
                <div class="form-group pt-3">
                    <?php
                    if(!empty($error)){
                        ?>
                        <h3 class="text-danger"><?php echo $error?></h3>
                     <?php
                    }else if(!empty($success)){
                    ?>
                    <h3 class="text-success">Chúc mừng bạn đã tham gia lớp học thành công</h3>
                    <p>Nhấn <a href="login.php">vào đây</a> để quay về trang đăng nhập</p>
                    <button class="btn btn-primary">Đăng nhập</button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</div>





<script src="./main.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>