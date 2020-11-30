<?php
session_start();
// front controller
if((!isset($_SESSION['username']))||(!isset($_SESSION['password']))||($_SESSION['role']<2)){
    header('Location: ../index.php');
    die();
}
include_once '../vendor/autoload.php';
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
    <link rel="stylesheet" href="../style.css">
    <title>Home</title>
</head>
<body>
<?php
//Tải lên thông tin người dùng
$database = new BaseModel();
$sql = 'select * from account where account.username = ?';
$param = array('s',&$_SESSION['username'] );
$data = $database->query_prepared($sql, $param);
$user_infor = $data['data'][0];
//Tải lên thông tin của lớp học
$classcode = '';
$ClassName ='';
if(isset($_GET['Classroom'])){
    if(!empty($_GET['Classroom'])){
        $classcode = $_GET['Classroom'];
        $database = new BaseModel();
        $sql = "select * from thamgialophoc where MaLopHoc = ? and username = ? and activated = b'1'";
        $param = array('ss', &$classcode,&$_SESSION['username']);
        $data = $database->query_prepared($sql, $param);
        if($data['code']===0)
            if($data['data']==array()){
                header('Location: ../index.php');
                die();
            }
            else{
                $database = new BaseModel();
                $sql = "select TenLopHoc from lophoc where MaLopHoc = ? and activated = b'1'";
                $param = array('s', &$classcode);
                $data = $database->query_prepared($sql, $param);
                if($data['code']===0){
                    if($data['data']!==array())
                        $ClassName = $data['data'][0]['TenLopHoc'];
                    else{
                        header('Location: Home.php');
                        die();
                    }
                }
            }
        $_SESSION['ClassName']= $ClassName;
        $_SESSION['ClassCode']= $classcode;
    }
}
include 'inc/ChangeClassInfor.php';
$database = new BaseModel();
$sql = "select * from lophoc where MaLopHoc = ? and activated = b'1'";
$param = array('s', &$_SESSION['ClassCode']);
$data = $database->query_prepared($sql, $param);
$classInfor = null;
if($data['code']===0)
    if($data['data']!==array()){
        $classInfor = $data['data'][0];
    }
$role = null;
    $_SESSION["ClassBackGround"] = $classInfor['AnhDaiDien'];
if($classInfor['NguoiTao']===$_SESSION['username']){
    $_SESSION['ClassRole'] = 'creator';
}
else{
    $database = new BaseModel();
    $sql = 'select vaitro from thamgialophoc where MaLopHoc = ? and username = ?';
    $param = array('ss', &$_SESSION['ClassCode'],&$_SESSION['username']);
    $data = $database->query_prepared($sql, $param);
    $role = $data['data'][0]['vaitro'];
}
if($role === 2){
    $_SESSION['ClassRole'] = 'teacher';
}
elseif ($role === 3){
    $_SESSION['ClassRole'] = 'student';
}

?>
    <nav class="navbar py-0 top-navbar navbar-expand-md bg-light justify-content-between navbar-light">
        <div class="navbar-left d-flex justify-content-center">
            <button type="button" id="btn-sidebar"  class="mr-3 btn-light border border-dark align-content-center">
                <span >
                <label for="nav-item-check">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-justify" fill="currentColor">
                      <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </label>
            </span>
            </button>
            <a class="navbar-brand font-weight-bold text-info" href="#"><?php echo $_SESSION['ClassName']?></a>
        </div>
        <div id="navbar-function" class="col-lg-6 bg-light mr-1">
            <div class="function-button-group d-flex justify-content-center">
                <a href="./ClassView.Php?Action=ClassStream">
                    <div class="navbar-brand function-button stream-button px-4 pt-3">
                        Luồng
                    </div>
                </a>
                <a href="#">
                    <div class="navbar-brand function-button assignment-button px-4 pt-3">
                        Bài tập
                    </div>
                </a>
                <a href="./ClassView.Php?Action=ClassPeople">
                    <div class="navbar-brand function-button people-button px-4 pt-3">
                        Mọi người
                    </div>
                </a>
                <a href="#">
                    <div class="navbar-brand function-button mark-button px-4 pt-3">
                        Số điểm
                    </div>
                </a>

            </div>
        </div>





        <div class="navbar-right d-flex justify-content-end">
            <?php
            if(isset($_SESSION['ClassRole']))
                if($_SESSION['ClassRole'] === 'creator'){
            ?>
            <button type="button" class="btn btn-light" id="btn-setting-class" onclick="Open_change_class()">
                <span>
                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-list-task" fill="currentColor">
                    <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5H2zM3 3H2v1h1V3z"/>
                    <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1h-9z"/>
                    <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5V7zM2 7h1v1H2V7zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5H2zm1 .5H2v1h1v-1z"/>
                </svg>
                </span>
            </button>
            <?php
                }
            ?>
            <div class="dropdown" id="user-dropdown">
                <div class="user-avatar mx-3" id="dropdownUserProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="..\<?php echo $user_infor['userIMG']; ?>" alt="User">
                </div>
                <div class="dropdown-menu dropdownUserProfile" aria-labelledby="dropdownUserProfile">
                    <div class="user-card-container d-flex justify-content-center">
                        <div class="card user-card">
                            <div class="user-card-img-container d-flex justify-content-center">
                                <img class=" user-card-img" src="..\<?php echo $user_infor['userIMG']; ?>" alt="Card image">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $user_infor['Ho'].' '.$user_infor['Ten']; ?></h4>
                                <p class="card-text"><?php echo $user_infor['email']; ?></p>
                                <p class="d-flex"><a href="#" id="show-user-profile-btn" class="btn btn-primary">See Profile</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 pb-2 d-flex justify-content-center">
                        <button type="button" id="log-out-btn" class="log-out px-4 log-out-btn btn-danger btn">Đăng xuất</button>
                    </div>
                </div>
            </div>
        </div>

    </nav>
    <div class="function-button-group-container bg-light col-12 d-flex justify-content-center">
        <div id="navbar-function-under" class="col-lg-6 bg-light mr-1">
            <div class="function-button-group d-flex justify-content-center">
                <a href="./ClassView.Php?Action=ClassStream">
                    <div class="navbar-brand function-button stream-button px-4 pt-3">
                        Luồng
                    </div>
                </a>
                <a href="#">
                    <div class="navbar-brand function-button assignment-button px-4 pt-3">
                        Bài tập
                    </div>
                </a>
                <a href="./ClassView.Php?Action=ClassPeople">
                    <div class="navbar-brand function-button people-button px-4 pt-3">
                        Mọi người
                    </div>
                </a>
                <a href="#">
                    <div class="navbar-brand function-button mark-button px-4 pt-3">
                        Số điểm
                    </div>
                </a>

            </div>
        </div>
    </div>
    <!-- Side bar-->
<?php
include 'SideBar.php';
?>
    <!--Giao dien cua lop hoc-->
    <div class="main">
        <?php
        if(!empty($change_class_announce)){
            ?>
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Thay đổi thông tin lớp học <strong><?php echo $change_class_announce;?></strong>
            </div>
            <?php
        }
        ?>
        <?php
            if(isset($_GET['Action'])){
                if(!empty($_GET['Action'])){
                    $_SESSION['Action'] = $_GET['Action'];
                }
            }
            else{
                $_SESSION['Action']='ClassStream';
            }
            if(file_exists("./inc/".$_SESSION['Action'].'.php'))
                include "./inc/".$_SESSION['Action'].'.php';
            else{
                include "./inc/ClassStream.php";
            }
        ?>
    </div>
<?php
if(isset($_SESSION['ClassRole']))
if($_SESSION['ClassRole'] === 'creator'){
?>
<div class="change-class-form-container p-5">
    <br>
    <br>
    <form class="create-class-form bg-light col-7 mx-auto border rounded rounded-5 p-4 border-primary" method="post" enctype="multipart/form-data">
        <div class="create-class-form-header d-flex justify-content-between"><h2 class="text-primary">Thông tin lớp học</h2>
            <button type="button" class="btn btn-delete-class mt-1 btn-danger" data-toggle="modal" data-target="#confirm-remove-class-Modal">Xóa lớp học</button></div>
        <div class="form-group">
            <label for="ClassName">Tên lớp học</label>
            <input type="text" class="form-control" name="ClassName" value="<?= $classInfor['TenLopHoc'] ?>" id="ClassName" placeholder="Tên lớp học">
        </div>
        <div class="form-group">
            <label for="Object">Môn học</label>
            <input type="text"  class="form-control" name="Subject" value="<?= $classInfor['MonHoc'] ?>" id="Sbject" placeholder="Môn học">
        </div>
        <div class="form-group">
            <label for="Room">Phòng</label>
            <input type="text" class="form-control" name="Room" value="<?= $classInfor['PhongHoc'] ?>" id="Room" placeholder="Phòng học">
        </div>
        <div class="form-group">
            <label for="BackgroundIMG">Ảnh nền của lớp học</label>
            <input type="file" class="form-control" name="BackgroundIMG" id="BackgroundIMG" placeholder="img">
        </div>
        <div class="form-button justify-content-between">
            <button type="reset" class="btn btn-light border border-primary" onclick="Close_change_class()">Hủy</button>
            <button type="submit" name ='TypeUpLoad' value="BackgroundClass" class="btn mt-1 btn-primary">Thay đổi</button>
        </div>
    </form>
</div>
<?php
}
?>


    <div class="modal fade" id="confirm-remove-class-Modal">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Xóa lớp học</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Bạn có chắc là muốn xóa lớp học này
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="accept_remove_class btn btn-danger" data-dismiss="modal">Chắc chắn</button>
                    <button type="button" class="refuse_remove_class btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>




    <script src="../main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>