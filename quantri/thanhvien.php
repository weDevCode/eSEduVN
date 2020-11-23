<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/init_include.php');

    require_once('../include/loginCheck.php');

    require_once('../include/db.php');

    $pageName = 'Quản lý thành viên';
    
    require_once('../include/include.php');

    require_once('../include/ktraAdmin.php');
?>


<?php 
    // Thông báo
    $js = '';
    if (isset($_GET['khongcodulieu'])) {
        $js = "Swal.fire({
            title: 'Lỗi!',
            text: 'Vui lòng điền đầy đủ các ô, trừ các ô không bắt buộc!',
            icon: 'error',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['vuotquakitu'])) {
        $js = "Swal.fire({
            title: 'Lỗi!',
            text: 'Họ và tên phải nhỏ hơn 255 ký tự, Email phải nhỏ hơn 320 ký tự!',
            icon: 'error',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['tendangnhaphoacemailtontai'])) {
        $js = "Swal.fire({
            title: 'Lỗi!',
            text: 'Tên đăng nhập hoặc email đã tồn tại!',
            icon: 'error',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['tendangnhaphoacemailtontai'])) {
        $js = "Swal.fire({
            title: 'Lỗi!',
            text: 'Tên đăng nhập hoặc email đã tồn tại!',
            icon: 'error',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['themthanhcong'])) {
        $js = "Swal.fire({
            title: 'Thành công!',
            text: 'Thêm thành viên mới thành công! Bây giờ bạn có thể qua trang chỉnh sửa để xem thành viên',
            icon: 'success',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['themthanhcongnhungchunhiemdaco'])) {
        $js = "Swal.fire({
            title: 'Thành công!',
            text: 'Thêm thành viên mới thành công! Tuy nhiên lớp bạn chỉ định đã có giáo viên khác chủ nhiệm, vui lòng chỉnh sửa lại ở trang chỉnh sửa thành viên',
            icon: 'success',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['themthanhcongnhungkhongthaylopchidinhchunhiem'])) {
        $js = "Swal.fire({
            title: 'Thành công!',
            text: 'Thêm thành viên mới thành công! Tuy nhiên không tìm thấy tên lớp đã chỉ định, vui lòng chỉnh lại ở trang chỉnh sửa thành viên',
            icon: 'success',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['chinhsuathanhcong'])) {
        $js = "Swal.fire({
            title: 'Thành công!',
            text: 'Chỉnh sửa thành công!',
            icon: 'success',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['chinhsuathanhcongnhungchunhiemdaco'])) {
        $js = "Swal.fire({
            title: 'Thành công!',
            text: 'Chỉnh sửa thành công! Tuy nhiên lớp bạn chỉ định đã có giáo viên khác chủ nhiệm, vui lòng đóng thông báo và chỉnh sửa lại.',
            icon: 'success',
            confirmButtonText: 'Ok'
          })";
    } elseif (isset($_GET['chinhsuathanhcongnhungkhongthaylopchidinhchunhiem'])) {
        $js = "Swal.fire({
            title: 'Thành công!',
            text: 'Chỉnh sửa thành công! Tuy nhiên không tìm thấy tên lớp đã chỉ định, vui lòng đóng thông báo và chỉnh sửa lại.',
            icon: 'success',
            confirmButtonText: 'Ok'
          })";
    }

    // Thông báo - end

    $content = "<p>Đây là trang dùng để quản lý thành viên trên hệ thống <b><?php echo SITE_NAME ?></b></p>
                <p>Để thêm, chỉnh sửa hay xoá một thành viên, bạn hãy nhấn vào 1 trong các nút ở bên trái (trên máy tính)
                    hoặc bên trên (trên điện thoại).</p>";
    if (isset($_GET['phuongthuc'])) {
        $phuongthuc = $_GET['phuongthuc'];
        switch ($phuongthuc) {
            case 'tao':
                $content = "<h3 class='text-center'>Thêm thành viên mới</h3>";
                $content .= <<<HTML
                    <form method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inp-tendangnhap"><i class="fi-cnsuxl-user-tie-circle"></i></span>
                            </div>
                            <input required name="tendangnhap" type="text" class="form-control" placeholder="Tên đăng nhập (*)" aria-label="Tên đăng nhập" aria-describedby="inp-tendangnhap">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inp-hovaten"><i class="fi-xwluxl-address-card-solid"></i></span>
                            </div>
                            <input required name="hovaten" type="text" class="form-control" placeholder="Họ và tên (*)" aria-label="Tên đăng nhập" aria-describedby="inp-hovaten">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inp-email"><i class="fi-xwsuxl-envelope-solid"></i></span>
                            </div>
                            <input required name="email" type="email" class="form-control" placeholder="Email (*)" aria-label="Email" aria-describedby="inp-email">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inp-matkhau"><i class="fi-cnsuxl-key-alt"></i></span>
                            </div>
                            <input required name="matkhau" type="password" class="form-control" placeholder="Mật khẩu (*)" aria-label="Mật khẩu" aria-describedby="inp-matkhau">
                        </div>
                    HTML;

                $content .= <<<HTML
                    <div class="form-group">
                        <label for="chunhiemlop">Chủ nhiệm lớp</label>
                        <select required class="form-control" id="chunhiemlop" name="chunhiemlop">
                            <option value="0" selected>Không có</option>
                    HTML;
                
                $cackhoilop = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'));

                if ($cackhoilop != 0) {
                    for ($i=0; $i < count($cackhoilop); $i++) { 
                        $khoi = $cackhoilop[$i]['khoi'];
                        $content .= "<option disabled>---- Khối $khoi ----</option>"; // đề mục
                        $dslop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array('lop'), 'khoi', $khoi);
                        for ($j=0; $j < count($dslop); $j++) { 
                            $lop = $dslop[$j]['lop'];
                            // Kiểm tra lớp có gvcn nào chưa
                            $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'COUNT(*)', 'chunhiem', $lop);
                            if ($kiemtra > 0) {
                                $gvcn = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $lop);
                                $content .= "<option disabled>Lớp $lop (GVCN: $gvcn)</option>";
                            } else {
                                $content .= "<option value='$lop'>Lớp $lop</option>";
                            }
                        }
                    } 
                }
                
                $content .= <<<HTML
                        </select>
                    </div>
                    HTML;


                $content .= <<<HTML
                        <div class="input-group mb-3">
                            <input name="chucvu" type="text" class="form-control" placeholder="Chức vụ (Nếu không có thì bỏ trống)" aria-label="Chức vụ (Nếu không có thì bỏ trống)" aria-describedby="inp-chucvu">
                        </div>
                        <div class="input-group mb-3">
                            <input name="bomon" type="text" class="form-control" placeholder="Bộ môn (Nếu không có thì bỏ trống)" aria-label="Bộ môn (Nếu không thì bỏ trống)" aria-describedby="inp-bomon">
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <h4 class="text-center">Quyền hạn (được phép truy cập vào trang...)</h4>
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input name="c-diemdanh" type="checkbox" class="custom-control-input" id="c-diemdanh">
                                        <label class="custom-control-label" for="c-diemdanh">Quản lý điểm danh</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input name="c-sodaubai" type="checkbox" class="custom-control-input" id="c-sodaubai">
                                        <label class="custom-control-label" for="c-sodaubai">Quản lý sổ đầu bài</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input name="c-tkb" type="checkbox" class="custom-control-input" id="c-tkb">
                                        <label class="custom-control-label" for="c-tkb">Quản lý thời khoá biểu</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="custom-control custom-checkbox">
                                    <input name="la_admin" type="checkbox" class="custom-control-input" id="c-qtv">
                                    <label class="custom-control-label" for="c-qtv"><b>Trao quyền quản trị cho người dùng này?</b></label>
                                </div>
                            </div>
                        </div>
                        <p>Các ô bắt buộc phải nhập được đánh dấu (*)</p>
                        <button class="btn btn-success btn-block">Thêm thành viên</button>
                    </form>
                HTML;

                if (isset($_POST['tendangnhap'])&&isset($_POST['hovaten'])&&isset($_POST['email'])&&isset($_POST['matkhau'])) {
                    $tendangnhap = mysqli_escape_string($db->conn, $_POST['tendangnhap']);
                    $hovaten = mysqli_escape_string($db->conn, $_POST['hovaten']);
                    $email = mysqli_escape_string($db->conn, $_POST['email']);
                    $matkhau = mysqli_escape_string($db->conn, $_POST['matkhau']);
                    if ($tendangnhap==''||$hovaten==''||$email==''||$matkhau=='') {
                        header("Location: $currentURL&khongcodulieu");
                    } elseif (strlen($hovaten)>255||strlen($email)>320) {
                        header("Location: $currentURL&vuotquakitu");
                    } else {
                        $kttendangnhap = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)', 'tendangnhap', $tendangnhap);
                        $ktemail = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)', 'email', $email);
                        if ($kttendangnhap > 0 || $ktemail > 0) { // tồn tại tên đăng nhập hoặc email
                            header("Location $currentURL&tendangnhaphoacemailtontai");
                        } else {
                            
                            $db->insertMulDataRow(DB_TABLE_PREFIX.'nguoidung', array(
                                'tendangnhap',
                                'email',
                                'matkhaubam'
                            ), array(
                                $tendangnhap,
                                $email,
                                password_hash($matkhau, PASSWORD_DEFAULT)
                            ));
                            
                            $db->insertMulDataRow(DB_TABLE_PREFIX.'quyen', array(
                                'tendangnhap',
                                'hovaten',
                                'chucvu',
                                'bomon',
                                'chunhiem',
                                'diemdanh',
                                'tkb',
                                'sodaubai',
                                'la_admin',
                            ), array(
                                $tendangnhap,
                                $hovaten,
                                0,
                                0,
                                0,
                                0,
                                0,
                                0,
                                0
                            ));

                            if ($_POST['chucvu']!=='') {
                                $chucvu = $_POST['chucvu'];
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chucvu', $chucvu, 'tendangnhap', $tendangnhap);
                            } else {
                                $chucvu = $_POST['chucvu'];
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chucvu', 0, 'tendangnhap', $tendangnhap);
                            }

                            if ($_POST['bomon']!=='') {
                                $bomon = $_POST['bomon'];
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'bomon', $bomon, 'tendangnhap', $tendangnhap);
                            } else {
                                $bomon = $_POST['bomon'];
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'bomon', 0, 'tendangnhap', $tendangnhap);
                            }

                            if (isset($_POST['chunhiemlop'])) {
                                $chunhiem = $_POST['chunhiemlop'];
                                if ($chunhiem==0) {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', 0, 'tendangnhap', $tendangnhap);
                                } else {
                                    $ktlop = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)', 'lop', $chunhiem);
                                    if ($ktlop>0) { // trong dslop có lớp được chỉ định
                                        $ktlop = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'COUNT(*)', 'chunhiem', $chunhiem);
                                        if ($ktlop > 0) { // trong table quyen có gv đã chủ nhiệm lớp đã chỉ định
                                            header("Location: $currentURL&themthanhcongnhungchunhiemdaco");
                                        } else {
                                            $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', $chunhiem, 'tendangnhap', $tendangnhap);
                                        }
                                    } else {
                                        header("Location: $currentURL&themthanhcongnhungkhongthaylopchidinhchunhiem");
                                    }
                                }
                            }

                            if (isset($_POST['c-diemdanh'])) {
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'diemdanh', 1, 'tendangnhap', $tendangnhap);
                            }

                            if (isset($_POST['c-tkb'])) {
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'tkb', 1, 'tendangnhap', $tendangnhap);
                            }

                            if (isset($_POST['c-sodaubai'])) {
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'sodaubai', 1, 'tendangnhap', $tendangnhap);
                            }

                            if (isset($_POST['la_admin'])) {
                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'la_admin', 1, 'tendangnhap', $tendangnhap);
                            }

                            header("Location: $currentURL&themthanhcong");
                        }
                    }
                }


                break;

            case 'chinhsua':
                
                $dsthanhvien = $db->getMulData(DB_TABLE_PREFIX.'quyen', array(
                    'id',
                    'tendangnhap',
                    'hovaten',
                    'chucvu',
                    'bomon',
                    'chunhiem'
                ));
                $content = <<<HTML
                    <h3 class="text-center">Danh sách thành viên</h3>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Tên đăng nhập</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Chức vụ</th>
                            <th scope="col">Bộ môn</th>
                            <th scope="col">Chủ nhiệm</th>
                            <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                    HTML;

                for ($i=0; $i < count($dsthanhvien); $i++) { 
                    $content .= "<tr>";
                    foreach ($dsthanhvien[$i] as $key => $value) {
                        if ($key != 'id') {
                            if ($value) {
                                $content .= "<td class='$key'>$value</td>";
                            } else {
                                $content .= "<td class='$key'>Không có</td>";
                            }
                        }
                    }
                    $content .= "<td class='chinhsua'><a class='btn btn-info btn-block' href='?phuongthuc=chinhsua&id=".$dsthanhvien[$i]['id']."'>Chỉnh sửa</a></td>";
                    $content .= "</tr>";
                }

                $content .= <<<HTML
                    </tbody>
                    </table>
                HTML;

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $ktid = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'COUNT(*)', 'id', $id);
                    if ($id == '') {
                        $content = "<b>Lỗi do người dùng định nghĩa ID rỗng</b>";
                    } elseif ($ktid > 0) {
                        if (isset($_POST['hovaten'])&&isset($_POST['email'])) {
                            $tendangnhap = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'tendangnhap', 'id', $id);
                            $hovaten = mysqli_escape_string($db->conn, $_POST['hovaten']);
                            $email = mysqli_escape_string($db->conn, $_POST['email']);
                            $matkhau = mysqli_escape_string($db->conn, $_POST['matkhau']);
                            if ($hovaten==''||$email=='') {
                                header("Location: $currentURL&khongcodulieu");
                            } elseif (strlen($hovaten)>255||strlen($email)>320) {
                                header("Location: $currentURL&vuotquakitu");
                            } else {

                                if ($matkhau !== '') {
                                    $db->updateMulDataRow(DB_TABLE_PREFIX.'nguoidung', array(
                                        'email',
                                        'matkhaubam'
                                    ), array(
                                        $email,
                                        password_hash($matkhau, PASSWORD_DEFAULT)
                                    ), 'tendangnhap', $tendangnhap);
                                } else {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'nguoidung', 'email', $email, 'tendangnhap', $tendangnhap);
                                }
                                
                                $db->updateMulDataRow(DB_TABLE_PREFIX.'quyen', array(
                                    'hovaten'
                                ), array(
                                    $hovaten
                                ), 'id', $id);
    
                                if ($_POST['chucvu']!=='') {
                                    $chucvu = $_POST['chucvu'];
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chucvu', $chucvu, 'tendangnhap', $tendangnhap);
                                } else {
                                    $chucvu = $_POST['chucvu'];
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chucvu', 0, 'tendangnhap', $tendangnhap);
                                }
    
                                if ($_POST['bomon']!=='') {
                                    $bomon = $_POST['bomon'];
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'bomon', $bomon, 'tendangnhap', $tendangnhap);
                                } else {
                                    $bomon = $_POST['bomon'];
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'bomon', 0, 'tendangnhap', $tendangnhap);
                                }
    
                                if (isset($_POST['chunhiemlop'])) {
                                    $chunhiem = $_POST['chunhiemlop'];
                                    if ($chunhiem==0) {
                                        $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', 0, 'tendangnhap', $tendangnhap);
                                    } else {
                                        $ktlop = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)', 'lop', $chunhiem);
                                        if ($ktlop>0) { // trong dslop có lớp được chỉ định
                                            $ktlop = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'COUNT(*)', 'chunhiem', $chunhiem);
                                            if ($ktlop > 0) { // trong table quyen có gv đã chủ nhiệm lớp đã chỉ định
                                                header("Location: $currentURL&chinhsuathanhcongnhungchunhiemdaco");
                                                $js = "Swal.fire({
                                                    title: 'Thành công!',
                                                    text: 'Chỉnh sửa thành công! Tuy nhiên lớp $chunhiem đã có giáo viên khác chủ nhiệm, vui lòng chỉnh sửa lại sau khi tắt thông báo này',
                                                    icon: 'success',
                                                    confirmButtonText: 'Ok'
                                                  })";
                                            } else {
                                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', $chunhiem, 'tendangnhap', $tendangnhap);
                                            }
                                        } else {
                                            header("Location: $currentURL&chinhsuathanhcongnhungkhongthaylopchidinhchunhiem");
                                            $js = "Swal.fire({
                                                title: 'Thành công!',
                                                text: 'Chỉnh sửa thành công! Tuy nhiên không tìm thấy tên lớp đã chỉ định, vui lòng chỉnh sửa lại sau khi tắt thông báo này',
                                                icon: 'success',
                                                confirmButtonText: 'Ok'
                                              })";
                                        }
                                    }
                                }
    
                                if (isset($_POST['c-diemdanh'])) {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'diemdanh', 1, 'tendangnhap', $tendangnhap);
                                } else {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'diemdanh', 0, 'tendangnhap', $tendangnhap);
                                }
    
                                if (isset($_POST['c-tkb'])) {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'tkb', 1, 'tendangnhap', $tendangnhap);
                                } else {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'tkb', 0, 'tendangnhap', $tendangnhap);
                                }
    
                                if (isset($_POST['c-sodaubai'])) {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'sodaubai', 1, 'tendangnhap', $tendangnhap);
                                } else {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'sodaubai', 0, 'tendangnhap', $tendangnhap);
                                }
    
                                if (isset($_POST['la_admin'])) {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'la_admin', 1, 'tendangnhap', $tendangnhap);
                                } else {
                                    $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'la_admin', 0, 'tendangnhap', $tendangnhap);
                                }
                                
                                header("Location: $currentURL&chinhsuathanhcong");
                            }
                        }

                        $nguoidungCanChinhSua = $db->getMulData(DB_TABLE_PREFIX.'quyen', array(
                            'tendangnhap',
                            'hovaten',
                            'chucvu',
                            'bomon',
                            'chunhiem',
                            'diemdanh',
                            'tkb',
                            'sodaubai',
                            'la_admin'
                        ), 'id', $id);

                        $tendangnhap = $nguoidungCanChinhSua[0]['tendangnhap'];
                        $hovaten = $nguoidungCanChinhSua[0]['hovaten'];
                        $email = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'email', 'tendangnhap', $tendangnhap);
                        $chucvu = $nguoidungCanChinhSua[0]['chucvu'];
                        if ($chucvu === '0') {
                            $chucvu = "";
                        }
                        $bomon = $nguoidungCanChinhSua[0]['bomon'];
                        if ($bomon === '0') {
                            $bomon = "";
                        }
                        $diemdanh = $nguoidungCanChinhSua[0]['diemdanh'];
                        $tkb = $nguoidungCanChinhSua[0]['tkb'];
                        $sodaubai = $nguoidungCanChinhSua[0]['sodaubai'];
                        $la_admin = $nguoidungCanChinhSua[0]['la_admin'];

                        $ktc_diemdanh = "";
                        $ktc_tkb = "";
                        $ktc_sodaubai = "";
                        $ktc_la_admin = "";

                        if ($diemdanh) {
                            $ktc_diemdanh = "checked";
                        }
                        if ($tkb) {
                            $ktc_tkb = "checked";
                        }
                        if ($sodaubai) {
                            $ktc_sodaubai = "checked";
                        }
                        if ($la_admin) {
                            $ktc_la_admin = "checked";
                        }

                        $content = "<h3 class='text-center'>Chỉnh sửa thành viên</h3>";
                        $content .= "<form method='POST'>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='inp-tendangnhap'><i class='fi-cnsuxl-user-tie-circle'></i></span>
                                    </div>
                                    <input value='$tendangnhap (Không thể thay đổi)' type='text' class='form-control' placeholder='Tên đăng nhập (không thể thay đổi)' aria-label='Tên đăng nhập' aria-describedby='inp-tendangnhap' disabled>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='inp-hovaten'><i class='fi-xwluxl-address-card-solid'></i></span>
                                    </div>
                                    <input value='$hovaten' required name='hovaten' type='text' class='form-control' placeholder='Họ và tên (*)' aria-label='Tên đăng nhập' aria-describedby='inp-hovaten'>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='inp-email'><i class='fi-xwsuxl-envelope-solid'></i></span>
                                    </div>
                                    <input value='$email' required name='email' type='email' class='form-control' placeholder='Email (*)' aria-label='Email' aria-describedby='inp-email'>
                                </div>
                                <div class='input-group mb-3'>
                                    <div class='input-group-prepend'>
                                        <span class='input-group-text' id='inp-matkhau'><i class='fi-cnsuxl-key-alt'></i></span>
                                    </div>
                                    <input name='matkhau' type='password' class='form-control' placeholder='Mật khẩu' aria-label='Mật khẩu' aria-describedby='inp-matkhau'>
                                </div>";

                        $content .= <<<HTML
                            <div class="form-group">
                                <label for="chunhiemlop">Chủ nhiệm lớp</label>
                                <select required class="form-control" id="chunhiemlop" name="chunhiemlop">
                                    <option value="0" selected>Không có</option>
                            HTML;
                        
                        $cackhoilop = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'));

                        if ($cackhoilop != 0) {
                            for ($i=0; $i < count($cackhoilop); $i++) { 
                                $khoi = $cackhoilop[$i]['khoi'];
                                $content .= "<option disabled>---- Khối $khoi ----</option>";
                                $dslop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array('lop'), 'khoi', $khoi);
                                if ($dslop!=0) {
                                    for ($j=0; $j < count($dslop); $j++) { 
                                        $lop = $dslop[$j]['lop'];
                                        $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'COUNT(*)', 'chunhiem', $lop);
                                        $gvcn = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $lop);
                                        if ($kiemtra > 0) {
                                            $content .= "<option disabled>Lớp $lop (GVCN: $gvcn)</option>";
                                        } else {
                                            $content .= "<option value='$lop'>Lớp $lop</option>";
                                        }
                                    }
                                }
                            }    
                        }
                        
                        
                        $content .= <<<HTML
                                </select>
                            </div>
                            HTML;


                        $content .= "<div class='input-group mb-3'>
                                    <input value='$chucvu' name='chucvu' type='text' class='form-control' placeholder='Chức vụ (Nếu không có thì bỏ trống)' aria-label='Chức vụ (Nếu không có thì bỏ trống)' aria-describedby='inp-chucvu'>
                                </div>
                                <div class='input-group mb-3'>
                                    <input value='$bomon' name='bomon' type='text' class='form-control' placeholder='Bộ môn (Nếu không có thì bỏ trống)' aria-label='Bộ môn (Nếu không thì bỏ trống)' aria-describedby='inp-bomon'>
                                </div>
                                <div class='container-fluid'>
                                    <div class='row'>
                                        <h4 class='text-center'>Quyền hạn (được phép truy cập vào trang...)</h4>
                                        <div class='col-6'>
                                            <div class='custom-control custom-checkbox'>
                                                <input $ktc_diemdanh name='c-diemdanh' type='checkbox' class='custom-control-input' id='c-diemdanh'>
                                                <label class='custom-control-label' for='c-diemdanh'>Quản lý điểm danh</label>
                                            </div>
                                            <div class='custom-control custom-checkbox'>
                                                <input $ktc_sodaubai name='c-sodaubai' type='checkbox' class='custom-control-input' id='c-sodaubai'>
                                                <label class='custom-control-label' for='c-sodaubai'>Quản lý sổ đầu bài</label>
                                            </div>
                                        </div>
                                        <div class='col-6'>
                                            <div class='custom-control custom-checkbox'>
                                                <input $ktc_tkb name='c-tkb' type='checkbox' class='custom-control-input' id='c-tkb'>
                                                <label class='custom-control-label' for='c-tkb'>Quản lý thời khoá biểu</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='custom-control custom-checkbox'>
                                            <input $ktc_la_admin name='la_admin' type='checkbox' class='custom-control-input' id='c-qtv'>
                                            <label class='custom-control-label' for='c-qtv'><b>Trao quyền quản trị cho người dùng này?</b></label>
                                        </div>
                                    </div>
                                </div>
                                <p><b>Các ô bắt buộc phải nhập được đánh dấu (*)</b></p>
                                <button class='btn btn-success btn-block'>Chỉnh sửa thành viên</button>
                            </form>";
                    } else {
                        $content = "<b>Không tìm thấy ID của người dùng đã xác định</b>";
                    }
                }
                break;

            case 'xoa':

                $dsthanhvien = $db->getMulData(DB_TABLE_PREFIX.'quyen', array(
                    'id',
                    'tendangnhap',
                    'hovaten',
                    'chucvu',
                    'bomon',
                    'chunhiem'
                ));
                $content = <<<HTML
                    <h3 class="text-center">Danh sách thành viên</h3>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">Tên đăng nhập</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Chức vụ</th>
                            <th scope="col">Bộ môn</th>
                            <th scope="col">Chủ nhiệm</th>
                            <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                    HTML;

                for ($i=0; $i < count($dsthanhvien); $i++) { 
                    $content .= "<tr>";
                    foreach ($dsthanhvien[$i] as $key => $value) {
                        if ($key != 'id') {
                            if ($value) {
                                $content .= "<td class='$key'>$value</td>";
                            } else {
                                $content .= "<td class='$key'>Không có</td>";
                            }
                        }
                    }
                    $content .= "<td class='chinhsua'><a class='btn btn-danger btn-block' href='?phuongthuc=xoa&id=".$dsthanhvien[$i]['id']."'>Xoá</a></td>";
                    $content .= "</tr>";
                }

                $content .= <<<HTML
                    </tbody>
                    </table>
                HTML;
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $ktid = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'COUNT(*)', 'id', $id);
                    if ($id == '') {
                        $content = "<b>Lỗi do người dùng định nghĩa ID rỗng</b>";
                    } elseif ($ktid > 0) {
                        $hoten = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'id', $id);
                        $tendangnhap = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'tendangnhap', 'id', $id);
                        $content = <<<HTML
                            <h3 class="text-center">Lưu ý</h3>
                            <p>Bạn có chắc rằng bạn muốn xoá người dùng <b>$hoten</b> có tên đăng nhập là <b>$tendangnhap</b> không?</p>
                            <p><b>Hãy suy nghĩ kỹ vì việc này sẽ xoá người dùng vĩnh viễn khỏi hệ thống!</b></p>
                            <p><b>Bên cạnh đó, những dữ liệu liên quan do người dùng này cập nhật sẽ được chuyển sang thành dữ liệu do bạn cập nhật!</b></p>
                            <form method="post">
                                <input type="hidden" name="xacnhan" value='true'>
                                <button class="btn btn-danger btn-block">Vẫn xoá</button>
                            </form>
                            <br>
                            <a href="?phuongthuc=xoa" class="btn btn-success btn-block">Trở về trang quản lý xoá người dùng</a>
                        HTML;
                        if (isset($_POST['xacnhan'])) {
                            $xacnhan = mysqli_real_escape_string($db->conn, $_POST['xacnhan']);
                            switch ($xacnhan) {
                                case 'true':
                                    // Xoá
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'quyen', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'nguoidung', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'phien', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'xacminh2buocemail', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'xacminhdoiemail', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'xacminhdoimatkhau', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'xm2b', 'tendangnhap', $tendangnhap);
                                    $db->deleteADataRow(DB_TABLE_PREFIX.'xm2btokenemail', 'tendangnhap', $tendangnhap);
                                    // Cập nhật
                                    $db->updateADataRow(DB_TABLE_PREFIX.'dsdiemdanhcaclop', 'nguoidung', $tennguoidung, 'nguoidung', $tendangnhap);
                                    $db->updateADataRow(DB_TABLE_PREFIX.'sodaubai', 'nguoidung', $tennguoidung, 'nguoidung', $tendangnhap);
                                    $content = <<<HTML
                                        <h3 class="text-center">Thành công!!</h3>
                                        <p>Đã xoá người dùng thành công khỏi hệ thống</p>
                                        <br>
                                        <a href="?phuongthuc=xoa" class="btn btn-success btn-block">Trở về trang quản lý xoá người dùng</a>
                                    HTML;
                                    break;
                                
                                default:
                                    $content = "<b>Đã xảy ra lỗi khi xoá người dùng, hãy thử lại!</b>";
                                    break;
                            }
                        }
                    } else {
                        $content = "<b>Không tìm thấy ID người dùng đã chỉ định</b>";
                    }
                }

                break;
            
            default:
            $content = "<b>Lỗi do người dùng định nghĩa sai phương thức!!</b>";
                break;
        }
    }

    require_once('../include/header.php');
    
    require_once('../include/menu_sadmin.php');
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <h3 class="text-center">Menu</h3>
                <a class="btn btn-success btn-block" href="?phuongthuc=tao">Thêm thành viên</a>
                <br>
                <a class="btn btn-info btn-block" href="?phuongthuc=chinhsua">Chỉnh sửa thành viên</a>
                <br>
                <a class="btn btn-danger btn-block" href="?phuongthuc=xoa">Xoá thành viên</a>
                <?php require_once('../include/thanhdieuhuong_sadmin.php') ?>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <?php echo $content ?>
            </div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
?>  
<?php 
    require_once('../include/footer.php');
    echo '<script>';
    echo $js;
    echo '</script>';
?>