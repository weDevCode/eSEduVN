<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    require_once('../include/loginCheck.php');
    require_once('../include/db.php');
    $pageName = 'Quản lý lớp';
    require_once('../include/init_include.php');
    require_once('../include/include.php');
?>


<?php 
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');
    $js = '';
    $content = "<p>Đây là trang dùng để quản lý danh sách các lớp và khối.</p>
    <p>Tại đây bạn có thể xem/thêm/chỉnh sửa/xoá một lớp và thêm/xoá một khối mà bạn cần</p>
    <p>Hãy tiếp tục bằng cách nhấn vào 1 trong 2 nút ở bên trái (máy tính) hoặc ở phía trên (điện thoại)</p>";
    if (isset($_GET['ds'])) {
        $ds = $_GET['ds'];
        switch ($ds) {
            case 'lop':
                $content = <<<HTML
                    <h3 class="text-center">Danh sách lớp</h3>
                    <a href="?ds=lop&phuongthuc=tao"><button class="btn btn-success">Thêm lớp mới</button></a>
                    <br>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Lớp</th>
                                <th scope="col">GVCN</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                    HTML;

                    $dskhoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                        'khoi'
                    ));
                    
                    if ($dskhoi!=0) {
                        for ($i=0; $i < count($dskhoi); $i++) { 
                            $dslop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array(
                                'id',
                                'lop',
                            ), 'khoi', $dskhoi[$i]['khoi']);
                            if ($dslop != 0) {
                                for ($j=0; $j < count($dslop); $j++) { 
                                    $content .= "<tr>";
                                    foreach ($dslop[$j] as $key => $value) {
                                        if ($key != 'id') {
                                            $content .= "<td class='$key'>$value</td>";
                                            if ($key == 'lop') {
                                                $gvcn = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $value);
                                                if ($gvcn === 0) {
                                                    $content .= "<td class='gvcn'>Không có</td>";
                                                } else {
                                                    $content .= "<td class='gvcn'>$gvcn</td>";
                                                }
                                            }
                                        }
                                    }
                                    $content .= "<td class='thaotac'>
                                    <a href='?ds=lop&phuongthuc=chinhsua&id=".$dslop[$j]['id']."'><button class='btn btn-info'>Chỉnh sửa</button></a>
                                    <a href='?ds=lop&phuongthuc=xoa&id=".$dslop[$j]['id']."'><button class='btn btn-danger'>Xoá</button></a>
                                    </td>";
                                    $content .= "</tr>";
                                }
                            }
                        }
                    }

                    $dslop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array(
                        'id',
                        'lop',
                        'khoi',
                    ));

                    $content .= <<<HTML
                        </tbody>
                        </table>
                    HTML;


                    // Xác định phương thức
                    if (isset($_GET['phuongthuc'])) {
                        $phuongthuc = $_GET['phuongthuc'];
                        switch ($phuongthuc) {
                            case 'tao':
                                $dskhoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                                    'khoi'
                                ));
                                if ($dskhoi!=0) {
                                    $content = <<<HTML
                                    <h3 class="text-center">Thêm lớp mới</h3>
                                    <form method="POST">
                                        <p>Tên lớp: <select name="khoi" id="khoi">
                                    HTML;
                                    for ($i=0; $i < count($dskhoi); $i++) { 
                                        $khoi = $dskhoi[$i]['khoi'];
                                        $content .= "<option value='$khoi'>$khoi</option>";
                                    }
                                    $content .= <<<HTML
                                            </select><span> / </span>
                                            <input name="lop" type="number" style="width: 5%" required min="1" max="20"></p>
                                            <label for="chunhiem">GVCN: </label>
                                            <select name="chunhiem" id="chunhiem" class="form-control" required>
                                                <option selected value="0">Không có</option>
                                    HTML;

                                    $dsgv = $db->getMulData(DB_TABLE_PREFIX.'quyen', array(
                                        'id',
                                        'hovaten',
                                        'bomon'
                                    ));
                                    for ($i=0; $i < count($dsgv); $i++) { 
                                        $id = $dsgv[$i]['id'];
                                        $hoten = $dsgv[$i]['hovaten'];
                                        $bomon = $dsgv[$i]['bomon'];
                                        if ($bomon === '0') {
                                            $bomon = 'Không có';
                                        }
                                        // Kiểm tra xem gv có đang chủ nhiệm lớp nào không
                                        $kiemtragvcnlop = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'chunhiem', 'id', $id);
                                        if ($kiemtragvcnlop == 0) {
                                            $content .= "<option value='$id'>GV: $hoten ($bomon)</option>";
                                        } else {
                                            $content .= "<option disabled>GV: $hoten ($bomon) đang chủ nhiệm lớp $kiemtragvcnlop</option>";
                                        }
                                        
                                    }
                                    $content .= <<<HTML
                                            </select><br>
                                            <button class="btn btn-success btn-block">Thêm mới</button>
                                        </form>
                                    HTML;

                                    if (isset($_POST['lop'])) {
                                        $lopso = $_POST['lop'];
                                        $js = "Swal.fire({
                                            title: 'Thành công!',
                                            text: 'Thêm lớp mới thành công. Hãy chuyển sang trang danh sách lớp để xem!',
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        })";
                                        
                                        $khoi = $_POST['khoi'];
                                        for ($i=0; $i < count($dskhoi); $i++) { 
                                            if ($khoi==$dskhoi[$i]['khoi']) {
                                                $kiemtrakhoi = 1;
                                                break;
                                            } else {
                                                $kiemtrakhoi = 0;
                                            }
                                        }
                                        
                                        $lop = "$khoi/$lopso";
                                        if ($dslop!=0) {
                                            for ($i=0; $i < count($dslop); $i++) { 
                                                if ($lop==$dslop[$i]['lop']) {
                                                    $kiemtralop = 1;
                                                    break;
                                                } else {
                                                    $kiemtralop = 0;
                                                }
                                            }
                                        } else {
                                            $kiemtralop = 0;
                                        }
                                        

                                        $gvcn = $_POST['chunhiem'];
                                        for ($i=0; $i < count($dsgv); $i++) { 
                                            if ($gvcn==0 || ($gvcn==$dsgv[$i]['id'])) {
                                                // Xem người dùng có chọn chính xác giáo viên hay không
                                                $kiemtragv = 1;
                                                // Kiểm tra xem gv có chủ nhiệm lớp nào không
                                                $ktgvdachunhiem = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'chunhiem', 'id', $gvcn);
                                                if ($ktgvdachunhiem != 0) {
                                                    $ktgvdachunhiem = 1;
                                                } else {
                                                    $ktgvdachunhiem = 0;
                                                }
                                                break;
                                            } else {
                                                $kiemtragv = 0;
                                                $ktgvdachunhiem = 0;
                                            }
                                        }
                                        if ($kiemtrakhoi == 0) {
                                            $js = "Swal.fire({
                                                title: 'Lỗi!',
                                                text: 'Không tồn tại khối bạn đã xác định!',
                                                icon: 'error',
                                                confirmButtonText: 'Ok'
                                            })";
                                        } elseif ($lopso <= 0 || $lopso > 20) {
                                            $js = "Swal.fire({
                                                title: 'Lỗi!',
                                                text: 'Giá trị ô lớp phải lớn hơn 0 hoặc nhỏ hơn hoặc bằng 20!',
                                                icon: 'error',
                                                confirmButtonText: 'Ok'
                                            })";
                                        } elseif (!is_numeric($lopso)){
                                            $js = "Swal.fire({
                                                title: 'Lỗi!',
                                                text: 'Giá trị ô lớp phải là giá trị số!',
                                                icon: 'error',
                                                confirmButtonText: 'Ok'
                                            })";
                                        } elseif ($kiemtragv == 0) {
                                            $js = "Swal.fire({
                                                title: 'Lỗi!',
                                                text: 'Không tồn tại giáo viên bạn đã chỉ định!',
                                                icon: 'error',
                                                confirmButtonText: 'Ok'
                                            })";
                                        } elseif ($ktgvdachunhiem == 1) {
                                            $js = "Swal.fire({
                                                title: 'Lỗi!',
                                                text: 'Giáo viên bạn chỉ định đang chủ nhiệm lớp khác!',
                                                icon: 'error',
                                                confirmButtonText: 'Ok'
                                            })";
                                        } elseif ($kiemtralop==1) {
                                            $js = "Swal.fire({
                                                title: 'Lỗi!',
                                                text: 'Lớp $lop đã tồn tại!',
                                                icon: 'error',
                                                confirmButtonText: 'Ok'
                                            })";
                                        } else {
                                            $db->insertMulDataRow(DB_TABLE_PREFIX.'dslop', array(
                                                'lop',
                                                'khoi'
                                            ), array(
                                                $lop,
                                                $khoi
                                            ));
                                            if ($gvcn != 0) {
                                                $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', $lop, 'id', $id);
                                            }
                                        }
                                    }
                                } else {
                                    $content = "<b>Bạn phải thêm khối trước khi tạo lớp</b>";
                                }
                                break;

                            case 'chinhsua':
                                
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    for ($i=0; $i < count($dslop); $i++) { 
                                        if ($dslop[$i]['id']==$id) {
                                            $ktralop = 1;
                                            $lop = $dslop[$i]['lop'];
                                            break;
                                        } else {
                                            $ktralop = 0;
                                        }
                                    }
                                    switch ($ktralop) {
                                        case 1:
                                            $content = "<h3 class='text-center'>Chỉnh sửa lớp $lop</h3>";
                                            $content .= <<<HTML
                                                <form method="POST">    
                                                    <label for="chunhiem">GVCN: </label>
                                                    <select name="chunhiem" id="chunhiem" class="form-control" required>
                                                    <option selected value="0">Không có</option>
                                            HTML;

                                            $dsgv = $db->getMulData(DB_TABLE_PREFIX.'quyen', array(
                                                'id',
                                                'hovaten',
                                                'bomon'
                                            ));
                                            for ($i=0; $i < count($dsgv); $i++) { 
                                                $id = $dsgv[$i]['id'];
                                                $hoten = $dsgv[$i]['hovaten'];
                                                $bomon = $dsgv[$i]['bomon'];
                                                if ($bomon === '0') {
                                                    $bomon = 'Không có';
                                                }
                                                // Kiểm tra xem gv có đang chủ nhiệm lớp nào không
                                                $kiemtragvcnlop = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'chunhiem', 'id', $id);
                                                if ($kiemtragvcnlop == 0) {
                                                    $content .= "<option value='$id'>GV: $hoten ($bomon)</option>";
                                                } else {
                                                    $content .= "<option disabled>GV: $hoten ($bomon) đang chủ nhiệm lớp $kiemtragvcnlop</option>";
                                                }
                                            }
                                            $content .= <<<HTML
                                                    </select><br>
                                                    <button class="btn btn-info btn-block">Chỉnh sửa</button>
                                                </form>
                                            HTML;
                                            $gvcnHienTai = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'id', 'chunhiem', $lop);
                                            if (isset($_POST['chunhiem'])) {
                                                $js = "Swal.fire({
                                                    title: 'Thành công!',
                                                    text: 'Chỉnh sửa lớp thành công!',
                                                    icon: 'success',
                                                    confirmButtonText: 'Ok'
                                                })";
                                                $gvcn = $_POST['chunhiem'];
                                                for ($i=0; $i < count($dsgv); $i++) { 
                                                    if ($gvcn==0 || ($gvcn==$dsgv[$i]['id'])) {
                                                        // Xem người dùng có chọn chính xác giáo viên hay không
                                                        $kiemtragv = 1;
                                                        // Kiểm tra xem gv có chủ nhiệm lớp nào không
                                                        $ktgvdachunhiem = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'chunhiem', 'id', $gvcn);
                                                        if ($ktgvdachunhiem != 0) {
                                                            $ktgvdachunhiem = 1;
                                                        } else {
                                                            $ktgvdachunhiem = 0;
                                                        }
                                                        break;
                                                    } else {
                                                        $kiemtragv = 0;
                                                        $ktgvdachunhiem = 0;
                                                    }
                                                }

                                                if ($kiemtragv == 0) {
                                                    $js = "Swal.fire({
                                                        title: 'Lỗi!',
                                                        text: 'Không tồn tại giáo viên bạn đã chỉ định!',
                                                        icon: 'error',
                                                        confirmButtonText: 'Ok'
                                                    })";
                                                } elseif ($ktgvdachunhiem == 1) {
                                                    $js = "Swal.fire({
                                                        title: 'Lỗi!',
                                                        text: 'Giáo viên bạn chỉ định đang chủ nhiệm lớp khác!',
                                                        icon: 'error',
                                                        confirmButtonText: 'Ok'
                                                    })";
                                                } else {
                                                    if ($gvcn != 0) {
                                                        $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', $lop, 'id', $gvcn);
                                                        $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', '', 'id', $gvcnHienTai);
                                                    } else {
                                                        $db->updateADataRow(DB_TABLE_PREFIX.'quyen', 'chunhiem', '', 'id', $gvcnHienTai);
                                                    }
                                                }
                                            }
                                            break;
                                        
                                        default:
                                            $content = "<p><b>Lỗi do người dùng định nghĩa id không tồn tại!</b></p>";
                                            break;
                                    }
                                }
                                break;

                            case 'xoa':
                                
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];
                                    for ($i=0; $i < count($dslop); $i++) { 
                                        if ($dslop[$i]['id']==$id) {
                                            $ktralop = 1;
                                            $lop = $dslop[$i]['lop'];
                                            break;
                                        } else {
                                            $ktralop = 0;
                                        }
                                    }
                                    switch ($ktralop) {
                                        case 1:

                                            $content = "<h3 class='text-center'>Xoá lớp $lop</h3>";
                                            $content .= "<p>Bạn có muốn xoá lớp <b>$lop</b> không? Một khi bạn thực hiện thao tác rồi thì <b>lớp này sẽ bị xoá hoàn toàn khỏi CSDL!</b></p>";
                                            $content .= <<<HTML
                                                <form method="POST">
                                                    <input name="xacnhan" type="hidden" value="true"><br>
                                                    <button class="btn btn-danger btn-block">Vẫn xoá</button>
                                                </form>
                                                <br><a href="?ds=lop"><button class="btn btn-success btn-block">Về trang trước</button></a>
                                            HTML;

                                            if (isset($_POST['xacnhan'])) {
                                                $xacnhan = $_POST['xacnhan'];
                                                if ($xacnhan == 'true') {
                                                    $js = "Swal.fire({
                                                        title: 'Thành công!',
                                                        text: 'Đã xoá lớp $lop thành công, quay về trang danh sách lớp!',
                                                        icon: 'success',
                                                        confirmButtonText: 'Ok'
                                                    })
                                                    setTimeout(function(){ location.replace('?ds=lop');}, 3000);";
                                                    $db->deleteADataRow(DB_TABLE_PREFIX.'dslop', 'lop', $lop);
                                                }
                                            }
                                            break;
                                        
                                        default:
                                            $content = "<p><b>Lỗi do người dùng định nghĩa id không tồn tại!</b></p>";
                                            break;
                                    }
                                }
                                break;
                            
                            default:
                                $content = "<b>Lỗi do người dùng định nghĩa sai phương thức</b>'";
                                break;
                        }
                    }

                break;

            case 'khoi':
                $dskhoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                    'id',
                    'khoi'
                ));

                $content = <<<HTML
                    <h3 class="text-center">Danh sách khối</h3>
                    <a href="?ds=khoi&phuongthuc=tao"><button class="btn btn-success">Thêm khối mới</button></a>
                    <br>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Khối</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                HTML;
                if ($dskhoi!=0) {
                    for ($i=0; $i < count($dskhoi); $i++) { 
                        $khoi = $dskhoi[$i]['khoi'];
                        $content .= "<tr>";
                        $content .= "<td class='khoi'>$khoi</td>";
                        $content .= "<td class='thaotac'>
                        <a href='?ds=khoi&phuongthuc=xoa&id=".$dskhoi[$i]['id']."'><button class='btn btn-danger'>Xoá</button></a>
                        </td>";
                        $content .= "</tr>";
                    }
                }
                
                $content .= <<<HTML
                        </tbody>
                        </table>
                    HTML;

                if (isset($_GET['phuongthuc'])) {
                    $phuongthuc = $_GET['phuongthuc'];
                    switch ($phuongthuc) {
                        case 'tao':
                            $content = "<h3 class='text-center'>Tạo khối mới</h3>";
                            $content .= <<<HTML
                                <form method="POST">
                                    <label for="khoi">Khối</label>
                                    <input id="khoi" name="khoi" type="number" required min="1" max="12">
                                    <br><button class="btn btn-success btn-block">Tạo</button>
                                </form>
                            HTML;
                            
                            if (isset($_POST['khoi'])) {
                                $khoi = $_POST['khoi'];
                                if ($dskhoi!=0) {
                                    for ($i=0; $i < count($dskhoi); $i++) { 
                                        if ($khoi == $dskhoi[$i]['khoi']) {
                                            $ktkhoi = 1;
                                            break;
                                        } else {
                                            $ktkhoi = 0;
                                        }
                                    }
                                } else {
                                    $ktkhoi = 0;
                                }
                                if ($khoi <= 0 || $khoi > 12) {
                                    $js = "Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Khối phải lớn hơn 0 và bé hơn hoặc bằng 12!',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })";
                                } elseif (!is_numeric($khoi)) {
                                    $js = "Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Khối phải là 1 số!',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })";
                                } elseif ($ktkhoi == 1) {
                                    $js = "Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Khối đã tồn tại!',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })";
                                } else {
                                    $js = "Swal.fire({
                                        title: 'Thành công!',
                                        text: 'Tạo khối mới thành công, đang chuyển hướng về trang danh sách khối!',
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    })
                                    setTimeout(function(){ location.replace('?ds=khoi');}, 3000);";
                                    $db->insertADataRow(DB_TABLE_PREFIX.'dskhoi', 'khoi', $khoi);
                                    $db->insertADataRow(DB_TABLE_PREFIX.'quydinh', 'khoi', $khoi);
                                }
                            }
                        break;

                        case 'xoa':
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $khoi = $db->getSingleData(DB_TABLE_PREFIX.'dskhoi', 'khoi', 'id', $id);
                                $content = "<h3 class='text-center'>Xoá khối</h3>";
                                $content .= "<p><b>Cảnh báo:</b> xoá khối <b>$khoi</b> đồng nghĩa với việc <b>toàn bộ lớp trong khối này sẽ bị xoá vĩnh viễn</b>";
                                $content .= <<<HTML
                                    <form method="POST">
                                        <input name="xacnhan" type="hidden" value="true">
                                        <br><button class="btn btn-danger btn-block">Vẫn xoá</button>
                                    </form>
                                HTML;

                                if (isset($_POST['xacnhan'])) {
                                    $xacnhan = $_POST['xacnhan'];
                                    if ($xacnhan == 'true') {
                                        $js = "Swal.fire({
                                            title: 'Thành công!',
                                            text: 'Xoá khối $khoi thành công, đang chuyển hướng về trang danh sách khối!',
                                            icon: 'success',
                                            confirmButtonText: 'Ok'
                                        })
                                        setTimeout(function(){ location.replace('?ds=khoi');}, 3000);";
                                        $db->deleteADataRow(DB_TABLE_PREFIX.'dskhoi', 'khoi', $khoi);
                                        $db->deleteADataRow(DB_TABLE_PREFIX.'dslop', 'khoi', $khoi);
                                        $db->deleteADataRow(DB_TABLE_PREFIX.'quydinh', 'khoi', $khoi);
                                    }
                                }
                            }
                        break;
                        
                        default:
                            $content = "<b>Lỗi do người dùng định nghĩa sai phương thức</b>'";
                            break;
                    }
                }
            break;
            case 'buoihoc':
                $content = <<<HTML
                    <h3 class="text-center">Danh sách khối</h3>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Lớp</th>
                                <th scope="col">Buổi</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                HTML;
                $dskhoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                    'id',
                    'khoi'
                ));
                for ($i=0; $i < count($dskhoi); $i++) { 
                    if ($dskhoi != 0) {
                        $content .= "<tr>";
                        $content .= "<td class='khoi'>".$dskhoi[$i]['khoi']."</td>";
                        $buoihoc = $db->getSingleData(DB_TABLE_PREFIX.'quydinh', 'buoi', 'khoi', $dskhoi[$i]['khoi']);
                        if ($buoihoc===0 || $buoihoc==='') {
                            $content .= "<td class='buoihoc'>Không có</td>";
                        } elseif ($buoihoc=='sang') {
                            $content .= "<td class='buoihoc'>Sáng</td>";
                        } else {
                            $content .= "<td class='buoihoc'>Chiều</td>";
                        }
                        $content .= "<td class='thaotac'>
                        <a href='?ds=buoihoc&id=".$dskhoi[$i]['id']."'><button class='btn btn-info'>Chỉnh sửa</button></a>
                        </td>";
                        $content .= "</tr>";
                    }
                }
                
                $content .= <<<HTML
                        </tbody>
                        </table>
                    HTML;

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'dskhoi', 'COUNT(*)', 'id', $id);
                    if ($kiemtra==0) {
                        $content = "<b>Lỗi do người dùng định nghĩa ID không tồn tại</b>";
                    } else {
                        $khoi = $db->getSingleData(DB_TABLE_PREFIX.'dskhoi', 'khoi', 'id', $id);
                        $content = "<h3 class='text-center'>Chỉnh sửa buổi học khối $khoi</h3>";
                        $content .= "<form method='POST'>
                        <label for='buoihoc'>Buổi</label>
                        <select id='buoihoc' name='buoihoc'>
                            <option value='sang' selected>Sáng</option>
                            <option value='chieu'>Chiều</option>
                        </select>
                        <button class='btn btn-success btn-block'>Lưu</button>
                        </form>";
                        if (isset($_POST['buoihoc'])) {
                            $buoihoc = $_POST['buoihoc'];
                            if ($buoihoc=='sang'||$buoihoc=='chieu') {
                                $db->updateADataRow(DB_TABLE_PREFIX.'quydinh', 'buoi', $buoihoc, 'khoi', $khoi);
                                $js = "Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Chỉnh sửa buổi học thành công! Đang chuyển hướng...',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })
                                setTimeout(function(){ location.replace('?ds=buoihoc') }, 3000);";
                            } else {
                                $content = "Lỗi do người dùng định nghĩa sai buổi học";
                            }
                        }
                    }
                }

            break;

            default:
                $content = '<b>Lỗi do người dùng định nghĩa sai phương thức</b>';
                break;
        }
    }
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center"><?php echo $pageName ?></h2>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <h3 class="text-center">Menu</h3>
            <a href="?ds=lop"><button class="btn btn-info btn-block">Quản lý danh sách lớp</button></a><br>
            <a href="?ds=khoi"><button class="btn btn-info btn-block">Quản lý danh sách khối</button></a><br>
            <a href="?ds=buoihoc"><button class="btn btn-info btn-block">Quản lý danh sách buổi học</button></a>
            <?php require_once('../include/thanhdieuhuong_sadmin.php') ?>
        </div>
        <div class="col-lg-8 col-md-4 col-12">
            <?php echo $content ?>
        </div>
    </div>
</div>

<?php 
    require_once('../include/footer-module.php');
    require_once('../include/footer.php');
    echo '<script>';
    echo $js;
    echo '</script>';
?>