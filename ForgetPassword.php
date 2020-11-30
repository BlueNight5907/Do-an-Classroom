<?php
    require_once('vendor/autoload.php');
    if(isset($_POST)){
        if(!empty($_POST['email'])){
            $base = new BaseModel();
            $base->reset_password($_POST['email']);
            header('Location: returnlogin.html');
            die();
        }
    }
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
<!-- Login-form -->
<div class="login-form-container">
    <div class="form-container-div col-7">
        <div class="form-header-text"><h1 class="mx-auto text-info">Classroom</h1></div>
        <form method="post" class="login-form bg-white mx-auto">
            <div class="form-container">
                <div class="form-header">
                    <h3 class="form-heading font-weight-bold text-primary">Quên mật khẩu</h3>
                </div>
                <div class="form-group pb-3">
                    <input type="text" class="form-input " name="email" placeholder="Mời bạn nhập Email">
                </div>

                <div class="auth-form-controls">
                    <a href=".\\login.php"><div class="btn btn-light form-controls-back btn-normal">QUAY LẠI</div></a>
                    <button class="btn btn-primary">Xác nhận</button>
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