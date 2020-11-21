<?php
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

    $ktradiachiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'diachiSMTP');
    $ktramatkhauSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'matkhauSMTP');
    $ktratenngguiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'tenngguiSMTP');
    $ktracongSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'congSMTP');
    $ktramaychuSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'maychuSMTP');

    if ($ktradiachiSMTP!=0&&$ktramatkhauSMTP!=0&&$ktratenngguiSMTP!=0&&$ktracongSMTP!=0&&$ktramaychuSMTP!=0) {
        $diachiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachiSMTP');
        $matkhauSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'matkhauSMTP');
        $tenngguiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'tenngguiSMTP');
        $congSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'congSMTP');
        $maychuSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'maychuSMTP');
    } else {
        die('Thiếu thông tin đăng nhập SMTP trong CSDL, vui lòng cập nhật ở trang quản trị! (#06)');
    }
    
?>