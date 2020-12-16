<?php
    session_start();
// front controller
if((!isset($_SESSION['username']))||(!isset($_SESSION['password']))){
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
    $search='';

    $database = new BaseModel();
    $sql = 'select * from account where account.username = ?';
    $param = array('s',&$_SESSION['username'] );
    $data = $database->query_prepared($sql, $param);
    $user_infor = $data['data'][0];
    $_SESSION['userIMG']=$user_infor['userIMG'];

    //Xử lý form tạo lớp học
    include_once 'inc/CreateNewClass.php';
    //Tải lên danh sách lớp học
    include '.\inc\LoadClass.php';



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

                <?php
                if($_SESSION['role']===3){
                ?>
                    <button type="button" class="btn btn-custom py-1 px-0" onclick="Open_attend_class()" data-toggle="dropdown">

                        <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-plus">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>

                    </button>
                <?php
                }else{
                ?>
                    <button type="button" class="btn btn-custom py-1 px-0" data-toggle="dropdown">

                        <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-plus">
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>

                    </button>
                    <div class="dropdown-menu menu-function add">
                        <a class="dropdown-item bg-light" onclick="Open_create_class()">Tạo lớp học</a>
                        <a class="dropdown-item bg-light"  onclick="Open_attend_class()">Tham gia lớp học</a>
                        <?php
                        if($_SESSION['role']===1){
                        ?>
                        <a class="dropdown-item bg-light" data-toggle="modal" data-target="#decentralization">Phân quyền người dùng</a>
                        <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="dropdown" id="user-dropdown">
                <div class="user-avatar mx-3" id="dropdownUserProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../<?php echo $user_infor['userIMG']; ?>" alt="User">
                </div>
                <div class="dropdown-menu dropdownUserProfile" aria-labelledby="dropdownUserProfile">
                    <div class="user-card-container d-flex justify-content-center">
                        <div class="card user-card">
                            <div class="user-card-img-container d-flex justify-content-center">
                                <img class=" user-card-img" src="../<?php echo $user_infor['userIMG']; ?>" alt="Card image">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $user_infor['Ho'].' '.$user_infor['Ten'];
                                    if($_SESSION['role']===1) {
                                        echo '(Admin)';
                                    }?></h4>
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
<?php
if($_SESSION['role']!==3){
    ?>
    <!--Tao lop hoc-->
    <div class="create-class-form-container p-5">
        <br>
        <br>
        <form class="create-class-form bg-light col-7 mx-auto border rounded rounded-5 p-4 border-primary" action ="#" method="post" enctype="multipart/form-data">
            <div class="create-class-form-header"><h2 class="text-primary">Tạo lớp học</h2></div>
            <div class="form-group">
                <label for="ClassName">Tên lớp học</label>
                <input type="text" name="ClassName"  class="form-control" id="ClassName" aria-describedby="emailHelp" placeholder="Tên lớp học">
                <small id="ClassName-help" class="form-text text-muted">Bạn cần nhập tên lớp học.</small>
            </div>
            <div class="form-group">
                <label for="Object">Môn học</label>
                <input type="text" class="form-control" name="Subject" id="Subject" placeholder="Môn học">
            </div>
            <div class="form-group">
                <label for="Room">Phòng</label>
                <input type="text" class="form-control" name="Room" id ="Room" placeholder="Phòng học">
            </div>
            <div class="form-group">
                <label for="BackgroundIMG">Ảnh nền của lớp học</label>
                <input type="file" class="form-control" name="BackgroundIMG" id="BackgroundIMG" placeholder="img">
            </div>
            <div class="form-button justify-content-between">
                <button type="reset" class="btn btn-light border border-primary" onclick="Close_create_class()">Hủy</button>
                <button type="submit" name="TypeUpLoad" value="BackgroundClass" class="btn mt-1 btn-primary">Tạo lớp học</button>
            </div>
        </form>
    </div>
    <?php
}
?>

    <!--Tham gia lop hoc-->
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
                                    <img class="img-avt" src="../<?php echo $user_infor['userIMG']; ?>" alt="Logo">
                                </div>
                            </div>

                            <div class="account-infor">
                                <h5><?php echo $user_infor['Ho'].' '.$user_infor['Ten'];
                                if($_SESSION['role']===1) {
                                    echo '(Admin)';
                                }?></h5>
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
                        <input type="text" name="ClassCode" id="class-code" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                    </div>
                </div>
            </div>
            </br>
            <div class="row">
                <div class="notice">
                    <h4>Để tham gia vào lớp học bạn cần:</h4>
                    <ul class="list-notice">
                        <li>Sử dụng tài khoản được ủy quyền</li>
                        <li>Sử dụng class code với các kí tự là chữ hoặc số, ký tự không hợp lệ sẽ không được chấp nhận</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Giao dien cua lop hoc-->
    <section class="main-header">
        <div class="container-fluid justify-content-between">
            <div class="options-active">
                <div class="to-do">
                    <a href="Home.php">
                        <span><i class="far fa-list-alt"></i></span>
                        <span>Home</span>
                    </a>
                </div>
                <div class="calendar">
                    <a href="#">
                        <span><i class="far fa-calendar"></i></span>
                        <span>Công việc</span>
                    </a>
                </div>
            </div>
            <form action="" method="get" class="form-inline my-2 my-lg-0">
                <input name="search" class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" aria-label="Search">
                <button class="btn border btn-search border-success btn-outline-success my-2 my-sm-0" type="submit">Tìm kiếm</button>
            </form>
        </div>

    </section>
    <!-- Đổ dữ liệu classlist vào Home-->
    <section class="main-class">
        <?php
        if(!empty($create_class_announce)){
            ?>
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Tạo lớp học <strong><?php echo $create_class_announce;?></strong>
            </div>
            <?php
        }
        ?>
        <div class="container-fluid p-4">
            <?php
                include '.\inc\Classlist.php';
            ?>
        </div>
    </section>
    <footer class="footer">
        <i class="far fa-question-circle"></i>
    </footer>


<?php
if($_SESSION['role']===1){
    $base = new BaseModel();
    $Admins=array();
    $Teachers=array();
    $Students = array();
    $data = $base->get_all_user();
    if($data['code']===0){
        foreach ($data['data'] as &$someone) {
            if($someone['vaitro']==1){
                array_push($Admins, $someone);
            }
            elseif($someone['vaitro']==2){
                array_push($Teachers, $someone);
            }
            elseif($someone['vaitro']==3){
                array_push($Students, $someone);
            }
        }
    }
?>

    <!-- Modal phân quyền người dùng-->
    <div class="modal fade bd-example-modal-lg" id="decentralization" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#admin">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#teacher">Giáo viên</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#students">Học sinh</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!--Admin Tab panes -->
                    <div id="admin" class="container tab-pane active"><br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($Admins as $admin){
                            ?>
                                <tr>
                                    <td><?php echo $admin['HoTen'] ?></td>
                                    <td><?php echo $admin['username'] ?></td>
                                    <td><?php echo $admin['email']?></td>
                                </tr>

                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                    <!--Teacher Tab -->
                    <div id="teacher" class="container tab-pane fade"><br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($Teachers as $teacher){
                            ?>

                                <tr>
                                    <td><?php echo $teacher['HoTen'] ?></td>
                                    <td><?php echo $teacher['username'] ?></td>
                                    <td><?php echo $teacher['email'] ?></td>
                                    <td <?php echo 'id ="'.$teacher['username'].'"' ?> class="set-permission d-flex justify-content-center">
                                        <button type="button" class="mr-1 btn mt-1 btn-outline-primary set-admin-btn">Set Admin</button>
                                        <button type="button" class="mr-1 btn mt-1 btn-outline-info set-student-btn">Set Student</button>
                                    </td>
                                </tr>

                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!--Student Tab panes -->
                    <div id="students" class="container tab-pane fade"><br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tên</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($Students as $student){
                            ?>
                                <tr>
                                    <td><?php echo $student['HoTen'] ?></td>
                                    <td><?php echo $student['username'] ?></td>
                                    <td><?php echo $student['email'] ?></td>
                                    <td <?php echo 'id ="'.$student['username'].'"' ?> class="set-permission d-flex justify-content-center">
                                        <button type="button" class="mr-1 mt-1 btn btn-outline-primary set-admin-btn">Set Admin</button>
                                        <button type="button" class="mr-1 mt-1 btn btn-outline-info set-teacher-btn">Set Teacher</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>








    <script src="../main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>