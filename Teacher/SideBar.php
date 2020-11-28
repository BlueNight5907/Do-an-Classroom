<input class="nav__input" type="checkbox" id="nav-item-check">

<label for="nav-item-check" class="nav__overlay"></label>
<div class="side-nav-category">
    <div class="user__account-link">
        <div class="user__account">
            <div class="account__img">
                <img src="../<?php echo $_SESSION['userIMG'] ?>" alt="account img">
            </div>
            <div class="account__infos">
                <h3 class="account__name"><?php echo $user_infor['Ho'].' '.$user_infor['Ten']; ?></h3>
                <span class="account__gmail"><?php echo $user_infor['email']; ?></span>
            </div>
        </div>
    </div>
    <div class="tab__task">
        <ul class="tab-list">
            <li class="tab_item mb-1">
                <a href="Home.php" class="tab_link sidebar-bg-custom">Lớp học</a>
            </li>
            <li class="tab_item mb1">
                <a href="" class="tab_link sidebar-bg-custom">Lịch</a>
            </li>
        </ul>
    </div>
    <div class="sidebar-tab">
        <h3 class="text-primary">Tham gia</h3>
        <ul class="sidebar-list">
            <li class="sidebar-item sidebar-bg-custom">
                <a href="" class="sidebar-link">
                    <div class="sidebar-link-item">
                        <h5 class="sidebar-class-name">HK1_2020_504008_Cấu trúc dữ liệu và giải thuật_N3</h5>
                        <div class="sidebar-teacher-name">Trần Hồ Lệ Phương Đan</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="line"></div>
    <div class="sidebar-tab">
        <ul class="sidebar-list">
            <h3 class="text-primary">Dạy học</h3>
            <li class="sidebar-item sidebar-bg-custom">
                <a href="" class="sidebar-link">
                    <div class="sidebar-link-item">
                        <h5 class="sidebar-class-name">HK1_2020_504008_Cấu trúc dữ liệu và giải thuật_N3</h5>
                        <div class="sidebar-teacher-name">Trần Hồ Lệ Phương Đan</div>
                    </div>
                </a>
            </li>

        </ul>
    </div>
</div>
