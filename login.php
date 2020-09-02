<?php 
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
    if (isset($_POST['tendangnhap']) && isset($_POST['matkhau'])) {

        $tendangnhap = mysqli_real_escape_string($db->conn, $_POST['tendangnhap']);

        $matkhau = mysqli_real_escape_string($db->conn, $_POST['matkhau']);

        $matkhaubam = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'matkhaubam', 'tendangnhap', $tendangnhap);
        
        if (password_verify($matkhau, $matkhaubam)) {

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
                $js = 
                "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Bạn đã đăng nhập thành công, hãy đợi 1 tí để chuyển hướng về trang quản lý.',
                        icon: 'success',
                        confirmButtonText: 'Đồng ý'
                    })
                    setTimeout(() => {
                        location.assign('$redt');
                    }, 3000);
                </script>";
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
                        <a href="#" class="card-link">Quên mật khẩu?</a>
                        <a href="#" class="card-link">Về trang chủ</a>
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