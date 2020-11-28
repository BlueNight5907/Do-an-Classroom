<?php
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
    <title>Lấy lại mật khẩu</title>
</head>
<body class="bg-light">
<?php
$error='';
$email='';
$pass='';
$pass_confirm='';
$post_error ='';
$display_email = filter_input(INPUT_GET,'email');
if(isset($_GET['email']) && isset($_GET['token'])){
    $email=$_GET['email'];
    $token=$_GET['token'];
    if(filter_var($email,FILTER_VALIDATE_EMAIL)===false){
        $error = 'Sai định dạng email';
    }
    elseif (strlen($token)!=32){
        $error = 'Sai định dạng token';
    }
    else{
        //Xử lý post
        if(isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['pass-confirm'])){
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            $pass_confirm=$_POST['pass-confirm'];
            if(empty($email)){
                $post_error = 'Chưa nhập email';
            }else if(filter_var($email,FILTER_VALIDATE_EMAIL)===false){
                $post_error = 'Sai định dạng email';
            }else if(empty($pass)){
                $post_error = 'Chưa nhập mật khẩu';
            }else if(strlen($pass)<6){
                $post_error = 'Mật khẩu phải lớn hơn 6 ký tự';
            }else if($pass != $pass_confirm){
                $post_error = 'Mật khẩu không khớp với nhau';
            }
            else{
                //Xử lý post và đổi mật khẩu;
                $db = new BaseModel();
                $exp = time();
                $sql = 'select expire_on from reset_token where email = ? and token = ?';
                $param = array('ss',&$email, &$token);
                $stm = $db->query_prepared($sql,$param);
                $result = $stm['data'][0]['expire_on'];
                if($result > $exp){
                    $hash = password_hash($pass,PASSWORD_DEFAULT);
                    $sql = 'update account set password = ? where email = ?';
                    $param = array('ss', &$hash,&$email);
                    $stm = $db->query_prepared_nonquery($sql,$param);
                    $anounce = '';
                    if($stm['code']===0){
                        $anounce = 'Đổi mật khẩu thành công';
                    }else{
                        $anounce = 'Đổi mật khẩu thất bại';
                    }
                    require_once 'Announce.php';
                    die();
                }
            }

        }
    }
}
else{
    $error = 'Sai địa chỉ email hoặc token';
}
?>
            <!-- Login-form -->
            <div class="login-form-container">
                <div class="form-container-div">
                    <div class="form-header-text"><h1 class="mx-auto text-info">Classroom</h1></div>


                            <?php
                            if(!empty($error)){
                                ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?php echo $error ?>
                                </div>
                            <?php
                            }else{
                                ?>
                                <form method="post" class="login-form bg-white">
                                    <div class="form-container">
                                        <div class="form-header">
                                            <h3 class="form-heading font-weight-bold text-primary">Lấy lại mật khẩu</h3>
                                        </div>
                                        <div class="form-group">
                                            <p class="m-0 pl-1 ">Email</p>
                                            <input type="text" class="form-control form-input m-1" name="email" value="<?php echo $display_email ?>" readonly>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="pass" class="form-input" placeholder="Nhập password">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="pass-confirm" class="form-input" placeholder="Nhập lại password">
                                        </div>
                                        <?php
                                        if(!empty($post_error)){
                                        ?>
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <?php echo $post_error; ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="auth-form-controls">
                                            <a href="login.php"><button class="btn form-controls-back btn-normal">QUAY LẠI</button></a>
                                            <button class="btn btn-primary">Đổi mật khẩu</button>
                                        </div>
                                    </div>
                                </form>
                            <?php
                            }
                            ?>

                </div>
            </div>





    <script src="./main.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>