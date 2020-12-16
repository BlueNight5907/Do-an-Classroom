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
    <title>Đăng nhập</title>
</head>
<?php

    $error = '';
    if(isset($_POST['username'])&&isset($_POST['password'])){
        if(!empty($_POST['username'])&&!empty($_POST['password'])){
            $username = $_POST['username'];
            $database = new BaseModel();
            $sql = 'select account.username,password,vaitro,activated,email,Ho,Ten from account inner join phanquyen on account.username = phanquyen.username where account.username = ? or email = ?';
            $conn = Database::open();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username,$username);
            $stmt->execute();
            $data = $stmt->get_result()->fetch_assoc();

            if($data !== null){
                $hashed_password = $data['password'];
                $pasword = $_POST['password'];
                $active = $data['activated'];
                if(password_verify($pasword,$hashed_password)){
                    if($active === 0){
                        header("Location: UnactiveAccount.html");
                        die();
                    }
                    $_SESSION['password']=$_POST['password'];
                    $_SESSION['username']=$data['username'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['role'] = $data['vaitro'];
                    $_SESSION['fullname']=$data['Ho'].' '.$data['Ten'];
                    //unset($_POST);
                    header("Location: ./index.php");
                    die();
                }
                else{
                    $error = 'Tài khoản hoặc mật khẩu không tồn tại';
                }
            }
            else{
                $error = 'Tài khoản hoặc mật khẩu không tồn tại';
            }
        }
    }
?>
<body class="bg-light">
            <!-- Login-form -->
            <div class="login-form-container">
                <div class="form-container-div">
                    <div class="form-header-text"><h1 class="mx-auto text-info">Classroom</h1></div>
                    <form class="login-form bg-white" method="post">
                        <div class="form-container">
                            <div class="form-header">
                                <h3 class="form-heading">Đăng nhập</h3>
                                <a href="register.php"><span class="form-move-on-btn text-primary">Đăng ký</span></a>
                            </div>
                            <div class="form-group">
                                <input name="username" type="text" class="form-input" placeholder="Nhập email">
                            </div>

                            <div class="form-group">
                                <input name="password" type="password" class="form-input" placeholder="Nhập password">
                            </div>
                            <div class="auth-form-relations">
                                <div class="form-help">
                                    <a href="ForgetPassword.php" class="form-help-link form-help-forgot">Quên mật khẩu</a>
                                    <a href="help.html" class="form-help-link">Cần trợ giúp?</a>
                                </div>
                            </div>
                            <?php
                            if(!empty($error)){
                                echo "<div class='alert alert-danger alert-dismissible fade show'>$error</div>";
                            }
                            ?>

                            <div class="auth-form-controls">
                                <button type="submit" class="btn btn-primary col-12">ĐĂNG NHẬP</button>
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