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
    <title>Home</title>
</head>
<body class="bg-light">
<?php
$ho ='';
$ten ='';
$email='';
$ngaysinh='';
$sdt='';
$username='';
$pass='';
$repass='';
$error='';
$result='';
if(isset($_POST)){
    if(!empty($_POST)){
        $ho = $_POST['Ho'];
        $ten = $_POST['Ten'];
        $email=$_POST['Email'];
        $ngaysinh=$_POST['NgaySinh'];
        $sdt=$_POST['Sdt'];
        $username=$_POST['username'];
        $pass=$_POST['password'];
        $repass=$_POST['re-password'];
        $database = new BaseModel();
        $sql = 'select count(*) from account where username = ? or email = ?';
        $param = array('ss', &$username,&$email);
        $data = $database->is_exists($sql, $param);
        if($data===true){
            $error = "Tài khoản đã tồn tại";
        }
        else{
            $hash = password_hash($pass,PASSWORD_DEFAULT);
            $rand = random_int(0 ,1000);
            $token = md5($username.'+'.$rand);
            $database = new BaseModel();
            $sql = 'insert into account(Ho,Ten,NgaySinh,email,username,password,activate_token) values(?,?,?,?,?,?,?)';
            $param = array('sssssss',&$ho,&$ten,&$ngaysinh,&$email,&$username,&$hash,&$token);
            $data = $database->query_prepared_nonquery($sql, $param);
            $result = $data['data'];
            $sql = 'insert into phanquyen values(?,?)';
            $role = 2;
            $param = array('si',&$username,&$role);
            $data = $database->query_prepared_nonquery($sql, $param);
            if($result!=='success'){
                $error = "Đã xảy ra lỗi trong quá trình tạo tài khoản, vui lòng thử lại sau";
            }
            else{
                unset($_POST);
                $db = new BaseModel();
                $result = $db->send_activation_email($email,$token);
            }
        }
        if(empty($error)){
            header('Location: ReturnLogin.html');
            die();
        }
    }
}

?>
    <div class="register-form-container">
        <div class="register-form form-container-div">
            <div class="form-header-text"><h1 class="mx-auto text-info">Classroom</h1></div>
            <!-- Register-form -->
            <form action="" method="post" class="register-form bg-white needs-validation" novalidate>
                <div class="form-container">
                    <div class="form-header">
                        <h3 class="form-heading font-weight-bold">Đăng ký</h3>
                        <a href="login.php"><span class="form-move-on-btn text-primary">Đăng nhập</span></a>
                    </div>
                    <div class="form-group user-infors form-row">
                        <div class="col-sm-6">
                            <label>Họ</label>
                            <input type="text" name ="Ho" class="form-control form-input" placeholder="Họ" required>
                            <div class="valid-feedback">

                            </div>
                            <div class="invalid-feedback">Bạn chưa nhập Họ</div>
                        </div>
                        <div class="col-sm-6">
                            <label>Tên</label>
                            <input type="text" name ="Ten" class="form-control form-input" placeholder="Tên" required>
                            <div class="valid-feedback">

                            </div>
                            <div class="invalid-feedback">Bạn chưa nhập Tên</div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Email</label>
                        <input type="email" name ="Email" class="form-control form-input" placeholder="Nhập Email" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Email chưa chính xác hoặc chưa nhập</div>
                    </div>
                    <div class="form-group mb-0">
                        <label>Ngày sinh</label>
                        <input type="date" name ="NgaySinh" class="form-control form-input" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Chưa nhập ngày sinh</div>
                        <label>Số điện thoại</label>
                        <input type="text" name ="Sdt" class="form-control form-input" placeholder="Nhập số điện thoại" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Bạn chưa nhập số điện thoại</div>
                    </div>

                    <div class="form-group">
                        <label >Tên đăng nhập</label>
                        <input type="text" name ="username" class="form-control form-input" placeholder="Nhập tên tài khoản" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Bạn chưa nhập tên đăng nhập</div>
                        <label>Mật khẩu</label>
                        <input type="password" name ="password" class="form-control form-input" placeholder="Nhập password" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Bạn chưa nhập mật khẩu</div>
                        <label>Nhập lại mật khẩu</label>
                        <input type="password" name ="re-password" class="form-control form-input" placeholder="Nhập lại password" required>
                        <div class="valid-feedback"></div>
                        <div class="invalid-feedback">Bạn chưa xác nhập lại mật khẩu</div>
                    </div>
                    <?php if($error !=='')
                    {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    }
                    ?>
                    <p class="form-notice">Sử dụng 8 kí tự trở lên và kết hợp các chữ cái, chữ số và biểu tượng.</p>
                    <div class="auth-form-controls">
                        <a href="login.php"><div class="btn btn-light form-controls-back btn-normal">QUAY LẠI</div></a>
                        <button type="submit" class="btn btn-primary" >ĐĂNG KÝ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>