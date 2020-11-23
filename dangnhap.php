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

        // Kiểm tra token email

        if (isset($_GET['token'])) {
            $token = mysqli_real_escape_string($db->conn, $_GET['token']);
            if ($db->getSingleData(DB_TABLE_PREFIX.'xm2btokenemail', 'COUNT(*)', 'token', $token)>0) { // nếu token tồn tại
                
                $khoaphien = uniqid('khoaphien_', true);

                $tendangnhap = $db->getSingleData(DB_TABLE_PREFIX.'xm2btokenemail', 'tendangnhap', 'token', $token);

                $db->insertMulDataRow(DB_TABLE_PREFIX.'phien', array(
                    'tendangnhap',
                    'khoaphien'
                ), array(
                    "$tendangnhap",
                    "$khoaphien"
                ));

                $db->deleteADataRow(DB_TABLE_PREFIX.'xm2btokenemail', 'token', $token);

                $_SESSION['khoaphien'] = $khoaphien;

                setcookie('khoaphien', $khoaphien, time() + (86400 * 365), "/");

                header("Location: $redt/dangnhap");
            } else {
                header("Location: $redt/dangnhap?loitoken");
            }
        }

        // Kiểm tra xm2b

        $js2 = '';

        if (isset($_POST['xm2bCode'])&&isset($_POST['tendangnhapxm2b'])) {
            $xm2bCode = mysqli_real_escape_string($db->conn, $_POST['xm2bCode']);

            $tendangnhapxm2b = mysqli_real_escape_string($db->conn, $_POST['tendangnhapxm2b']);

            if ($xm2bCode=='') {
                header("Location: $redt/dangnhap?OTPtrong");
            }

            require_once("include/xm2b.php");

            $maXacNhan = $db->getSingleData(DB_TABLE_PREFIX.'xm2b', 'secret_code', 'tendangnhap', $tendangnhapxm2b);

            if ($tfa->verifyCode($maXacNhan, $xm2bCode)) {
                $js2 = 
                "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Bạn đã đăng nhập thành công, đang chuyển hướng...',
                        icon: 'success',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redt');
                    }, 1500);
                </script>";

                $khoaphien = uniqid('khoaphien_', true);

                $_SESSION['khoaphien'] = $khoaphien;

                setcookie('khoaphien', $khoaphien, time() + (86400 * 365), "/");

                $db->insertMulDataRow(DB_TABLE_PREFIX.'phien', array(
                    'tendangnhap',
                    'khoaphien'
                ), array(
                    "$tendangnhapxm2b",
                    "$khoaphien"
                ));

                $xm2b_checked = true;
            } else {
                header("Location: $redt/dangnhap?OTPloi");
            }
        }

        // 

        if (isset($_SESSION['khoaphien'])&&!isset($xm2b_checked)) {

            $khoaphien = $_SESSION['khoaphien'];

            $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', $khoaphien);

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
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    $pageName = 'Đăng nhập';
?>

<?php 
    require_once('include/init_include.php');

    require_once('include/header.php');
?>

<?php 
    // Xử lý dữ liệu
    $js = '';

    $hideLoginForm = '';
                        
    $hide2faForm = 'style="display: none"';

    if (isset($_POST['tendangnhap']) && isset($_POST['matkhau'])) {

        $tendangnhap = mysqli_real_escape_string($db->conn, $_POST['tendangnhap']);

        $matkhau = mysqli_real_escape_string($db->conn, $_POST['matkhau']);

        $matkhaubam = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'matkhaubam', 'tendangnhap', $tendangnhap);

        $ktra = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)', 'tendangnhap', $tendangnhap);

        if (password_verify($matkhau, $matkhaubam)&&$ktra==1) {

            if (isset($_POST['ghinhotoi'])) {

                $ghinhotoi = 'on';
                
            } else {

                $ghinhotoi = '';

            }

            $khoaphien = uniqid('khoaphien_', true);

            if ($ghinhotoi=='on') {
                setcookie('khoaphien', $khoaphien, time() + (86400 * 365), "/");
            } else {
                $_SESSION['khoaphien'] = $khoaphien;
            }
            $db->insertMulDataRow(DB_TABLE_PREFIX.'phien', array(
                'tendangnhap',
                'khoaphien'
            ), array(
                "$tendangnhap",
                "$khoaphien"
            ));

            if (isset($_GET['redf'])) {
                $redf = $_GET['redf'];
                $redf = str_replace('http://', '', $redf);
                $redf = str_replace('https://', '', $redf);
                $redf = $redf;
                $url = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachi');
                if (strpos($redf, $url)===false) {
                    $redf = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachi');
                }
                $js = 
                "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Bạn đã đăng nhập thành công, hãy đợi 1 tí để chuyển hướng về trang trước.',
                        icon: 'success',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redf');
                    }, 3000);
                </script>";
            } else {

                if ($db->getSingleData(DB_TABLE_PREFIX.'xacminh2buocemail', 'COUNT(*)', 'tendangnhap', $tendangnhap) > 0) {

                    if (($db->getSingleData(DB_TABLE_PREFIX.'xm2b', 'bat_xm2b', 'tendangnhap', $tendangnhap) == 1) && ($db->getSingleData(DB_TABLE_PREFIX.'xm2b', 'secret_code', 'tendangnhap', $tendangnhap) != '')) {

                        $hideLoginForm = 'style="display: none"';

                        $hide2faForm = '';

                        session_destroy();
                            
                        setcookie('khoaphien', $khoaphien, time() - (86400 * 365), "/");
                    } elseif ($db->getSingleData(DB_TABLE_PREFIX.'xacminh2buocemail', 'trangthai', 'tendangnhap', $tendangnhap) == 1) {

                        require_once('include/smtp.php');

                        if ($smtp) {
                            $email = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'email', 'tendangnhap', $tendangnhap);

                            sendEmailLogin($email, $tendangnhap);

                            $db->deleteADataRow(DB_TABLE_PREFIX.'phien', 'khoaphien', $khoaphien);

                            session_destroy();
                            
                            setcookie('khoaphien', $khoaphien, time() - (86400 * 365), "/");

                            header("Location: $redt/dangnhap?dangnhapquaemail");
                        } else {

                            $js = 
                            "<script>
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Bạn đã đăng nhập thành công, đang chuyển hướng...',
                                    icon: 'success',
                                    confirmButtonText: 'Đồng ý'
                                })
                                setTimeout(() => {
                                    location.assign('$redt');
                                }, 1500);
                            </script>";

                        }

                        
                    } else {
                        $js = 
                        "<script>
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Bạn đã đăng nhập thành công, đang chuyển hướng...',
                                icon: 'success',
                                confirmButtonText: 'Đồng ý'
                            })
                            setTimeout(() => {
                                location.assign('$redt');
                            }, 1500);
                        </script>";
                    }

                } else {
                    $js = 
                    "<script>
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Bạn đã đăng nhập thành công, đang chuyển hướng...',
                            icon: 'success',
                            confirmButtonText: 'Đồng ý'
                        })
                        setTimeout(() => {
                            location.assign('$redt');
                        }, 1500);
                    </script>";
                }
            }
        } else {
            $js = 
                "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Đăng nhập thất bại, hãy thử lại!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
        }
    }

    if (isset($_GET['dangnhapquaemail'])) {
        $js =  "<script>
                    Swal.fire({
                        title: 'Khoan đã!',
                        text: 'Do bạn đã kích hoạt tính năng đăng nhập qua email, hãy kiểm tra email để nhận thư xác nhận đăng nhập nhé!',
                        icon: 'warning',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['loitoken'])) {
        $js =  "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Token không hợp lệ!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redt/dangnhap');
                    }, 1500);
                </script>";
    } elseif (isset($_GET['tendangnhaprong'])) {
        $js =  "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Tên đăng nhập không được để trống!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redt/dangnhap');
                    }, 1500);
                </script>";
    } elseif (isset($_GET['OTPtrong'])) {
        $js =  "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Mã xác nhận không được bỏ trống!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redt/dangnhap');
                    }, 1500);
                </script>";
    } elseif (isset($_GET['OTPloi'])) {
        $js =  "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Mã xác nhận không hợp lệ!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redt/dangnhap');
                    }, 1500);
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
                    <div class="card-body" <?php echo $hideLoginForm ?>>
                        <h5 class="card-title">Đăng nhập</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Hãy đăng nhập để bắt đầu</h6>
                        <p class="card-text">
                            <form method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fi-cnsuxl-user-tie-circle icon"></i></span>
                                    </div>
                                    <input value="<?php echo $tendangnhap ?>" name="tendangnhap" type="text" class="form-control" placeholder="Tên đăng nhập" aria-label="Tên đăng nhập" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fi-cnsuxl-key-alt icon"></i></span>
                                    </div>
                                    <input value="<?php echo $matkhau ?>" name="matkhau" type="password" class="form-control" placeholder="Mật khẩu" aria-label="Mật khẩu" aria-describedby="basic-addon1">
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="ghinhotoi" name="ghinhotoi">
                                    <label class="custom-control-label" for="ghinhotoi">Ghi nhớ tôi (365 ngày)</label>
                                </div>
                                <button class="btn btn-info btn-block">Đăng nhập</button>
                            </form>
                        </p>
                        <a href="<?php echo $url ?>/doimatkhau" class="card-link">Quên mật khẩu?</a>
                        <a href="<?php echo $url ?>" class="card-link">Về trang chủ</a>
                    </div>

                    <div class="card-body" <?php echo $hide2faForm ?>>
                        <h5 class="card-title">Xác minh 2 bước</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Hãy nhập mã xác minh để tiếp tục</h6>
                        <p class="card-text">
                            <form method="POST">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fi-cnsuxl-key-alt icon"></i></span>
                                    </div>
                                    <input name="xm2bCode" type="text" class="form-control" placeholder="Xác minh 2 bước" aria-label="Xác minh 2 bước" aria-describedby="basic-addon1">
                                    <input name="tendangnhapxm2b" type="hidden" value="<?php echo $tendangnhap ?>">
                                </div>
                                <button class="btn btn-info btn-block">Xác minh</button>
                            </form>
                        </p>
                        <a href="<?php echo $url ?>/doimatkhau" class="card-link">Quên mật khẩu?</a>
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
    echo $js2;
?>