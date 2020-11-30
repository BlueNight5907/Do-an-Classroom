<div class="row">
    <?php
    foreach ($ClassInfor as &$Class) {
    ?>
        <div class="col-xs-12 p-1">
            <div class="class-room">
                <div class="room-top" <?php if(!empty($Class['AnhDaiDien'])) { ?>
                     style="background-image: url(../<?php echo $Class['AnhDaiDien']?>)"
                    <?php } ?>
                >
                    <a href="./ClassView.php?Classroom=<?php print_r($Class['MaLopHoc']) ?>" class="room-info">
                        <h4 class="class-name"><?php echo $Class['TenLopHoc'] ?></h4>
                        <div class="subject"><?php echo $Class['MonHoc']?></div>
                    </a>
                    <div class="task">
                        <i class="fas fa-ellipsis-v"></i>
                        <div class="active">
                            <ul class="option">
                                <li>Move</li>
                                <li>Unenroll</li>
                            </ul>
                        </div>
                    </div>
                    <span class="teacher-name"><?php
                        $database = new BaseModel();
                        $sql = 'select userIMG,Ho,Ten from account where username =?';
                        $param = array('s', &$Class['NguoiTao']);
                        $data = $database->query_prepared($sql, $param);
                        $CreatorInfor = $data['data'][0];
                        if($Class['NguoiTao']!==$Class['username'])
                        echo $CreatorInfor['Ho'].' '.$CreatorInfor['Ten'];?></span>
                </div>
                <div class="room-mid">
                    <img class="avatar"src="
                    ../<?php
                    echo $CreatorInfor['userIMG'];
                    ?>" alt="user-avatar">
                </div>
                <div class="room-bot">
                    <div class="document">
                        <span class="bag"><i class="fas fa-briefcase"></i></span>
                        <span class="file"><i class="far fa-folder"></i></span>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    // $arr is now array(2, 4, 6, 8)
    unset($Class); // break the reference with the last element
    ?>

</div>