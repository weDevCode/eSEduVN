<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);
    
    require_once('../include/loginCheck.php');
    
    require_once('../include/db.php');

    $pageName = 'Quản lý thời khoá biểu';

    require_once('../include/init_include.php');

    require_once('../include/ktDsLop.php');

    require_once('../include/include.php');

    require_once('../include/ktquyennguoidung.php');

    ktQuyen('tkb');

?>

<?php 
    $js = '';
    require_once('../include/include.php');
    $soluongTKB = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'COUNT(*)');
    if ($soluongTKB == 0) {
        $content = "<p>Xin chào, <b style='color: red'>$tennguoidung</b></p><b>Bạn chưa tạo thời khoá biểu nào. Hãy nhấn nút bên dưới để tạo thời khoá biểu mới<br>
        Hoặc bạn có thể nhấn vào liên kết của từng lớp ở thanh bên trái. Nếu lớp đó chưa có TKB thì hệ thống sẽ tự tạo <br>
        Nếu có rồi thì dùng để chỉnh sửa TKB hiện có</b><br>
        <a href='$url/thoikhoabieu/quanly?phuongthuc=tao' class='btn btn-success btn-block'>Tạo thời khoá biểu mới</a>";
    } else {
        $content = "<p>Xin chào, <b style='color: red'>$tennguoidung</b></p>Đây là trang quản lý thời khoá biểu, hiện số lượng thời khoá biểu đã thiết lập là <b>$soluongTKB</b><br>
        Bạn có thể tạo thêm thời khoá biểu cho từng lớp bằng cách nhấn vào nút bên dưới
        <a href='$url/thoikhoabieu/quanly?phuongthuc=tao' class='btn btn-success btn-block'>Tạo thời khoá biểu mới</a>";
    }
    if (isset($_GET['phuongthuc'])) {
        $phuongthuc = $_GET['phuongthuc'];
        switch ($phuongthuc) {
            case 'tao':
                $content = <<<HTML
                <h3 class='text-center'>Tạo thời khoá biểu</h3>
                <form method="POST">
                    <textarea name="khungtkb" id="khungtkb" style="width: 100%; max-width: 100%; padding: 20px; height: 600px" rows="10"></textarea>
                    <select name="lop" class="custom-select">
                    <option selected value="notselectedyet">Hãy chọn lớp để thêm thời khoá biểu</option>
                HTML;

                $cackhoilop = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'));

                for ($i=0; $i < count($cackhoilop); $i++) { 
                    $khoi = $cackhoilop[$i]['khoi'];
                    $content .= "<option disabled>---- Khối $khoi ----</option>";
                    $dslop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array('lop'), 'khoi', $khoi);
                    for ($j=0; $j < count($dslop); $j++) { 
                        $lop = $dslop[$j]['lop'];
                        $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'COUNT(*)', 'lop', $lop);
                        if ($kiemtra > 0) {
                            $content .= "<option disabled>Lớp $lop (đã tạo)</option>";
                        } else {
                            $content .= "<option value='$lop'>Lớp $lop</option>";
                        }
                        
                    }
                }

                $content .= <<<HTML
                    </select>
                    <button class="btn btn-info btn-block">Lưu</button>
                </form>
                HTML;
                if (isset($_POST['khungtkb'])&&isset($_POST['lop'])) {
                    $noidung = $_POST['khungtkb'];
                    $lop = $_POST['lop'];
                    if ($lop == "notselectedyet") {
                        $js = <<<HTML
                        <script>
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Bạn phải chọn lớp để tạo thời khoá biểu',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        </script>
                        HTML;
                    } else {
                        $timkiem = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'COUNT(*)', 'lop', $lop);
                        if ($timkiem > 0) {
                            $id = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'id', 'lop', $lop);
                            $lienketchinhsua = $url."/thoikhoabieu/quanly?phuongthuc=chinhsua&id=$id";
                            $js .= "<script>
                                Swal.fire({
                                    title: 'Lỗi!',
                                    text: 'Thời khoá biểu cho lớp $lop đã tồn tại! Đang chuyển hướng đến trang chỉnh sửa trong 3 giây...',
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                })
                                setTimeout(function(){ 
                                    window.location.replace('$lienketchinhsua');
                                }, 3000);
                            </script>";
                        } else {
                            $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)','lop',$lop);
                            if ($kiemtra > 0) {
                                $id_moi_insert = $db->insertMulDataRow(DB_TABLE_PREFIX.'tkb', array(
                                    'lop',
                                    'noidung'
                                ),array(
                                    $lop,
                                    $noidung
                                ));
                                $lienketchinhsua = $url."/thoikhoabieu/quanly?phuongthuc=chinhsua&id=$id_moi_insert";
                                $js .= "<script>
                                    Swal.fire({
                                        title: 'Thành công!',
                                        text: 'Bạn đã tạo thời khoá biểu cho lớp $lop thành công, đang chuyển hướng đến trang chỉnh sửa trong 3 giây...',
                                        icon: 'success',
                                        confirmButtonText: 'Ok'
                                    })
                                    setTimeout(function(){ 
                                        window.location.replace('$lienketchinhsua');
                                    }, 3000);
                                </script>";
                            } else {
                                $js .= "<script>
                                    Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Yêu cầu không hợp lệ, hãy thử lại',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })
                                </script>";
                            }
                        }
                    }
                }
                break;
            case 'chinhsua':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $noidung = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'noidung', 'id', $id);
                    if ($noidung === 0) {
                        $content = "<b>Lỗi! Không tìm thấy thời khoá biểu! <br>
                        Bạn có thể tạo thời khoá biểu mới bằng cách nhấn vào nút bên dưới
                        <a href='$url/thoikhoabieu/quanly?phuongthuc=tao' class='btn btn-success btn-block'>Tạo thời khoá biểu mới</a>
                        </b>";
                    } else {
                        $lop = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'lop', 'id', $id);

                        $chunhiemlophientai = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $lop);

                        if ($chunhiemlophientai === '0') {
                            $chunhiemlophientai = 'Không có';
                        }

                        $content = 
                        "<h3 class='text-center'>Chỉnh sửa thời khoá biểu</h3>
                        <p>Bạn đang chỉnh sửa thời khoá biểu của lớp <b>$lop</b> (GVCN: $chunhiemlophientai)</p>
                        <form method='POST'>
                            <textarea name='khungtkb' id='khungtkb' style='width: 100%; max-width: 100%; padding: 20px; height: 600px' rows='10'>$noidung</textarea>
                            <button class='btn btn-info btn-block'>Lưu</button>
                        </form>";
                        if (isset($_POST['khungtkb'])) {
                            $noidung = $_POST['khungtkb'];
                            $db->updateADataRow(DB_TABLE_PREFIX.'tkb', 'noidung', $noidung, 'id', $id);
                            $content = 
                            "<form method='POST'>
                                <textarea name='khungtkb' id='khungtkb' style='width: 100%; max-width: 100%; padding: 20px; height: 600px' rows='10'>$noidung</textarea>
                                <button class='btn btn-info btn-block'>Lưu</button>
                            </form>";
                            $js .= "<script>
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Bạn đã cập nhật thời khoá biểu cho lớp $lop thành công!!',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                })
                            </script>";
                        }
                    }
                    
                } else {
                    $content = "<b>Lỗi do người dùng không định nghĩa tham số ID!";
                }
                break;
            
            default:
                $content = "<b>Đã có lỗi xảy ra do người dùng định nghĩa sai phương thức trên URL (thanh địa chỉ)</b>";
                break;
        }
    }
    
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_non_sadmin.php');
?>
<main>
    <div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-3 col-lg-4" id="dslop">
                <button id="dslopToggle" class="btn btn-info btn-block">Danh sách lớp (nhấn để hiện/ẩn)</button>
                <ul>
                    <?php 
                        echo "<a href='$url/thoikhoabieu/quanly?phuongthuc=tao' class='btn btn-success btn-block'>Tạo thời khoá biểu mới</a>";
                        $phtml = '';
                        $khoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                            'khoi'
                        ));
                        for ($i=0; $i < count($khoi); $i++) {
                            $_khoi = $khoi[$i]['khoi'];
                            $html = 
                            <<<HTML
                                <li>
                                    <h4>Khối $_khoi</h4>
                                    <div class="card">
                                        <div class="list-group list-group-flush">
                            HTML;
                            $cac_lop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array(
                                'lop',
                                'khoi'
                            ), 'khoi', $_khoi);
                            for ($j=0; $j < count($cac_lop); $j++) { 
                                $_lop = $cac_lop[$j]['lop'];
                                $id_lop = $db->getSingleData(DB_TABLE_PREFIX.'tkb','id','lop',$_lop);
                                if ($id_lop == 0) {
                                    $html .= "<span class='list-group-item text-dark' >Lớp $_lop</span>";
                                } else {
                                    $html .= "<a href='$url/thoikhoabieu/quanly?phuongthuc=chinhsua&id=$id_lop' class='list-group-item text-dark' style='font-weight: bold'>Lớp $_lop</a>";
                                }
                            }
                            $html .= 
                            <<<HTML
                                        </div>
                                    </div>
                                </li>
                            HTML;
                            $phtml .= $html;
                        }
                        echo $phtml;
                    ?>
                </ul>
            </div>
            <div class="col-12 col-md-9 col-lg-8" id="tkb">
                <?php echo $content ?>
            </div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
?>   

<script src="<?php echo $url ?>/include/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#khungtkb',
            plugins: "table autolink autosave save image link media mediaembed",
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen preview print | image media pageembed link anchor',
            language: 'vi',
            branding: false
        });
    </script>

<?php 
    require_once('../include/footer.php');
    echo $js;
?>