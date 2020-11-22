<?php
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    require_once('db.php');
    require_once('phpmailer/vendor/autoload.php');
    require_once('randomLib.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    function smtpDefaultInfo()
    {
        global $mail, $maychuSMTP, $diachiSMTP, $matkhauSMTP, $congSMTP, $tenngguiSMTP;
        try {
            //Server settings
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $maychuSMTP;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $diachiSMTP;                     // SMTP username
            $mail->Password   = $matkhauSMTP;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $congSMTP;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom($diachiSMTP, $tenngguiSMTP);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    $adminEmail = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'email', 'id', 1);

    function sendTestEmail($receiver = '',$subject = 'Test Subject', $body = 'Test message with <b>Bold text</b>', $bodyNoHTML = 'Test message without HTML codes')
    {
        smtpDefaultInfo();
        global $mail, $adminEmail;
        try {
            if ($receiver=='') {
                $mail->addAddress($adminEmail);
            } else {
                $mail->addAddress($receiver);     // Add a recipient
            }
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = $bodyNoHTML;
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function sendNotifyEmailVerify($ngNhan, $ten = '')
    {
        smtpDefaultInfo();
        global $mail, $generatorLow, $tenngguiSMTP, $db, $url;
        try {
            $token = $generatorLow->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
            // thêm vào db
            if ($db->getSingleData(DB_TABLE_PREFIX.'xacminhnhanthongbao', 'COUNT(*)', 'email', $ngNhan) > 0) {

                $db->updateADataRow(DB_TABLE_PREFIX.'xacminhnhanthongbao', 'token', $token, 'email', $ngNhan);

            } else {
                $db->insertMulDataRow(DB_TABLE_PREFIX.'xacminhnhanthongbao', array(
                    'email',
                    'token'
                ), array(
                    $ngNhan,
                    $token
                ));
            }

            $mail->addAddress($ngNhan);     // Add a recipient

            $urlXacNhan = $url."/thongbao/?token=$token&ten=$ten";

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "[$tenngguiSMTP] Xác nhận địa chỉ email để nhận thông báo";
            $mail->Body    = "<p>Xin chào, $ten</p>
            <p>Chúng tôi nhận được yêu cầu nhận thông báo trên $tenngguiSMTP có thể là từ bạn,
            Nếu bạn đồng ý nhận thông báo, hãy truy cập liên kết bên dưới để xác nhận.</p>
            <p><b>Nếu không phải bạn yêu cầu, hãy bỏ qua email này!</b></p>
            <br>
            <a href='$urlXacNhan' target='_blank'>$urlXacNhan</a>
            <br><br>
            ===<br>
            Trân trọng,<br>
            $tenngguiSMTP";
            $mail->AltBody = "Xin chào, $ten
            Chúng tôi nhận được yêu cầu nhận thông báo trên $tenngguiSMTP có thể là từ bạn,
            Nếu bạn đồng ý nhận thông báo, hãy truy cập liên kết bên dưới để xác nhận.
            Nếu không phải bạn yêu cầu, hãy bỏ qua email này!
            
            $urlXacNhan

            ===
            Trân trọng,
            $tenngguiSMTP";
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function sendNotifyEmail($dsNguoiNhan, $tieude, $noidung)
    {
        smtpDefaultInfo();
        global $mail, $tenngguiSMTP, $adminEmail;
        try {

            if (count($dsNguoiNhan)==0) {
                $mail->addBCC($adminEmail);
            } else {
                foreach ($dsNguoiNhan as $email) {
                    $mail->addBCC($email);
                }
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "[$tenngguiSMTP] $tieude";
            $mail->Body    = "<br>
            
            $noidung
            
            ===<br>
            Trân trọng,<br>
            $tenngguiSMTP";
            $mail->AltBody = "<br>

            ".strip_tags($noidung)."

            ===
            Trân trọng,
            $tenngguiSMTP";
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
    function sendPasswordResetLink($nguoiNhan, $username)
    {
        smtpDefaultInfo();
        global $mail, $tenngguiSMTP, $generatorLow, $url, $db;
        try {

            $token = $generatorLow->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');

            // thêm vào db
            if ($db->getSingleData(DB_TABLE_PREFIX.'xacminhdoimatkhau', 'COUNT(*)', 'tendangnhap', $username) > 0) {

                $db->updateADataRow(DB_TABLE_PREFIX.'xacminhdoimatkhau', 'token', $token, 'tendangnhap', $username);

            } else {
                $db->insertMulDataRow(DB_TABLE_PREFIX.'xacminhdoimatkhau', array(
                    'tendangnhap',
                    'token'
                ), array(
                    $username,
                    $token
                ));
            }

            $urlXacNhan = $url."/doimatkhau?token=$token";

            $mail->addAddress($nguoiNhan);
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "[$tenngguiSMTP] Đổi mật khẩu";
            $mail->Body    = "<p>Xin chào $username,</p>

            <p>Chúng tôi có nhận được yêu cầu đổi mật khẩu tài khoản của bạn trên hệ thống $tenngguiSMTP,
            từ ai đó có thể là bạn. Để có thể đổi mật khẩu, bạn vui lòng truy cập theo liên kết bên dưới:</p>
            
            <a target='_blank' href='$urlXacNhan'>$urlXacNhan</a>

            <p><b>Lưu ý: nếu bạn không yêu cầu đổi mật khẩu, vui lòng không truy cập liên kết phía trên!</b></p>
            
            ===<br>
            Trân trọng,<br>
            $tenngguiSMTP";
            $mail->AltBody = "Xin chào $username,

            Chúng tôi có nhận được yêu cầu đổi mật khẩu tài khoản của bạn trên hệ thống $tenngguiSMTP,
            từ ai đó có thể là bạn. Để có thể đổi mật khẩu, bạn vui lòng truy cập theo liên kết bên dưới:

            $urlXacNhan

            ===
            Trân trọng,
            $tenngguiSMTP";
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


    function sendEmailResetVerify($ngNhan, $ten)
    {
        smtpDefaultInfo();
        global $mail, $generatorLow, $tenngguiSMTP, $db, $url;
        try {
            $token = $generatorLow->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
            // thêm vào db
            if ($db->getSingleData(DB_TABLE_PREFIX.'xacminhdoiemail', 'COUNT(*)', 'tendangnhap', $ten) > 0) {

                $db->updateMulDataRow(DB_TABLE_PREFIX.'xacminhdoiemail', array(
                    'email_new',
                    'token'
                ), array(
                    $ngNhan,
                    $token
                ), 'tendangnhap', $ten);

            } else {
                $db->insertMulDataRow(DB_TABLE_PREFIX.'xacminhdoiemail', array(
                    'tendangnhap',
                    'email_new',
                    'token'
                ), array(
                    $ten,
                    $ngNhan,
                    $token
                ));
            }

            $mail->addAddress($ngNhan);     // Add a recipient

            $urlXacNhan = $url."/trangcanhan/?token=$token";

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "[$tenngguiSMTP] Xác nhận đổi địa chỉ Email";
            $mail->Body    = "<p>Xin chào, $ten</p>
            <p>Chúng tôi vừa nhận được yêu cầu đổi địa chỉ email trên $tenngguiSMTP có thể là từ bạn,
            Nếu bạn muốn thay đổi địa chỉ email, hãy truy cập liên kết bên dưới để xác nhận.</p>
            <p><b>Nếu không phải bạn yêu cầu, hãy bỏ qua email này!</b></p>
            <br>
            <a href='$urlXacNhan' target='_blank'>$urlXacNhan</a>
            <br><br>
            ===<br>
            Trân trọng,<br>
            $tenngguiSMTP";
            $mail->AltBody = "Xin chào, $ten
            Chúng tôi vừa nhận được yêu cầu đổi địa chỉ email trên $tenngguiSMTP có thể là từ bạn,
            Nếu bạn muốn thay đổi địa chỉ email, hãy truy cập liên kết bên dưới để xác nhận.
            Nếu không phải bạn yêu cầu, hãy bỏ qua email này!
            
            $urlXacNhan

            ===
            Trân trọng,
            $tenngguiSMTP";
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    function sendEmailLogin($ngNhan, $ten)
    {
        smtpDefaultInfo();
        global $mail, $tenngguiSMTP, $url, $generatorLow, $db;
        try {
            $token = $generatorLow->generateString(32, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
            // thêm vào db
            if ($db->getSingleData(DB_TABLE_PREFIX.'xm2btokenemail', 'COUNT(*)', 'tendangnhap', $ten) > 0) {

                $db->updateADataRow(DB_TABLE_PREFIX.'xm2btokenemail', 'token', $token, 'tendangnhap', $ten);

            } else {
                $db->insertMulDataRow(DB_TABLE_PREFIX.'xm2btokenemail', array(
                    'tendangnhap',
                    'token',
                ), array(
                    $ten,
                    $token
                ));
            }

            $mail->addAddress($ngNhan);     // Add a recipient

            $urlXacNhan = $url."/dangnhap?token=$token";

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = "[$tenngguiSMTP] Xác nhận 2 bước qua Email";
            $mail->Body    = "<p>Xin chào, $ten</p>
            <p>Chúng tôi vừa nhận được yêu cầu đăng nhập trên $tenngguiSMTP có thể là từ bạn,
            Nếu bạn muốn đăng nhập, hãy truy cập liên kết bên dưới để xác nhận.</p>
            <p><b>Nếu không phải bạn yêu cầu, hãy bỏ qua email này!</b></p>
            <br>
            <a href='$urlXacNhan' target='_blank'>$urlXacNhan</a>
            <br><br>
            ===<br>
            Trân trọng,<br>
            $tenngguiSMTP";
            $mail->AltBody = "Xin chào, $ten
            Chúng tôi vừa nhận được yêu cầu đổi địa chỉ email trên $tenngguiSMTP có thể là từ bạn,
            Nếu bạn muốn đăng nhập, hãy truy cập liên kết bên dưới để xác nhận.
            Nếu không phải bạn yêu cầu, hãy bỏ qua email này!
            
            $urlXacNhan

            ===
            Trân trọng,
            $tenngguiSMTP";
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    $ktradiachiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'diachiSMTP');
    $ktramatkhauSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'matkhauSMTP');
    $ktratenngguiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'tenngguiSMTP');
    $ktracongSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'congSMTP');
    $ktramaychuSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'maychuSMTP');

    if ($ktradiachiSMTP!=0||$ktramatkhauSMTP!=0||$ktratenngguiSMTP!=0||$ktracongSMTP!=0||$ktramaychuSMTP!=0) {
        $diachiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachiSMTP');
        $matkhauSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'matkhauSMTP');
        $tenngguiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'tenngguiSMTP');
        $congSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'congSMTP');
        $maychuSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'maychuSMTP');

        if ($diachiSMTP==''||$matkhauSMTP==''||$tenngguiSMTP==''||$congSMTP==''||$maychuSMTP=='') {
            $smtp = false;
        } else {
            $smtp = true;
        }
    } else {
        $smtp = false;
        // die('<h1>Quản trị viên cần cập nhật thông tin SMTP mới có thể sử dụng tính năng này! (#06)</h1>');
    }
    
?>