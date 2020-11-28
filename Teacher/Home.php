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
    $search='';

    $database = new BaseModel();
    $sql = 'select * from account where account.username = ?';
    $param = array('s',&$_SESSION['username'] );
    $data = $database->query_prepared($sql, $param);
    $user_infor = $data['data'][0];
    $_SESSION['userIMG']=$user_infor['userIMG'];
    //Tải lên danh sách lớp học
    include '.\inc\LoadClass.php';
    print_r($ClassInfor);
    echo '</br>';

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
            <a class="navbar-brand font-weight-bold text-info" href="#">Classroom</a>
        </div>
        <div id="navbar-function" class="col-lg-6 bg-light mr-1">
            
        </div>
        <div class="navbar-right d-flex justify-content-end">
            <div class="dropdown">
                <button type="button" class="btn btn-custom py-1 px-0" data-toggle="dropdown">

                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-plus">
                        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>

                </button>
                <div class="dropdown-menu add">
                    <a class="dropdown-item bg-light" onclick="Open_create_class()">Tạo lớp học</a>
                    <a class="dropdown-item bg-light"  onclick="Open_attend_class()">Tham gia lớp học</a>
                </div>
            </div>
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
    <!--Siderbar-->
<?php
    include 'SideBar.php';
?>
    <!--Tao lop hoc-->
    <div class="create-class-form-container p-5">
        <br>
        <br>
        <form class="create-class-form bg-light col-7 mx-auto border rounded rounded-5 p-4 border-primary" action ="#" method="get" onsubmit="">
            <div class="create-class-form-header"><h2 class="text-primary">Tạo lớp học</h2></div>
            <div class="form-group">
                <label for="ClassName">Tên lớp học</label>
                <input type="text" name="ClassName"  class="form-control" id="ClassName" aria-describedby="emailHelp" placeholder="Tên lớp học">
                <small id="ClassName-help" class="form-text text-muted">Bạn cần nhập tên lớp học.</small>
            </div>
            <div class="form-group">
                <label for="Object">Môn học</label>
                <input type="text" class="form-control" name="Object" id="Object" placeholder="Môn học">
            </div>
            <div class="form-group">
                <label for="Room">Phòng</label>
                <input type="text" class="form-control" name="Room" id="Room" placeholder="Phần">
            </div>
			<div class="form-group">
                <label for="Describe">Mô tả</label>
                <input type="text" class="form-control" name="Describe" id="Describe" placeholder="Mô tả về lớp học">
            </div>
            <div class="form-button justify-content-between">
                <button type="reset" class="btn btn-light border border-primary" onclick="Close_create_class()">Hủy</button>
                <button type="submit" class="btn mt-1 btn-primary">Tạo lớp học</button>
            </div>
        </form>
    </div>
    <!--Them lop hoc-->
    <div class="attend-class">
        <header class="join-class-header bg-light">
            <div class="ml-2 user-avatar bg-light exit">
                <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-x" onclick="Close_attend_class()" >
                    <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
            <div class="text"><h4>Tham gia lớp học</h4></div>
            <button type='button' class="join-class btn btn-primary mr-4">
                Tham gia
            </button>
        </header>
        <div class="container">
            <div class="row">
                <div class="box jumbotron bg-light border border-primary">
                    <div>
                        <p>Tài khoản mà bạn đang đăng nhập là</p>
                    </div>

                    <div class="group-account">
                        <div class="account">
                            <div>
                                <div class="user-avatar">
                                    <img class="img-avt" src="<?php echo $user_infor['userIMG']; ?>" alt="Logo">
                                </div>
                            </div>

                            <div class="account-infor">
                                <h5><?php echo $user_infor['Ho'].' '.$user_infor['Ten']; ?></h5>
                                <p><?php echo $user_infor['email']; ?></p>
                            </div>
                            <div class="short-and-fixed">
                                <div></div>
                            </div>
                        </div>
                        <a href="logout.php">
                            <button type="button" class="switch font-weight-bold btn btn-light border border-primary text-primary">
                                Chuyển tài khoản
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            </br>
            <div class="row">
                <div class="box jumbotron bg-light border border-primary">
                    <h4>Mã lớp học</h4>
                    <p>Mã lớp học của bạn sẽ được giáo viên cấp, sau đó nhập vào đây</p>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Code</span>
                        </div>
                        <input type="text" name="ClassCode" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="notice">
                    <h4>Để tham gia vào lớp học bạn cần:</h4>
                    <ul class="list-notice">
                        <li>Sử dụng tài khoản được ủy quyền</li>
                        <li>Sử dụng class code với 5-7 kí tự là chữ hoặc số, ký tự không hợp lệ sẽ không được chấp nhận</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Giao dien cua lop hoc-->
    <section class="main-header">
        <div class="container justify-content-between">
            <div class="options-active">
                <div class="to-do">
                    <a href="#">
                        <span><i class="far fa-list-alt"></i></span>
                        <span>To-do</span>
                    </a>
                </div>
                <div class="calendar">
                    <a href="#">
                        <span><i class="far fa-calendar"></i></span>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>
            <form action="" method="get" class="form-inline my-2 my-lg-0">
                <input name="search" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn border btn-search border-success btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>

    </section>
    <!-- Đổ dữ liệu classlist vào Home-->
    <section class="main-class">
        <div class="container-fluid p-4">
            <?php
                include '.\inc\Classlist.php';
            ?>
        </div>
    </section>
    <footer class="footer">
        <i class="far fa-question-circle"></i>
    </footer>










    <script src="..//main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>