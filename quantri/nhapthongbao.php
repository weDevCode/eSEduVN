<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/init_include.php');
    
    require_once('../include/loginCheck.php');

    require_once('../include/db.php');

    require_once('../include/include.php');

    require_once('../include/ktngayluutru.php');

    require_once('../include/ktraAdmin.php');

    $pageName = 'Cập nhật thông báo';
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');

    $tieude = '';
    $noidung = '';
    $html = '';
    $trang= 1;
    $sendNotifyViaEmail = '';

    function thongBao($loinhan, $loai)
    {
        global $url;
        header('Location: '.$url."/quantri/capnhatthongbao?thongbao=$loai&loinhan=$loinhan!", true);
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

    if (!isset($_GET['id'])) {
        $buttonName = 'Đăng thông báo mới';
        $sendNotifyViaEmail = "<p><label for='guithongbao'>Gửi thông báo đến danh sách email đã đăng ký nhận thông báo? </label><input id='guithongbao' type='checkbox' name='guithongbao' checked></p>";
    } else {
        $id = mysqli_real_escape_string($db->conn, $_GET['id']);
        if ($id=='') {
            $id = 0;
        }
        $buttonName = 'Cập nhật thông báo hiện hành';

        if ($db->getSingleData(DB_TABLE_PREFIX.'thongbao', 'COUNT(*)', 'id', $id)==0) {
            thongBao('Lỗi, không tìm thấy thông báo bạn chỉ định!', 'thatbai');
        }

        $tieude = $db->getSingleData(DB_TABLE_PREFIX.'thongbao', 'tieude', 'id', $id);
        $noidung = $db->getSingleData(DB_TABLE_PREFIX.'thongbao', 'noidung', 'id', $id);
    }

    if (isset($_POST['tieude'])&&isset($_POST['noidung'])) {

        $tieude = mysqli_real_escape_string($db->conn, htmlspecialchars($_POST['tieude']));
        $noidung = mysqli_real_escape_string($db->conn, $_POST['noidung']);
        
        if (isset($_GET['id'])) {
            $id = mysqli_real_escape_string($db->conn, $_GET['id']);
            if ($id=='') {
                $id = 0;
            }

            $db->updateMulDataRow(DB_TABLE_PREFIX.'thongbao', array(
                'tieude',
                'noidung'
            ), array(
                $tieude,
                $noidung
            ), 'id', $id);

            thongBao("Cập nhật thông báo có mã số là $id thành công!", 'thanhcong');
        } else {
            require_once('../include/smtp.php');
            $db->insertMulDataRow(DB_TABLE_PREFIX.'thongbao', array(
                'tieude',
                'noidung'
            ), array(
                $tieude,
                $noidung
            ));

            if (isset($_POST['guithongbao'])) {

                if ($smtp) {
                    $dsEmail = $db->getMulData(DB_TABLE_PREFIX.'nhanthongbao', array('email'));

                    foreach ($dsEmail as $value) {
                        $dsEmailNhanThBao[] = $value['email'];
                    }

                    sendNotifyEmail($dsEmailNhanThBao, $tieude, $noidung);
                } else {
                    thongBao('Thêm thông báo mới thành công! Tuy nhiên do thông tin SMTP là rỗng nên hệ thống không thực hiện gửi email!', 'thanhcong');
                }

            }

            thongBao('Thêm thông báo mới thành công!', 'thanhcong');
        }
    }
    
    $count = $db->getSingleData(DB_TABLE_PREFIX.'thongbao', 'COUNT(*)');
    if ($count > 0) {
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
                <h3 class='card-title'>".$arr[$i]['tieude']." <a href='?id=".($i+1)."' class='btn btn-info'>Chỉnh sửa</a> <a href='?xoathongbaoid=".($i+1)."' class='btn btn-danger'>Xoá</a></h3></h3>
                ".$arr[$i]['noidung']."
                <h6><span class='badge badge-primary'>".$arr[$i]['thoigian']."</span></h6>
                </div>
            </div>";
        }

        $max = ceil($count/10);
    } else {
        $max = 0;
    }

    if (isset($_GET['xoathongbaoid'])) {
        $xoathongbaoid = $_GET['xoathongbaoid'];
        $db->deleteADataRow(DB_TABLE_PREFIX.'thongbao', 'id', $xoathongbaoid);
        thongBao("Xoá thông báo có ID $xoathongbaoid thành công!", 'thanhcong');
    }
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php echo $thongbaoHTML ?>
            </div>
        </div>
        <form method="post" class="row">
            <input type="text" value='<?php echo $tieude ?>' name="tieude" id="tieude" placeholder="Tiêu đề" class='form-control'>
            <textarea name="noidung" id="thongbao" style="width: 100%; max-width: 100%; padding: 20px" rows="20">
            <?php echo $noidung ?>
            </textarea>
            <button class="btn btn-success btn-block"><?php echo $buttonName ?></button>
            <?php echo $sendNotifyViaEmail ?>
        </form>
        <div class="row">
            <div class="col">
                <h2 class="text-center">Thông báo hiện hành</h2>
            </div>
        </div>
        
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
?>

<script src="<?php echo $url ?>/include/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#thongbao',
        branding: false
    });
</script>

<?php 
    require_once('../include/footer.php');
    echo '<script>';
    echo $js;
    echo '</script>';
?>