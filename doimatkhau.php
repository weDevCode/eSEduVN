<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);
    
    require_once('include/db.php');

    session_start();

    // Kiểm tra xem đã đăng nhập chưa - bắt đầu

        $tendangnhap = '';
        
        $matkhau = '';

        $giaothuc = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "giaothuc");
        
        $redt = $giaothuc.$db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "diachi");

        if (isset($_SESSION['khoaphien'])) {

            $khoaphien = $_SESSION['khoaphien'];

            $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', "$khoaphien");

            if ($check == 1) {

                header("Location: ".$redt, true, 303);

            }

        } elseif (isset($_COOKIE['khoaphien'])) {

            $khoaphien = $_COOKIE['khoaphien'];

            $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', "$khoaphien");

            if ($check == 1) {

                header("Location: ".$redt, true, 303);

            }
        }
    // Kết thúc
    $pageName = 'Đổi mật khẩu';
?>

<?php 
    require_once('include/init_include.php');

    require_once('include/header.php');
?>

<?php 
    // Xử lý dữ liệu
    $js = '';
    $html = <<<HTML
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fi-cnsuxl-user-tie-circle icon"></i></span>
            </div>
            <input name="tendangnhap" type="text" class="form-control" placeholder="Tên đăng nhập" aria-label="Tên đăng nhập" aria-describedby="basic-addon1">
        </div>
        <button class="btn btn-info btn-block">Đổi mật khẩu</button>
    HTML;
    $caption = 'Hãy nhập tên đăng nhập để đổi mật khẩu!';
    if (isset($_POST['tendangnhap'])) {
        $tendangnhap = mysqli_real_escape_string($db->conn, $_POST['tendangnhap']);

        $ktra = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)', 'tendangnhap', $tendangnhap);

        if ($ktra > 0) { // kiểm tra xem có tồn tại người dùng không
            $email = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'email', 'tendangnhap', $tendangnhap);

            require_once('include/smtp.php');

            if ($smtp) {
                sendPasswordResetLink($email, $tendangnhap);
                header("Location: $url/doimatkhau?chuy");
            } else {
                header("Location: $url/doimatkhau?tinhnangdoimatkhaubitat");
            }

        } else {
            header("Location: $url/doimatkhau?chuy");
        }
    }

    if (isset($_GET['token'])) {
        $token = mysqli_real_escape_string($db->conn, $_GET['token']);

        if ($db->getSingleData(DB_TABLE_PREFIX.'xacminhdoimatkhau', 'COUNT(*)', 'token', $token) > 0) {
            
            $tendangnhap = $db->getSingleData(DB_TABLE_PREFIX.'xacminhdoimatkhau', 'tendangnhap', 'token', $token);

            $html = <<<HTML
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fi-cnsuxl-key-alt icon"></i></span>
                    </div>
                    <input name="matkhau" type="password" class="form-control" placeholder="Mật khẩu" aria-label="Mật khẩu" aria-describedby="basic-addon1">
                </div>
                <button class="btn btn-info btn-block">Đổi mật khẩu</button>
            HTML;

            $caption = 'Tiến hành đổi mật khẩu!...';

            if (isset($_POST['matkhau'])) {
                $matkhau = mysqli_real_escape_string($db->conn, $_POST['matkhau']);

                $matkhaubam = password_hash($matkhau, PASSWORD_DEFAULT);

                $db->updateADataRow(DB_TABLE_PREFIX.'nguoidung', 'matkhaubam', $matkhaubam, 'tendangnhap', $tendangnhap);

                $db->deleteADataRow(DB_TABLE_PREFIX.'xacminhdoimatkhau', 'tendangnhap', 'token', $token);

                header("Location: $url/doimatkhau?thanhcong");
            }

        } else {
            header("Location: $url/doimatkhau?thatbai");
        }
    } elseif (isset($_GET['chuy'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Chú ý!',
                        text: 'Nếu tên đăng nhập hợp lệ, chúng tôi sẽ gửi liên kết đổi mật khẩu qua email liên kết với tên tài khoản bạn đã nhập! vui lòng kiểm tra cả hộp thư SPAM/rác để nhận email đổi mật khẩu!',
                        icon: 'warning',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['thanhcong'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Chúc mừng! Bạn đã đổi mật khẩu thành công!',
                        icon: 'success',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['thatbai'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Token không hợp lệ!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['tinhnangdoimatkhaubitat'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Tính năng đổi mật đã bị tắt!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    }
    
?>
<style>
    .container {
        height: 100vh;
    }
</style>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12 col-md-3"></div>
            <div class="col-lg-4 col-sm-12 col-md-6 d-flex align-items-center" style="min-height: 100vh;">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Đổi mật khẩu</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $caption ?></h6>
                        <p class="card-text">
                            <form method="POST">
                                <?php echo $html ?>
                            </form>
                        </p>
                        <a href="<?php echo $url ?>/dangnhap" class="card-link">Đăng nhập?</a>
                        <a href="<?php echo $url ?>" class="card-link">Về trang chủ</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12 col-md-3"></div>
        </div>
    </div>

<?php 
    require_once('include/footer.php');
    echo $js;
?>