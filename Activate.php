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
    <link rel="stylesheet" href="..//style.css">
    <title>Quên mật khẩu</title>
</head>
<body class="bg-light">
<?php
    $error = '';
    if(isset($_GET['email'])&&isset($_GET['token'])){
        $email = $_GET['email'];
        $token = $_GET['token'];
        if(filter_var($email,FILTER_VALIDATE_EMAIL)===false){
            $error = 'Email không chính xác';
        }elseif (strlen($token)!=32){
            $error = 'Sai định dạng token';
        }
        else{
            $database = new BaseModel();
            $sql = 'select count(*) from account where activate_token = ? and email = ?';
            $param = array('ss', &$tokene,&$email);
            $data = $database->query_prepared_nonquery($sql, $param);
            if($data===false){
                $error = "Xác minh thất bại";

            }
            else{
                $database = new BaseModel();
                $sql = "update account set activated = b'1' where email = ?";
                $param = array('s',&$email);
                $data = $database->query_prepared_nonquery($sql, $param);
                if($data===false){
                    $error = "Xác minh thất bại";
                }
            }
        }
    }
?>
<!-- Login-form -->
<div class="login-form-container ">
    <div class="form-container-div">
        <div class="form-header-text"><h1 class="mx-auto text-info">Classroom</h1></div>
        <form action='login.php' class="login-form border-0 bg-white">
            <div class="form-container">
                <div class="form-header">
                    <h3 class="form-heading">Xác minh tài khoản</h3>

                </div>
                <div class="form-group pt-3">
                    <?php
                    if(!empty($error)){
                        ?>
                        <p class="text-danger">Xác minh tài khoản thất bại</p>
                     <?php
                    }else{
                    ?>
                    <p class="text-success">Chúc mừng bạn đã xác minh tài khoản thành công</p>
                    <?php
                    }
                    ?>
                    <p>Nhấn <a href="login.php">vào đây</a> để quay về trang đăng nhập</p>
                    <button class="btn btn-primary">Đăng nhập</button>
                </div>
            </div>
        </form>
    </div>
</div>





<script src="..//main.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>