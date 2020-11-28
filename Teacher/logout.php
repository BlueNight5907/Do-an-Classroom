<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<body>

    <?php
    // xóa tất cả các biến session
    session_unset();
    session_destroy();
    print_r($_SESSION);
    header('Location: ../index.php');
    die();
    ?>

</body>
</html>