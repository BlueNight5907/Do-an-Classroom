<?php
/*
$file_type = [
    'zip'=> 'Compressed File',
    'rar'=> 'Compressed File',
    'gz'=> 'Compressed File',
    '7z'=> 'Compressed File',
    'jpg'=> 'Image',
    'png'=> 'Image',
    'jfif'=> 'Image',
    'jpeg'=> 'Image',
    'gif'=> 'Image',
    'bmf'=> 'Image',
    'mp3'=> 'Audio',
    'wav'=> 'Audio',
    'mp4'=> 'Video',
    'doc'=> 'Microsoft Word 2003',
    'docx'=> 'Microsoft Word 2010',
    'pdf'=> 'PDF Document',
    'php'=> 'PHP Code',
    'pdf'=> 'Stylesheet',
    'txt'=> 'Text'
];
$icon = [

    'Folder'=>'<i class="fas fa-folder-plus"></i>',
    'Compressed File'=>'<i class="fas fa-file-archive"></i>',
    'Image'=>'<i class="fas fa-file-image"></i>',
    'Audio'=>'<i class="fa fa-headphones"></i>',
    'Video'=>'<i class="fa fa-file-video-o"></i>',
    'Microsoft Word 2003'=>'<i class="fas fa-file"></i>',
    'Microsoft Word 2010'=>'<i class="fas fa-file"></i>',
    'PDF Document'=>'<i class="fas fa-file"></i>',
    'PHP Code'=>'<i class="fas fa-file"></i>',
    'Stylesheet'=>'<i class="fas fa-file"></i>',
    'Text'=>'<i class="fas fa-file"></i>'
];
/*
$root = "../../Public/users/".$_SESSION['username'];
if(!file_exists($root)){
    mkdir($root);
}
$listFiles = scandir($root);
/*
 * foreach($listFiles as $f){
 *      <?= $f ?>
 * }
 */
$file_upload_err = '';
$root = '';
$type_up_load = '';
    // Kiểm tra xem file đã tải lên mà không có lỗi
$type_up_load = $_POST['TypeUpLoad'];
if($type_up_load === 'BackgroundClass')
    $root = 'Public/backgroundIMG/';
else if($type_up_load == 'UserAvt')
    $root = 'Public/img/';
else
    $root = 'Public/users/';
$allowed = array("jfif" => "image/jfif","jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
$filename = $_FILES["BackgroundIMG"]["name"];
$filetype = $_FILES["BackgroundIMG"]["type"];
$filesize = $_FILES["BackgroundIMG"]["size"];
$base = new BaseModel();
// Xác nhận phần mở rộng của file
$firstparth = pathinfo($filename,PATHINFO_FILENAME).$base->generateRandomString();
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if(!array_key_exists($ext, $allowed)) die("Error: Vui lòng chọn đúng định dạng file.");
// Xác nhận kích thước file - tối đa 5MB
$maxsize = 10 * 1024 * 1024;
if($filesize > $maxsize) die("Error: Kích thước File quá lớn.");
// Xác định loại file
if(in_array($filetype, $allowed)){
    // Kiểm tra xem file có tồn tại trước khi upload hay không
    if(file_exists("../../".$root.$firstparth.'.'.$ext)){
        $file_upload_err = $filename . " is already exists.";
    } else{
        move_uploaded_file($_FILES["BackgroundIMG"]["tmp_name"], "../".$root.$firstparth.'.'.$ext);
        $img = $root.$firstparth.'.'.$ext;
    }
}
?>
