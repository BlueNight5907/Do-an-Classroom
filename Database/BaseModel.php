    <?php
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    // Instantiation and passing `true` enables exceptions
    // Load Composer's autoloader
    class BaseModel {
        private $db;
        function __construct() {
            $this->db = Database::open();
        }
        function generateRandomString($length = 64) {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        }

        // protected để chỉ lớp con truy xuất được
        function query($sql) {
            $result = $this->db->query($sql); // thiếu ->db
            if (!$result) {
                return array('code' => 1, 'error' => $this->db->error);
            }

            $data = array();
            while ($item = $result->fetch_assoc()) {
                array_push($data, $item);
            }
            return array('code' => 0, 'data' => $data);
        }

        function query_prepared($sql, $param) {
            $stm = $this->db->prepare($sql);
            call_user_func_array(array($stm, 'bind_param'), $param);
            if (!$stm->execute()) {
                return array('code' => 1, 'error' => $this->db->error);
            }

            $result = $stm->get_result();

            // hiện tại chỉ mới đọc 1 items, cần dùng
            // vòng lặp để đọc tất cả
            $data = array();
            if($result === true){
                return array('code' => 0, 'data' => 'success');
            }
            elseif($result === false){
                return array('code' => 0, 'data' => 'failed');
            }
            while ($item = $result->fetch_assoc()) {
                array_push($data, $item);
            }
            return array('code' => 0, 'data' => $data);
        }
        function is_exists($sql, $param){
            $stm = $this->db->prepare($sql);
            call_user_func_array(array($stm, 'bind_param'), $param);
            if (!$stm->execute()) {
                die('Query error: '.$stm->error);
            }
            $result = $stm->get_result();
            $count = $result->fetch_assoc()['count(*)'];
            if($count > 0)
                return true;
            else
                return false;
        }
        function remove_class($classID){
            $sql= "update lophoc set activated = b'0' where MaLopHoc = ?";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$classID);
            if(!$stm->execute()){
                return false;
            }
            return true;
        }
        function query_prepared_nonquery($sql, $param) {
            $stm = $this->db->prepare($sql);
            call_user_func_array(array($stm, 'bind_param'), $param);
            if (!$stm->execute()) {
                return array('code' => 1, 'error' => $this->db->error);
            }
            return array('code' => 0, 'data' => 'success');
        }
        function send_activation_email($email,$token){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0; //0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();
                $mail->CharSet = "UTF-8"; // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webprojectclassroom@gmail.com';                     // SMTP username
                $mail->Password   = 'tepnkvzgwljzcayy';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('webprojectclassroom@gmail.com', 'Classroom');
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Xác minh tài khoản của bạn';
                $mail->Body    = "Click <a href='http://localhost/Activate.php?email=$email&token=$token'>vào đây</a> để xác minh tài khoản của bạn";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        function is_email_exists($email){
            $sql = 'select username from account where email = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$email);
            if(!$stm->execute()){
                die('Query error: '.$stm->error);
            }
            $result = $stm->get_result();
            if($result->num_rows > 0){
                return true;
            }else
                return false;
        }
        function updateClassRoom($classname,$subject,$classroom,$img,$IDClass){
            $sql = "update lophoc set TenLopHoc = ? , MonHoc = ? , PhongHoc = ? , AnhDaiDien = ? where MaLopHoc = ?";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('sssss',$classname,$subject,$classroom,$img,$IDClass);
            $stm->execute();
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            return array('code'=>0,'success'=>$stm);
        }

        //Mời giáo viên
        function invite_teacher($sender,$email,$ClassID){
            //Xét điều kiện lớp học có tồn tại trong hệ thống hay không,nếu có thì lưu vào biến ClassName
            $sql = "select TenLopHoc from lophoc where MaLopHoc = ? and activated = b'1'";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$ClassID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if($data == array()){
                return array('code'=>1,'error'=>'Lớp học không tồn tại');
            }
            $ClassName = $data['TenLopHoc'];
            //Xét điều kiện người dùng có tồn tại trong hệ thống hay không hoặc có phải là học sinh không
            $sql = 'select account.username,vaitro from account inner join phanquyen on account.username = phanquyen.username where email = ? ';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$email);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if(empty($data) || $data['vaitro'] == 3){
                return array('code'=>1,'error'=>'Không thể thêm người dùng');
            }
            //kiểm tra xem người dùng đã tồn tại trong lớp học chưa
            $user = $data['username'];
            $sql = "select count(*),vaitro,activated from thamgialophoc where username = ? and MaLopHoc = ?";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$user,$ClassID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            //Trường hợp chưa, ta tiến hành thêm vào ở trạng thái chưa kích hoạt, nếu rồi thì thôi

            if($data['count(*)'] == 0){
                //ta thêm tài khoản vào bảng thamgialophoc
                $id = $this->generateRandomString();
                $sql = "insert into thamgialophoc values(?,?,?,2,b'0')";
                $stm = $this->db->prepare($sql);
                $stm->bind_param('sss',$id,$ClassID,$user);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }elseif ($data['vaitro'] == 3 || $data['activated']===1){
                return array('code'=>2,'error'=>'Không thể thêm người dùng');
            }

            ////Thêm trường hợp cần gửi thư mời vào bảng
            $token = md5($email.'+'.random_int(1000,2000));
            $sql = 'update attend_class_token set token = ? where username = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$token,$user);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }

            if($stm->affected_rows == 0){
                $exp = time() + 3600*24*10;//hết hạn sau 10 ngày
                $sql = 'insert into attend_class_token values(?,?,?,?)';
                $stm = $this->db->prepare($sql);
                $stm->bind_param('sssi',$user,$ClassID,$token,$exp);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }
            return $this->send_invite_email($sender,$email,$user,$ClassID,$token,$ClassName,'Giáo viên');
        }


        //Mời học sinh
        function invite_student($sender,$email,$ClassID){
            //Xét điều kiện lớp học có tồn tại trong hệ thống hay không,nếu có thì lưu vào biến ClassName
            $sql = "select TenLopHoc from lophoc where MaLopHoc = ? and activated = b'1'";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$ClassID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if($data == array()){
                return array('code'=>1,'error'=>'Lớp học không tồn tại');
            }
            $ClassName = $data['TenLopHoc'];

            //Xét điều kiện người dùng có tồn tại trong hệ thống hay không
            $sql = 'select account.username,vaitro from account inner join phanquyen on account.username = phanquyen.username where email = ? ';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$email);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if(empty($data)){
                return array('code'=>1,'error'=>'Không thể thêm người dùng');
            }
            //kiểm tra xem người dùng đã tồn tại trong lớp học chưa
            $user = $data['username'];
            $sql = "select count(*),vaitro from thamgialophoc where username = ? and MaLopHoc = ?";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$user,$ClassID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();

            //Trường hợp chưa, ta tiến hành thêm vào ở trạng thái chưa kích hoạt nếu rồi mà đang là một giáo viên thì không tiến hành thêm vào
            if($data['count(*)'] === 0){
                //ta thêm tài khoản vào bảng thamgialophoc
                $id = $this->generateRandomString();
                $sql = "insert into thamgialophoc values(?,?,?,3,b'0')";
                $stm = $this->db->prepare($sql);
                $stm->bind_param('sss',$id,$ClassID,$user);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }else if($data['vaitro']!==3)
                return array('code'=>1,'error'=>'Không thể thêm người dùng');

            //Thêm trường hợp cần gửi thư mời vào bảng
            $token = md5($email.'+'.random_int(1000,2000));
            $sql = 'update attend_class_token set token = ? where username = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$token,$user);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            if($stm->affected_rows == 0){
                $exp = time() + 3600*24*10;//hết hạn sau 10 ngày
                $sql = 'insert into attend_class_token values(?,?,?,?)';
                $stm = $this->db->prepare($sql);
                $stm->bind_param('sssi',$user,$ClassID,$token,$exp);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }
            return $this->send_invite_email($sender,$email,$user,$ClassID,$token,$ClassName,'Sinh viên');
        }

        function student_attend_class_by_code($username,$fullname,$classID){
            $teacheremail = '';
            $className = '';
            //Kiem tra xem lop hoc co ton tai khong, neu co thi lay ra email cua giao vien
            $sql = "select account.email,TenLopHoc from lophoc inner join account on account.username = lophoc.NguoiTao where MaLopHoc = ? and lophoc.activated = b'1'";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$classID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if($data == array()){
                return array('code'=>1,'error'=>'Lớp học không tồn tại');
            }
            else{
                $teacheremail = $data['email'];
                $className = $data['TenLopHoc'];
            }
            //kiem tra xem sinh viên đó đã tồn tại trong lóp học đó chưa

            $sql = "select * from thamgialophoc where MaLopHoc = ? and username = ?";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$classID,$username);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if($data != array()){
                return array('code'=>1,'error'=>'Người dùng đã tồn tại trong lớp học');
            }


            //Kiem tra xem sinh vien da gui yeu cau tham gia lop hoc chua neu chua thi tao moi
            $sql = 'select * from xetsvthamgialophoc where username = ? and MaLopHoc = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$username,$classID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            if($data == array()){
                $ID = $this->generateRandomString();
                $sql = 'insert into xetsvthamgialophoc values(?,?,?)';
                $stm = $this->db->prepare($sql);
                $stm->bind_param('sss',$ID,$username,$classID);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }

            $mail_state = $this->send_announce_email($teacheremail,$fullname,$className);
            if($mail_state == true)
                return array('code'=>0,'success'=>'all success');
            else
                return array('code'=>2,'error'=>'Can not send email');
        }
        //Xac nhan de sinh vien tham gia lop bang code
        function confirm_student_attend($ID,$action){
            $sql = 'select username,MaLopHoc from xetsvthamgialophoc where ID = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$ID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $result = $stm->get_result();
            $data = $result->fetch_assoc();
            $username = $data['username'];
            $classID = $data['MaLopHoc'];
            if($action === 'accept'){
                $JoinID = $this->generateRandomString();
                $role = 3;
                $sql = "insert into thamgialophoc values(?,?,?,?,b'1')";
                $stm = $this->db->prepare($sql);
                $stm->bind_param('sssi',$JoinID,$classID,$username,$role);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }
            //Xoa sinh vien do khoi bang xetsvthamgialophoc
            $sql = "delete from xetsvthamgialophoc where ID = ?";
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$ID);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            else
                return array('code'=>0,'success'=>'All success');
        }
        //Thay đổi vai trò người dùng
        function change_permission($username,$role){
            $sql = 'update phanquyen set vaitro = ? where username = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('is',$role,$username);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            else if($stm->affected_rows == 0){
                print_r($stm);
                return array('code'=>1,'error'=>'Người dùng đã được phân quyền rồi');
            }
            return array('code'=>0,'success'=>'All success');
        }
        //Hàm để reset pass
        function reset_password($email){
            if(!$this->is_email_exists($email)){
                return array('code'=>1,'error'=>'Email không tồn tại');
            }
            $token = md5($email.'+'.random_int(1000,2000));
            $sql = 'update reset_token set token = ? where email = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('ss',$token,$email);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            if($stm->affected_rows == 0){
                $exp = time() + 3600*24;//hết hạn sau 24h
                $sql = 'insert into reset_token values(?,?,?)';
                $stm = $this->db->prepare($sql);
                $stm->bind_param('ssi',$email,$token,$exp);
                if(!$stm->execute()){
                    return array('code'=>2,'error'=>'Can not execute command');
                }
            }
            //Gửi email reset tài khoản
            $success = $this->send_resetpassword_email($email,$token);
            return array('code'=>0,'success'=>$success);
            //Chèn thành công hoặc update thành công token
        }
        function send_resetpassword_email($email,$token){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0; //0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();
                $mail->CharSet = "UTF-8"; // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webprojectclassroom@gmail.com';                     // SMTP username
                $mail->Password   = 'tepnkvzgwljzcayy';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('webprojectclassroom@gmail.com', 'Classroom');
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Khôi phục mật khẩu của bạn';
                $mail->Body    = "Click <a href='http://localhost/ResetPassword.php?email=$email&token=$token'>vào đây</a> để khôi phục mật khẩu của bạn";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        //------------Email chấp nhận tham gia lớp học
        function send_invite_email($sender,$email,$user,$classID,$token,$className,$role){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0; //0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();
                $mail->CharSet = "UTF-8"; // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webprojectclassroom@gmail.com';                     // SMTP username
                $mail->Password   = 'tepnkvzgwljzcayy';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('webprojectclassroom@gmail.com', $sender);
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Lời mời tham gia lớp học';
                $mail->Body    = "Bạn được mời tham gia vào lớp học <a href='http://localhost/AcceptInvite.php?user=$user&classID=$classID&token=$token'>$className</a> với vai trò $role";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        function send_announce_email($email,$studentfullname,$className){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0; //0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();
                $mail->CharSet = "UTF-8"; // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webprojectclassroom@gmail.com';                     // SMTP username
                $mail->Password   = 'tepnkvzgwljzcayy';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('webprojectclassroom@gmail.com', 'Hệ thống');
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Thông báo có sinh viên tham gia lớp học';
                $mail->Body    = "Sinh viên <span style='color:red'>$studentfullname</span> vừa có có yêu cầu tham gia lớp học $className của bạn";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        function get_all_user(){
            $sql = "select userIMG, CONCAT(Ho,' ',Ten) as HoTen, account.username , email, vaitro from account inner join phanquyen on account.username = phanquyen.username";
            return $this->query($sql);
        }
        function classAnounce($username,$classCode){
            $sql = 'select email from account where username = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$username);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $data = $stm->get_result()->fetch_assoc();
            $email = $data['email'];
            $sql = 'select TenLopHoc from lophoc where MaLopHoc = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$classCode);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $data = $stm->get_result()->fetch_assoc();
            $className = $data['TenLopHoc'];
            $this->announce_cofirm_attend_class_email($email,$className);

        }
        function permissionAnounce($username){
            $sql = 'select email,vaitro from account inner join phanquyen on account.username = phanquyen.username where account.username = ?';
            $stm = $this->db->prepare($sql);
            $stm->bind_param('s',$username);
            if(!$stm->execute()){
                return array('code'=>2,'error'=>'Can not execute command');
            }
            $data = $stm->get_result()->fetch_assoc();
            $email = $data['email'];
            $role = "Admin";
            if($data['vaitro']==2){
                $role = "Giáo viên";
            }else if($data['vaitro']==3){
                $role = "Học sinh";
            }
            $this->announce_change_permission_email($email,$role);

        }
        function announce_change_permission_email($email,$role){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0; //0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();
                $mail->CharSet = "UTF-8"; // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webprojectclassroom@gmail.com';                     // SMTP username
                $mail->Password   = 'tepnkvzgwljzcayy';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('webprojectclassroom@gmail.com', 'Hệ thống');
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Thông báo thay đổi vai trò của tài khoản';
                $mail->Body    = "Bạn đã được thay đổi vai trò thành <span style='color:red'>$role</span>";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        function announce_cofirm_attend_class_email($email,$className){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0; //0 = off (for production use, No debug messages) debugging: 1 = errors and messages, 2 = messages only
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();
                $mail->CharSet = "UTF-8"; // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'webprojectclassroom@gmail.com';                     // SMTP username
                $mail->Password   = 'tepnkvzgwljzcayy';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('webprojectclassroom@gmail.com', 'Hệ thống');
                $mail->addAddress($email, 'Người nhận');     // Add a recipient
                /*
                $mail->addAddress('ellen@example.com');               // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');
                */

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Thông báo';
                $mail->Body    = "Bạn được xác nhận tham gia lớp học <span style='color:red'>$className</span>";
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                return true;
            } catch (Exception $e) {
                return false;
            }
        }


    }