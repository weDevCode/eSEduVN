<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    function customHeader($header)
    {
        header($header);
        die();
    }

    define('isSet', 1);

    require_once('../include/db.php');

    require_once('../include/init_include.php');

    $pageName = "Trang cá nhân";

    require_once('../include/loginCheck.php');

    $js = '';

    $email = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'email', 'tendangnhap', $tennguoidung);
    
    $ten = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'tendangnhap', $tennguoidung);

    if ($db->getSingleData(DB_TABLE_PREFIX.'xacminh2buocemail', 'COUNT(*)', 'tendangnhap', $tennguoidung) > 0) { // ktra ngdung có bật xm2b qua email

        if ($db->getSingleData(DB_TABLE_PREFIX.'xacminh2buocemail', 'trangthai', 'tendangnhap', $tennguoidung) == 1) {
            $is_check = 'checked';
        } else {
            $is_check = '';
        }

    } else {
        $is_check = '';
    }

    if (isset($_POST['password_verify'])&&isset($_POST['email'])&&isset($_POST['ten'])) { // cập nhật thông tin
        $password_verify = mysqli_real_escape_string($db->conn, $_POST['password_verify']);
        $emailForm = mysqli_real_escape_string($db->conn, $_POST['email']);
        $tenForm = mysqli_real_escape_string($db->conn, $_POST['ten']);

        if (password_verify($password_verify, $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'matkhaubam', 'tendangnhap', $tennguoidung))) {
            
            if (isset($_POST['xacminh2buoc'])) { // nếu tích vào
                require_once('../include/smtp.php');
                if ($db->getSingleData(DB_TABLE_PREFIX.'xacminh2buocemail', 'COUNT(*)', 'tendangnhap', $tennguoidung) > 0) {// nếu tìm thấy
                    $db->updateADataRow(DB_TABLE_PREFIX.'xacminh2buocemail', 'trangthai', 1, 'tendangnhap', $tennguoidung);
                } else { // nếu không
                    $db->insertMulDataRow(DB_TABLE_PREFIX.'xacminh2buocemail', array(
                        'tendangnhap',
                        'trangthai'
                    ), array(
                        $tennguoidung,
                        1
                    ));
                }
            } else { // nếu không
                if ($db->getSingleData(DB_TABLE_PREFIX.'xacminh2buocemail', 'COUNT(*)', 'tendangnhap', $tennguoidung) > 0) {// nếu tìm thấy
                    $db->updateADataRow(DB_TABLE_PREFIX.'xacminh2buocemail', 'trangthai', 0, 'tendangnhap', $tennguoidung);
                } else { // nếu không
                    $db->insertMulDataRow(DB_TABLE_PREFIX.'xacminh2buocemail', array(
                        'tendangnhap',
                        'trangthai'
                    ), array(
                        $tennguoidung,
                        0
                    ));
                }
            }

            if ($tenForm!=$ten) {
                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'hovaten', $tenForm, 'tendangnhap', $tennguoidung);
            }

            if ($emailForm!=$email) {
                require_once('../include/smtp.php');
                if ($smtp) {
                    sendEmailResetVerify($emailForm, $tennguoidung);
                    customHeader("Location: $url/trangcanhan/?chinhsuaemail");
                } else {
                    customHeader("Location: $url/trangcanhan/?chinhsuaemailbitat");
                }
            }

            customHeader("Location: $url/trangcanhan/?chinhsuathanhcong");
        } else {
            customHeader("Location: $url/trangcanhan/?saimatkhau");
        }

        
    }

    if (isset($_GET['chinhsuaemail'])) { // thông báo
        $js = "<script>
                    Swal.fire({
                        title: 'Chú ý!',
                        text: 'Bạn hãy kiểm tra email mới và truy cập liên kết để đổi email nhé!',
                        icon: 'warning',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['chinhsuaemailbitat'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Chú ý!',
                        text: 'Lưu thành công, tuy nhiên không đổi được email do tính năng chỉnh sửa email bị tắt!',
                        icon: 'warning',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['chinhsuathanhcong'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Chỉnh sửa thành công!',
                        icon: 'success',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['thatbai'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Chỉnh sửa thất bại!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['tokenkhonghople'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Token không hợp lệ!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['saimatkhau'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Sai mật khẩu!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['matkhaukhongkhop'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thất bại!',
                        text: 'Mật khẩu xác nhận không khớp!',
                        icon: 'error',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    } elseif (isset($_GET['doimatkhauthanhcong'])) {
        $js = "<script>
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Đổi mật khẩu thành công!',
                        icon: 'success',
                        confirmButtonText: 'Đồng ý'
                    })
                </script>";
    }

    if (isset($_GET['token'])) { // đổi email
        $token = mysqli_real_escape_string($db->conn, $_GET['token']);
        $ktraToken = $db->query("SELECT COUNT(*) FROM ".DB_TABLE_PREFIX.'xacminhdoiemail'." WHERE token='$token' AND tendangnhap='$tennguoidung'");
        if (mysqli_num_rows($ktraToken)>0) {
            $arr = mysqli_fetch_assoc($ktraToken);
            if ($arr['COUNT(*)']>0) {
                $emailNew = $db->getSingleData(DB_TABLE_PREFIX.'xacminhdoiemail', 'email_new', 'token', $token);

                $db->updateADataRow(DB_TABLE_PREFIX.'nguoidung', 'email', $emailNew, 'tendangnhap', $tennguoidung);

                $db->deleteADataRow(DB_TABLE_PREFIX.'xacminhdoiemail', 'token', $token);

                customHeader("Location: $url/trangcanhan/?chinhsuathanhcong");
            } else {
                customHeader("Location: $url/trangcanhan/?tokenkhonghople");
            }
        }
    }

    if (isset($_POST['oldPW'])&&isset($_POST['newPW'])&&isset($_POST['retnewPW'])) { // đổi mật khẩu
        $oldPW = mysqli_real_escape_string($db->conn, $_POST['oldPW']);
        $newPW = mysqli_real_escape_string($db->conn, $_POST['newPW']);
        $retnewPW = mysqli_real_escape_string($db->conn, $_POST['retnewPW']);
        $currentPW = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'matkhaubam', 'tendangnhap', $tennguoidung);

        if ($newPW!=$retnewPW) {
            customHeader("Location: $url/trangcanhan/?matkhaukhongkhop");
        } elseif (!password_verify($oldPW, $currentPW)) {
            customHeader("Location: $url/trangcanhan/?saimatkhau");
        } else {
            $newPW = password_hash($newPW, PASSWORD_DEFAULT);
            $db->updateADataRow(DB_TABLE_PREFIX.'nguoidung', 'matkhaubam', $newPW,'tendangnhap', $tennguoidung);
            customHeader("Location: $url/trangcanhan/?doimatkhauthanhcong");
        }
    }
?>

<?php 
    require_once('../include/header.php');

    require_once('../include/menu_non_sadmin.php');
?>
<main>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12">
                <!-- Password -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center">Thông tin người dùng</h3>
                            <!-- INP -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Tên đăng nhập (Không thể thay đổi)</span>
                                </div>
                                <input type="text" value='<?php echo $tennguoidung ?>' disabled class="form-control">
                            </div>
                            <!-- INP -->
                            <!-- INP -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Email</span>
                                </div>
                                <input type="text" value='<?php echo $email ?>' disabled class="form-control">
                            </div>
                            <!-- INP -->
                            <!-- INP -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Họ tên</span>
                                </div>
                                <input type="text" value='<?php echo $ten ?>' disabled class="form-control">
                            </div>
                            <!-- INP -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form method="post">
                                <h3 class="text-center">Đổi mật khẩu</h3>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Mật khẩu mới</span>
                                    </div>
                                    <input type="password" name='newPW' class="form-control">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Xác nhận mật khẩu mới</span>
                                    </div>
                                    <input type="password" name='retnewPW' class="form-control">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Nhập mật khẩu hiện tại để xác nhận</span>
                                    </div>
                                    <input type="password" name='oldPW' class="form-control">
                                </div>
                                <button class="btn btn-info btn-block">Đổi mật khẩu</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <form method="post">
                    <h3 class="text-center">Cập nhật thông tin</h3>
                    <!-- INP -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Email</span>
                        </div>
                        <input type="text" value='<?php echo $email ?>' name="email" class="form-control">
                    </div>
                    <!-- INP -->
                    <!-- INP -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Họ tên</span>
                        </div>
                        <input type="text" value='<?php echo $ten ?>' name="ten" class="form-control">
                    </div>
                    <!-- INP -->
                    <!-- INP -->
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="xm2b" name='xacminh2buoc' <?php echo $is_check ?>>
                        <label class="custom-control-label" for="xm2b">Bật tính năng xác minh 2 bước qua email (Đăng nhập bằng liên kết qua mail)</label>
                    </div>
                    <!-- INP -->
                    <!-- INP -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nhập mật khẩu để xác nhận</span>
                        </div>
                        <input type="password" name='password_verify' class="form-control">
                    </div>
                    <!-- INP -->
                    <button class="btn btn-info btn-block">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    require_once('../include/footer.php');
    echo $js;
?>