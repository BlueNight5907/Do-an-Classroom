<?php
    $database = new BaseModel();
    $sql = 'select * from lophoc where MaLopHoc = ?';
    $param = array('s', &$_SESSION['ClassCode']);
    $data = $database->query_prepared($sql, $param);
    $classInfor = null;
    if($data['code']===0)
        if($data['data']!==array()){
            $classInfor = $data['data'][0];
        }
    $role = null;
    if($classInfor['NguoiTao']===$_SESSION['username']){
        $_SESSION['ClassRole'] = 'creator';
    }
    else{
        $database = new BaseModel();
        $sql = 'select vaitro from thamgialophoc where MaLopHoc = ? and username = ?';
        $param = array('ss', &$_SESSION['ClassCode'],&$_SESSION['username']);
        $data = $database->query_prepared($sql, $param);
        $role = $data['data'][0]['vaitro'];
    }
    if($role === 2){
        $_SESSION['ClassRole'] = 'teacher';
    }
    elseif ($role === 3){
        $_SESSION['ClassRole'] = 'student';
    }
    $database = new BaseModel();
    $sql = 'select Ho,Ten,userIMG from account where username = ?';
    $param = array('s', &$classInfor['NguoiTao']);
    $data = $database->query_prepared($sql, $param);
    $_SESSION['CreatorIMG']=$data['data'][0]['userIMG'];
    $_SESSION['Creator']= $data['data'][0]['Ho'].' '.$data['data'][0]['Ten'];
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-header">
                <div class="btn-header" id="btn-header">
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="main-header-info">
                    <h2 class="main-heading"><?php echo $classInfor['TenLopHoc'] ?></h2>
                    <div class="class-teacher-name"><?php echo $_SESSION['Creator'] ?></div>
                    <div class="class-teacher-name d-flex" >Mã lớp học:<div class="ml-2" id="copyMe"><?php echo $classInfor['MaLopHoc']?></div>
                        <button class="ml-2 copy-btn" onclick="copyMyText()"><i class="far fa-clone"></i></button></div>

                </div>

                <div class="more-info-of-class" id="more-info-of-class">
                    <p><b>Phòng</b> <?php echo $classInfor['PhongHoc'] ?></p>
                    <p><b>Môn học</b> <?php echo $classInfor['MonHoc'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 notices">
            <div class="notices-important">
                <h3 class="notice-title">Sắp đến hạn</h3>
                <div class="main-notice">
                    <p>Tuyệt với không có việc làm</p>
                    <a href="#">
                        Xem tất cả
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="main-contents">
                <div class="share-content" id="share-content" >
                    <div class="section1">
                        <div class="section-img">
                            <img src="../<?php echo $user_infor['userIMG']; ?>" alt="img">
                        </div>
                        <div class="content-note">Chia sẻ vài điều với lớp học</div>
                    </div>
                    <!-- <div class="section2" ">
                        <i class="fas fa-exchange-alt"></i>
                    </div> -->
                </div>
                <div class="section-partition border border-primary rounded" id="section-partition">
                    <div class="partition-main">
                        <p class="share-something-notice">Chia sẻ với lớp học của bạn</p>
                        <textarea class="bg-light share-something border" name="share-something"></textarea>
                    </div>
                    <div class="partition-attach">
                        <div class="btn-attach">
                            <button class="btn btn-do-task" id="add"><i class="fas fa-paperclip"></i> Thêm</button>
                        </div>
                        <div class="btn-task">
                            <button class="btn btn-do-task btn-light" id="cancel">Hủy bỏ</button>
                            <button class=" btn btn-primary" id="ost">Đăng bài</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="exchange-content">
                <ul class="list-content">
                    <li>
                        <div class="main-task-content">
                            <div class="main1">
                                <div class="section-img">
                                    <img src="../<?php echo $user_infor['userIMG']; ?>" alt="img">
                                </div>
                                <h4 class="user-name">Nguyễn Thành Luân</h4>
                                <div class="dropup">
                                    <button type="button" class="btn bar-item" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <?php if($_SESSION['ClassRole']!=='student')
                                    {
                                        ?>
                                    <div class="dropdown-menu " id="action-with-item">
                                        <a class="dropdown-item" href="#">Chỉnh sửa</a>
                                        <a class="dropdown-item" href="#">Xóa</a>
                                    </div>
                                    <?php
                                    }
                                        ?>
                                </div>
                            </div>
                            <div class="content-chat">
                                <p>Anh không làm gì đâu</p>
                            </div>
                            <div class="main2">
                                <div class="section-img">
                                    <img src="../<?php echo $user_infor['userIMG']; ?>" alt="img">
                                </div>
                                <div class="input-content-chat">
                                    <input type="text" placeholder="Thêm bình luận">
                                    <div class="btn-input">
                                        <i class="fas fa-paper-plane"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="main-task-content">
                        <div class="main1">
                            <div class="section-icon">
                                <div class="section-icon-todo-list">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                            </div>
                            <h4 class="user-name"><span class="poster">Nguyễn Thành Luân</span> đã đăng bài mới: <span class="title">Lab 8</span></h4>
                            <div class="dropup">
                                <button type="button" class="btn bar-item" data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <?php if($_SESSION['ClassRole']!=='student')
                                {
                                    ?>
                                    <div class="dropdown-menu " id="action-with-item">
                                        <a class="dropdown-item" href="#">Chỉnh sửa</a>
                                        <a class="dropdown-item" href="#">Xóa</a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>