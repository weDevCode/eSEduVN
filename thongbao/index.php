<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/db.php');

    $pageName = 'Thông báo';

    require_once('../include/init_include.php');

    require_once('../include/ktDsLop.php');

    function thongBao($loinhan, $loai)
    {
        global $url;
        header('Location: '.$url."/thongbao/?thongbao=$loai&loinhan=$loinhan!", true);
        die();
    }

    $thongbaoHTML = '';
    if (isset($_GET['thongbao'])) {
        $thongbao = $_GET['thongbao'];
        if (isset($_GET['loinhan'])) {
            $loinhan = htmlspecialchars($_GET['loinhan']);
        } else {
            $loinhan = '';
        }
        switch ($thongbao) {
            case 'thanhcong':
                $thongbaoHTML = "<div class='alert alert-success' role='alert'>$loinhan</div>";
                break;

            case 'thatbai':
                $thongbaoHTML = "<div class='alert alert-danger' role='alert'>$loinhan</div>";
                break;
        }
    }
?>

<?php
    require_once('../include/header.php');

    require_once('../include/menu_non_sadmin.php');

    require_once('../include/ktngayluutruTXem.php');

    require_once("../include/ktgiovaotiet.php");

    require_once("../include/ktThoigianhientai.php");

    $html = '';
    $trang= 1;
    $count = $db->getSingleData(DB_TABLE_PREFIX.'thongbao', 'COUNT(*)');
    if ($count > 0) { // hiện danh sách thông báo
        $arr = $db->getMulData(DB_TABLE_PREFIX.'thongbao', array('tieude','noidung','thoigian'));
        if (isset($_GET['trang'])) {
            $trang = mysqli_real_escape_string($db->conn, $_GET['trang']);
            if ($trang > ceil($count/10)) {
                thongBao('Số trang quá to so với số lượng thông báo','thatbai');
            }
            $tbdau = ($trang-1)*10;
            $tbcuoi = $tbdau+9;
            if ($count-1>=$tbdau && $count-1<=$tbcuoi) { // nếu count nằm trong khoảng
                $tbcuoi = $count-1;
            }
        } else { // nếu không đặt trang
            $tbdau = 0;
            // nếu count <= 10
            if ($count <= 10) {
                $tbcuoi = $count-1;
            } else {
                $tbcuoi = 9;
            }
            
        }

        for ($i=$tbcuoi; $i >= $tbdau; $i--) {
            $html .= "<div class='card'>
            <div class='card-body'>
                <h3 class='card-title'>".$arr[$i]['tieude']."</h3>
                ".$arr[$i]['noidung']."
                <h6><span class='badge badge-primary'>".$arr[$i]['thoigian']."</span></h6>
                </div>
            </div>";
        }
        $max = ceil($count/10);
    } else {
        $max = 0;
    }

    if (isset($_POST['ten'])&&isset($_POST['email'])) { // đăng ký nhận thư thông báo
        $ten = mysqli_real_escape_string($db->conn, $_POST['ten']);
        $email = mysqli_real_escape_string($db->conn, $_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            thongBao('Email không hợp lệ', 'thatbai');
        } elseif (strlen($email)>255||strlen($ten)>320) {
            thongBao('Lỗi: Tên phải nhỏ hơn 320 ký tự, email phải nhỏ hơn 255 ký tự', 'thatbai');
        } else {
            require_once('../include/smtp.php');
            if ($smtp) {
                if ($db->getSingleData(DB_TABLE_PREFIX.'nhanthongbao', 'COUNT(*)', 'email', $email) > 0) {
                    thongBao('Bạn đã đăng ký nhận thư rồi!', 'thatbai');
                } else {
                    sendNotifyEmailVerify($email, $ten);
                    thongBao('Hãy kiểm tra hộp thư (kể cả hộp thư rác/spam) để tìm thư xác nhận email, bạn sẽ chỉ nhận được thông báo sau khi đã xác nhận email!', 'thanhcong');
                }
            } else {
                thongBao('Hiện tính năng nhận thông báo qua email đang bị tắt!', 'thatbai');
            }
            
        }
    }

    if (isset($_GET['token'])&&$_GET['ten']) { // xác minh địa chỉ email
        $token = mysqli_real_escape_string($db->conn, $_GET['token']);
        $ten = mysqli_real_escape_string($db->conn, htmlspecialchars($_GET['ten']));

        if ($db->getSingleData(DB_TABLE_PREFIX.'xacminhnhanthongbao', 'COUNT(*)', 'token', $token) > 0) {

            $email = $db->getSingleData(DB_TABLE_PREFIX.'xacminhnhanthongbao', 'email', 'token', $token);

            $db->insertMulDataRow(DB_TABLE_PREFIX.'nhanthongbao', array(
                'ten',
                'email'
            ), array(
                $ten,
                $email
            ));

            $db->deleteADataRow(DB_TABLE_PREFIX.'xacminhnhanthongbao', 'email', $email);

            thongBao("Xác minh thành công, từ giờ bạn sẽ nhận được thông báo qua email khi có tin tức mới từ hệ thống!", 'thanhcong');
        } else {
            thongBao("Lỗi: token không hợp lệ", 'thatbai');
        }
    }
?>

<main>
    <div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
                <p class="text-center">Nơi cập nhật những thông báo mới nhất</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?php echo $thongbaoHTML ?>
            </div>
        </div>

        <form method='POST' class="row">
            <div class="col-lg-4 col-md-4 col-12">
                <input type="text" placeholder="Tên" name="ten" id="ten" class='form-control' required>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <input type="email" placeholder="Email" name="email" id="email" class='form-control' required>
            </div>
            <div class="col-lg-4 col-md-4 col-12"><button class="btn btn-block btn-success">Nhận thông báo qua email</button></div>
        </form>

        <div class="row">
            <div class="col">
                <?php echo $html ?>
            </div>
        </div>

        <form method="GET" class="row">
            <div class="col-lg-2 col-md-2 col-12">
                <label for="trang">Nhập trang để tìm</label>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                <input type="number" min="1" max='<?php echo $max ?>' value='<?php echo $trang ?>' name="trang" id="trang" class="form-control">
            </div>
            <div class="col-lg-2 col-md-2 col-12">
                <button class="btn btn-info btn-block">Tra cứu</button>
            </div>
        </form>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    echo "<script>";
    echo $js;
    echo "</script>";
    require_once('../include/footer.php');
?>