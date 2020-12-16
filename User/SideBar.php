
<input class="nav__input" type="checkbox" id="nav-item-check">

<label for="nav-item-check" class="nav__overlay"></label>
<div class="side-nav-category">
    <div class="user__account-link">
        <div class="user__account">
            <div class="account__img">
                <img src="../<?php echo $_SESSION['userIMG'] ?>" alt="account img">
            </div>
            <div class="account__infos">
                <h3 class="account__name"><?php echo $user_infor['Ho'].' '.$user_infor['Ten'];
                    if($_SESSION['role']===1) {
                        echo '(Admin)';
                    }
                    ?></h3>
                <span class="account__gmail"><?php echo $user_infor['email']; ?></span>
            </div>
        </div>
    </div>
    <div class="tab__task">
        <ul class="tab-list">
            <li class="tab_item mb-1">
                <a href="Home.php" class="tab_link sidebar-bg-custom">Home</a>
            </li>
            <li class="tab_item mb1">
                <a href="" class="tab_link sidebar-bg-custom">Công việc</a>
            </li>
        </ul>
    </div>
    <div class="sidebar-tab">
        <h3 class="text-primary">Lớp học</h3>
        <ul class="sidebar-list">
        <?php
        if(isset($_SESSION['allclass'])){
            foreach ($_SESSION['allclass'] as $class){
            ?>
            <li class="sidebar-item sidebar-bg-custom">
                <a href="ClassView.php?Classroom=<?php echo $class['MaLopHoc'] ?>" class="sidebar-link">
                    <div class="sidebar-link-item">
                        <h5 class="sidebar-class-name"><?php echo $class['TenLopHoc'] ?></h5>
                        <div class="sidebar-teacher-name"><?php
                            $database = new BaseModel();
                            $sql = 'select userIMG,Ho,Ten from account where username =?';
                            $param = array('s', &$class['NguoiTao']);
                            $data = $database->query_prepared($sql, $param);
                            $CreatorInfor = $data['data'][0];
                            if($class['NguoiTao']!==$_SESSION['username'])
                                echo $CreatorInfor['Ho'].' '.$CreatorInfor['Ten'];
                        ?></div>
                    </div>
                </a>
            </li>
            <?php
            }
        }
        ?>
        </ul>
    </div>
    <div class="line"></div>
</div>
