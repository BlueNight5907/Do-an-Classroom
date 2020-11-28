<?php
session_start();
// front controller
if((!isset($_SESSION['username']))||(!isset($_SESSION['password']))||($_SESSION['role']!==2)){
    header('Location: ../index.php');
    die();
}
if(isset($_GET['Classroom'])&&$_GET['Classroom']==='a'){
    print_r('Hello World');
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
//Tải lên danh sách lớp học
$classcode = '';
$ClassName ='';
if(isset($_GET['Classroom'])){
    if(!empty($_GET['Classroom'])){
        $classcode = $_GET['Classroom'];
        $database = new BaseModel();
        $sql = 'select * from thamgialophoc where MaLopHoc = ? and username = ?';
        $param = array('ss', &$classcode,&$_SESSION['username']);
        $data = $database->query_prepared($sql, $param);
        if($data['code']===0)
            if($data['data']==array()){
                header('Location: ../index.php');
                die();
            }
            else{
                $database = new BaseModel();
                $sql = 'select TenLopHoc from lophoc where MaLopHoc = ?';
                $param = array('s', &$classcode);
                $data = $database->query_prepared($sql, $param);
                if($data['code']===0)
                    if($data['data']!==array())
                        $ClassName = $data['data'][0]['TenLopHoc'];
            }
        $_SESSION['ClassName']= $ClassName;
        $_SESSION['ClassCode']= $classcode;
    }
}


?>
    <nav class="navbar py-0 top-navbar navbar-expand-md bg-light justify-content-between navbar-light">
        <div class="navbar-left d-flex justify-content-center">
            <button type="button" id="btn-sidebar"  class="mr-3 btn-light border border-dark align-content-center">
                <span >
                <label for="nav-item-check">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-justify" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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

            <div class="dropdown" id="user-dropdown">
                <div class="user-avatar mx-3" id="dropdownUserProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo $user_infor['userIMG']; ?>" alt="User">
                </div>
                <div class="dropdown-menu dropdownUserProfile" aria-labelledby="dropdownUserProfile">
                    <div class="user-card-container d-flex justify-content-center">
                        <div class="card user-card">
                            <div class="user-card-img-container d-flex justify-content-center">
                                <img class=" user-card-img" src="<?php echo $user_infor['userIMG']; ?>" alt="Card image">
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









    <script src="..//main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>