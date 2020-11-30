<?php
$database = new BaseModel();
$sql = "select JoinClassID,account.username,Ho,Ten,vaitro,userIMG from thamgialophoc inner join account on  thamgialophoc.username = account.username where thamgialophoc.MaLopHoc = ? and thamgialophoc.activated = b'1' ";
$param = array('s', &$_SESSION['ClassCode']);
$data = $database->query_prepared($sql, $param);
$peopleInfor = null;
if($data['code']===0)
    if($data['data']!==array()){
        $peopleInfor = $data['data'];
    }
$Teachers=array();
$Students=array();
foreach ($peopleInfor as &$someone) {
    if($someone['vaitro']===2){
        array_push($Teachers, $someone);
    }
    elseif($someone['vaitro']===3){
        array_push($Students, $someone);
    }
}
print_r($Teachers);
echo '</br>';
print_r($Students);
?>
<div class="container">
		<!--Danh sách giáo viên-->
		<div class="row">
			<div class="teacher-list col-12 p-0">
				<div class="people-list">
					<div class="people-list-header">
						<h2 class="text-primary">Giáo viên</h2>
                        <?php if($_SESSION['ClassRole']!=='student'){
                           ?>
                            <span>
                            <button type="button" class="btn btn-icon btn-light btn-outline-primary" id="btn-add-teacher" data-toggle="modal" data-target="#add-teacher-modal">
                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-plus" fill="currentColor">
                                  <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </button>
                        </span>

                        <?php
                        }
                        ?>
					</div>
					<!--Danh sách người dùng-->
					<div class="people-list-content table-responsive">
						<table class="table table-hover">
							<tbody>
							<tr>
								<td>
									<div class="main1">
										<div class="section-img">
											<img src="../<?php echo $_SESSION['CreatorIMG'] ?>" alt="img">
										</div>
										<h4 class="user-name"><?php echo $_SESSION['Creator']?></h4>
									</div>
								</td>
								<td>

								</td>
							</tr>
                            <?php
                            foreach ($Teachers as &$Teacher) {
                            ?>
                            <tr>
                                <td>
                                    <div class="main1">
                                        <div class="section-img">
                                            <img src="..\<?php echo $Teacher['userIMG'] ?>" alt="img">
                                        </div>
                                        <h4 class="user-name"><?php echo $Teacher['Ho'].' '.$Teacher['Ten'] ?></h4>
                                    </div>
                                </td>

                                <td>
                                    <?php
                                    if($_SESSION['ClassRole']==='creator'){
                                        ?>
                                        <div class="btn-group d-flex justify-content-center <?php echo $Teacher['JoinClassID']?>">
                                            <span class="mr-2">
                                                <button type="button" class="btn btn-icon btn-light btn-outline-primary btn-send-email-teacher">
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                                                    </svg>
                                                </button>
                                            </span>
                                                    <span class="mr-2">
                                                <button type="button" class="btn btn-icon btn-light btn-outline-primary btn-remove-people btn-remove-teacher" data-toggle="modal" data-target="#confirm-remove-people-Modal">
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-dash" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                       <?php
                                    }
                                    ?>

                                </td>
                            </tr>
                            <?php
                            }
                            unset($Teacher);
                            ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--Danh sách sinh viên-->
		<div class="row">
			<div class="student-list col-12 p-0">
				<div class="people-list">
					<div class="people-list-header">
						<h2 class="text-primary">Học sinh</h2>
						<span>
						<inline class="mr-3 h6"><?php echo count($Students) ?> học sinh</inline>
                         <?php if($_SESSION['ClassRole']!=='student'){
                         ?>
                            <button type="button" class="btn btn-icon btn-light btn-outline-primary" id="btn-add-student" data-toggle="modal" data-target="#add-student-modal">
                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-plus" fill="currentColor">
                                  <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </button>
                            <?php
                         }
                            ?>
					</span>
					</div>
					<!--Danh sách người dùng-->
					<div class="people-list-content table-responsive">
						<table class="table table-hover">
							<tbody>
                            <?php
                            foreach ($Students as &$Student){
                            ?>
                                <tr>
                                    <td>
                                        <div class="main1">
                                            <div class="section-img">
                                                <img src="..\<?php echo $Student['userIMG'] ?>" alt="img">
                                            </div>
                                            <h4 class="user-name"><?php echo $Student['Ho'].' '.$Student['Ten'] ?></h4>
                                        </div>
                                    </td>

                                    <td>
                                    <?php
                                    if($_SESSION['ClassRole']==='teacher'||$_SESSION['ClassRole']==='creator'){
                                    ?>
                                        <div class="btn-group d-flex justify-content-center <?php echo $Student['JoinClassID'] ?>">
                                            <span class="mr-2">
                                                <button type="button" class="btn btn-icon btn-light btn-outline-primary btn-send-email-student">
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                                                    </svg>
                                                </button>
                                            </span>
                                                    <span class="mr-2">
                                                <button type="button" class="btn btn-icon btn-light btn-outline-primary btn-remove-people btn-remove-student" data-toggle="modal" data-target="#confirm-remove-people-Modal">
                                                    <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-dash" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                </button>
                                            </span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            unset($Student);
                            ?>


							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!----------------------------------------------------------------------------------------->
	<!-- Thông báo muốn xóa người dùng hay không-->
	<div class="modal fade" id="confirm-remove-people-Modal">
		<div class="modal-dialog modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Xóa người tham gia</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					Bạn có chắc xóa người này ra khỏi nhóm
				</div>

				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="accept_remove_people btn btn-danger" data-dismiss="modal">Chắc chắn</button>
					<button type="button" class="refuse_remove_people btn btn-secondary" data-dismiss="modal">Đóng</button>
				</div>

			</div>
		</div>
	</div>
    <!-- Modal thêm sinh viên-->
    <div class="modal fade" id="add-student-modal">
        <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm sinh viên</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Moda3 body -->
                <div class="modal-body">
                    <h5>Thêm sinh viên bằng email</h5>
                    <form class="mt-2 form-inline" method='post'>
                        <input type="email" class=" mt-2 form-control" id="email" placeholder="Nhập Email" name="studentemail">
                        <button type="submit" class="ml-4 mt-2 btn btn-outline-primary" id="add-student-by-email">Thêm</button>
                    </form>
                </div>
                <div class="modal-body">
                    <h5>Xác nhận sinh viên tham gia lớp học</h5>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <div class="main1">
                                    <div class="section-img">
                                        <img src="../Public/img/user.png" alt="img">
                                    </div>
                                    <h4 class="user-name">Nguyễn Văn Huy</h4>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group d-flex justify-content-center">
                                    <!-- Nút xóa-->
                                    <span class="mr-2">
                                            <button type="button" class="btn btn-icon btn-light btn-outline-primary btn-remove-people btn-removing-student" data-toggle="modal" data-target="#">
                                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-dash">
                                                  <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                </svg>
                                            </button>
                                        </span>
                                    <!-- Nút thêm-->
                                    <span class="mr-2">
                                            <button type="button" class="btn btn-icon btn-light btn-outline-primary btn-adding-student" data-target="#">
                                                <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-plus" fill="currentColor">
                                                  <path fill-rule="evenodd" d="M8 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6 5c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10zM13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                                </svg>
                                            </button>
                                        </span>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal thêm giáo viên-->
    <div class="modal fade" id="add-teacher-modal">
        <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm giảng viên</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Moda3 body -->
                <div class="modal-body">
                    <h5>Thêm giáo viên bằng email</h5>
                    <form class="mt-2 form-inline" method='post'>
                        <input type="email" class=" mt-2 form-control" id="email" placeholder="Nhập Email" name="teacheremail">
                        <button type="submit" id="add-teacher-by-email" class="ml-4 mt-2 btn btn-outline-primary">Thêm</button>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>





</div>