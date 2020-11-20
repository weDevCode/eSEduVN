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

    $pageName = 'Cập nhật dữ liệu';

    $thong_bao = '';

    require_once('../include/365ngay.php');

    require_once('../include/ktDsLop.php');
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');
?>

<?php 
    $html = '';
    $notify = '';
    $js = '';
    if (isset($_GET['phuongthuc'])) {
        $phuongthuc = $_GET['phuongthuc'];
        
        if (isset($_SESSION['ngay'])) {
            $ngay = $_SESSION['ngay'];
        } else {
            $ngay = '';
        }

        if (isset($_SESSION['lop'])) {
            $lop = $_SESSION['lop'];
        } else {
            $lop = '';
        }

        if (isset($_SESSION['tietso'])) {
            $tietso = $_SESSION['tietso'];
        } else {
            $tietso = '';
        }

        if (isset($_SESSION['sohsvang'])) {
            $sohsvang = $_SESSION['sohsvang'];
        } else {
            $sohsvang = '';
        }

        function kiemtraNgay($ngay)
        {
            global $db;
            
            $table = DB_TABLE_PREFIX.'luutrungay';
            
            $kqua = $db->getSingleData($table, 'COUNT(*)', 'ngay', $ngay);
            
            if ($kqua==0) {
            
                $db->insertADataRow($table, 'ngay', $ngay);
            
            } else {
            
                return;
            
            }

        }
        function ktraLop($lop)
        {
            global $db;

            $table = DB_TABLE_PREFIX.'dslop';
            
            $kqua = $db->getSingleData($table, 'COUNT(*)', 'lop', $lop);
            
            if ($kqua==0) {
            
                return false;
            
            } else {
            
                return true;
            
            } 
        }

        function thongBao($loinhan, $loai)
        {
            global $url, $phuongthuc;
            header('Location: '.$url."/quantri/capnhatdulieu?phuongthuc=$phuongthuc&thongbao=$loai&loinhan=$loinhan!", true);
            die();
        }

        switch ($phuongthuc) {
            case 'diemdanh':

                function diemDanh($lop, $tietso, $sohsvang, $ngay)
                {
                    global $db, $tennguoidung;

                    $table = DB_TABLE_PREFIX.'dsdiemdanhcaclop';

                    $ktra = $db->query("SELECT COUNT(*) FROM `$table` WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay';");
                    
                    $result = mysqli_fetch_assoc($ktra);
                    
                    if ($result["COUNT(*)"]>0) {
                    
                        $manghs = array();
                    
                        for ($i=1; $i <= $sohsvang; $i++) { 
                    
                            if ($_POST["hs-$i"]!='') {
                    
                                $hs = $_POST["hs-$i"];
                    
                                $manghs[$i] = mysqli_real_escape_string($db->conn, $hs);
                    
                            }
                    
                        }
                    
                        $noidung = serialize($manghs);
                    
                        $db->query("UPDATE $table
                        SET noidung='$noidung', nguoidung='$tennguoidung'
                        WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                    } else {
                        
                        $manghs = array();
                        
                        for ($i=1; $i <= $sohsvang; $i++) { 
                        
                            if ($_POST["hs-$i"]!='') {
                        
                                $hs = $_POST["hs-$i"];
                        
                                $manghs[$i] = mysqli_real_escape_string($db->conn, $hs);
                        
                            }
                        
                        }
                        
                        $noidung = serialize($manghs);
                        
                        $db->query("INSERT INTO $table (lop, tietso, noidung, ngay, nguoidung)
                        VALUES ('$lop', '$tietso', '$noidung', '$ngay', '$tennguoidung');");
                    }
                }
                function soHSVang($lop, $tietso, $sohsvang, $ngay)
                {
                    global $db;
                    
                    $table = DB_TABLE_PREFIX.'sohsvang';
                    
                    $kqua = $db->query("SELECT COUNT(*) FROM $table WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                    
                    if (mysqli_num_rows($kqua)>0) {
                    
                        $kqua = mysqli_fetch_assoc($kqua);
                    
                        if ($kqua['COUNT(*)']>0) {
                    
                            $db->query("UPDATE $table
                            SET sohsvang='$sohsvang'
                            WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                        
                        } else {
                            
                            $db->query("INSERT INTO $table (lop, sohsvang, tietso, ngay)
                            VALUES ('$lop', '$sohsvang', '$tietso', '$ngay');");
                        
                        }
                    
                    }
                
                }

                $pageName = 'Cập nhật thông tin điểm danh';

                if (isset($_POST['ngay']) && isset($_POST['sohsvang']) && isset($_POST['tietso']) && isset($_POST['lop'])) {
                    
                    $ngay = $_POST['ngay'];
                    
                    $_SESSION['ngay'] = $ngay;

                    $sohsvang = $_POST['sohsvang'];
                    
                    $_SESSION['sohsvang'] = $sohsvang;

                    $tietso = $_POST['tietso'];

                    $_SESSION['tietso'] = $tietso;
                    
                    $lop = $_POST['lop'];

                    $_SESSION['lop'] = $lop;

                    if ($ngay=='') {

                        thongBao('Vui lòng nhập ngày', 'thatbai');

                    } elseif ($sohsvang=='') {
                        
                        thongBao('Vui lòng nhập số học sinh vắng', 'thatbai');
                    
                    } elseif ($tietso=='') {

                        thongBao('Vui lòng nhập tiết học', 'thatbai');
                    
                    } elseif ($lop=='') {

                        thongBao('Vui lòng nhập lớp', 'thatbai');
                    
                    }

                    $ngay = date("d/m/Y", strtotime($ngay));

                    if (!ktraLop($lop)) {

                        thongBao('Sai tên lớp', 'thatbai');

                    }

                    kiemtraNgay($ngay);
                    
                    diemDanh($lop, $tietso, $sohsvang, $ngay);
                    
                    soHSVang($lop, $tietso, $sohsvang, $ngay);
                    
                    if ($tietso<5) {
                        $_SESSION['tietso'] = $_SESSION['tietso'] + 1;
                    } else {
                        $_SESSION['tietso'] = 1;
                    }

                    thongBao('', 'thanhcong');
                }

                $html = "<form method='post'>
                <label for='ngay'>Ngày cần cập nhật: </label>
                <input type='date' name='ngay' id='ngay' value='$ngay'>
                <label for='lop'>Lớp (Nhập đúng tên lớp - VD: 12/9): </label>
                <input type='text' name='lop' id='lop' value='$lop'>
                <label for='tietso'>Cập nhật cho tiết số: </label>
                <input type='number' min=1 max=5 name='tietso' id='tietso' value='$tietso'>
                <hr>
                <label for='sohsvang'>Số học sinh vắng</label>
                <input id='sohsvang' name='sohsvang' type='number' value='$sohsvang'><button id='luusohs'class='btn btn-success'>Cập nhật</button>
                <div id='noidung'></div>
                <button class='btn btn-success btn-block'>Cập nhật</button>
                </form>";

                $js .= 'document.getElementById("luusohs").onclick = function(e){
                    e.preventDefault();
                    noidung = document.getElementById("noidung");
                    sohsvang = document.getElementById("sohsvang").value;
                    noidung1 = `<form method="POST"><table class="table">
                    <thead>
                        <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Họ tên (có hoặc không dấu)</th>
                        </tr>
                    </thead>
                    <tbody>`;
                    let noidung2 = "";
                    for (i = 0; i < sohsvang; i++) {
                        j = i+1;
                        noidung2 += `<tr>
                        <th scope="row">${j}</th>
                        <td><input name="hs-${j}" placeholder="Họ và tên (Có hoặc không dấu)" style="width: 100%"></td>
                        </tr>`;
                    }
                    noidung3 = `</tbody>
                    </table>
                    <input type="hidden" value="${sohsvang}" name="sohs" required>`;
                    sohsvang = parseInt(sohsvang);
                    if (typeof sohsvang == "number") {
                        noidung.innerHTML = noidung1+noidung2+noidung3;
                    } else {
                        noidung.innerHTML = "Số học sinh phải là kiểu số!";
                    }
                }';

                $html .= "<br><a class='btn btn-info' href='?'>Quay về trang trước</a>";

                break;
            
            case 'sodaubai':

                $pageName = 'Cập nhật thông tin sổ đầu bài';


                function duLieuSDB($lop, $tietso, $noidung, $danhgia, $ngay)
                {
                
                    global $db, $tennguoidung;
                
                    $table = DB_TABLE_PREFIX.'sodaubai';

                    $noidung = mysqli_real_escape_string($db->conn, $noidung);
                
                    $danhgia = mysqli_real_escape_string($db->conn, $danhgia);
                
                    $ktra = $db->query("SELECT COUNT(*) FROM `$table` WHERE lop='$lop' AND tietso='$tietso';");
                
                    $result = mysqli_fetch_assoc($ktra);
                
                    if ($result["COUNT(*)"]>0) {
                
                        $db->query("UPDATE $table
                        SET noidung='$noidung', danhgia='$danhgia', nguoidung='$tennguoidung'
                        WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                    
                    } else {
                    
                        $db->query("INSERT INTO $table (lop, tietso, noidung, danhgia, ngay, nguoidung)
                        VALUES ('$lop', '$tietso', '$noidung', '$danhgia', '$ngay', '$tennguoidung');");

                        echo "INSERT INTO $table (lop, tietso, noidung, danhgia, ngay, nguoidung)
                        VALUES ('$lop', '$tietso', '$noidung', '$danhgia', '$ngay', '$tennguoidung');";
                    
                    }
                }

                if (isset($_POST['ngay']) && isset($_POST['tietso']) && isset($_POST['lop'])) {
                    
                    $ngay = $_POST['ngay'];
                    
                    $_SESSION['ngay'] = $ngay;
                    
                    $tietso = $_POST['tietso'];
                    
                    $_SESSION['tietso'] = $tietso;

                    $lop = $_POST['lop'];

                    $_SESSION['lop'] = $lop;

                    if ($ngay=='') {

                        thongBao('Vui lòng nhập ngày', 'thatbai');

                    } elseif ($tietso=='') {

                        thongBao('Vui lòng nhập tiết học', 'thatbai');
                    
                    } elseif ($lop=='') {

                        thongBao('Vui lòng nhập lớp', 'thatbai');
                    
                    }

                    if (isset($_POST['dulieu'])) {
                        
                        $dulieu = $_POST['dulieu'];

                    }

                    if (isset($_POST['danhgia'])) {

                        $danhgia = $_POST['danhgia'];

                    }

                    $ngay = date("d/m/Y", strtotime($ngay));

                    if (!ktraLop($lop)) {

                        thongBao('Sai tên lớp', 'thatbai');

                    }

                    kiemtraNgay($ngay);
                    
                    duLieuSDB($lop, $tietso, $dulieu, $danhgia, $ngay);
                    
                    if ($tietso<5) {
                        $_SESSION['tietso'] = $_SESSION['tietso'] + 1;
                    } else {
                        $_SESSION['tietso'] = 1;
                    }

                    thongBao('', 'thanhcong');
                }


                $html = "<form method='post'>
                    <label for='ngay'>Ngày cần cập nhật: </label>
                    <input type='date' name='ngay' id='ngay' value='$ngay'>
                    <label for='lop'>Lớp (Nhập đúng tên lớp - VD: 12/9): </label>
                    <input type='text' name='lop' id='lop' value='$lop'>
                    <label for='tietso'>Cập nhật cho tiết số: </label>
                    <input type='number' min=1 max=5 name='tietso' id='tietso' value='$tietso'>
                    <hr>
                    <textarea name='dulieu' id='dulieu' style='width: 100%; max-width: 100%; padding: 20px' rows='10'></textarea>
                    <label for='danhgia'>Đánh giá tiết học: </label>
                    <input id='danhgia' name='danhgia' type='text'>
                    <button class='btn btn-success btn-block'>Cập nhật</button>
                </form>";

                $js .= "tinymce.init({
                    selector: '#dulieu',
                    branding: false,
                    language: 'vi'
                });";

                $html .= "<br><a class='btn btn-info' href='?'>Quay về trang trước</a>";
                break;
            
            case 'diemdanhhangloat':

                function diemDanh($lop, $tietso, $sohsvang, $ngay)
                {
                    global $db, $tennguoidung;

                    $table = DB_TABLE_PREFIX.'dsdiemdanhcaclop';

                    $ktra = $db->query("SELECT COUNT(*) FROM `$table` WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay';");
                    
                    $result = mysqli_fetch_assoc($ktra);
                    
                    if ($result["COUNT(*)"]>0) {
                    
                        $manghs = array();
                    
                        for ($i=1; $i <= $sohsvang; $i++) { 
                    
                            if ($_POST["hs-$i"]!='') {
                    
                                $hs = $_POST["hs-$i"];
                    
                                $manghs[$i] = mysqli_real_escape_string($db->conn, $hs);
                    
                            }
                    
                        }
                    
                        $noidung = serialize($manghs);
                    
                        $db->query("UPDATE $table
                        SET noidung='$noidung', nguoidung='$tennguoidung'
                        WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                    } else {
                        
                        $manghs = array();
                        
                        for ($i=1; $i <= $sohsvang; $i++) { 
                        
                            if ($_POST["hs-$i"]!='') {
                        
                                $hs = $_POST["hs-$i"];
                        
                                $manghs[$i] = mysqli_real_escape_string($db->conn, $hs);
                        
                            }
                        
                        }
                        
                        $noidung = serialize($manghs);
                        
                        $db->query("INSERT INTO $table (lop, tietso, noidung, ngay, nguoidung)
                        VALUES ('$lop', '$tietso', '$noidung', '$ngay', '$tennguoidung');");
                    }
                }
                function soHSVang($lop, $tietso, $sohsvang, $ngay)
                {
                    global $db;
                    
                    $table = DB_TABLE_PREFIX.'sohsvang';
                    
                    $kqua = $db->query("SELECT COUNT(*) FROM $table WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                    
                    if (mysqli_num_rows($kqua)>0) {
                    
                        $kqua = mysqli_fetch_assoc($kqua);
                    
                        if ($kqua['COUNT(*)']>0) {
                    
                            $db->query("UPDATE $table
                            SET sohsvang='$sohsvang'
                            WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngay'");
                        
                        } else {
                            
                            $db->query("INSERT INTO $table (lop, sohsvang, tietso, ngay)
                            VALUES ('$lop', '$sohsvang', '$tietso', '$ngay');");
                        
                        }
                    
                    }
                
                }

                $pageName = 'Cập nhật thông tin điểm danh';

                if (isset($_POST['ngay']) && isset($_POST['sohsvang']) && isset($_POST['lop'])) {
                    
                    $ngay = $_POST['ngay'];
                    
                    $_SESSION['ngay'] = $ngay;

                    $sohsvang = $_POST['sohsvang'];
                    
                    $_SESSION['sohsvang'] = $sohsvang;
                    
                    $lop = $_POST['lop'];

                    $_SESSION['lop'] = $lop;

                    if ($ngay=='') {

                        thongBao('Vui lòng nhập ngày', 'thatbai');

                    } elseif ($sohsvang=='') {
                        
                        thongBao('Vui lòng nhập số học sinh vắng', 'thatbai');
                    
                    } elseif ($lop=='') {

                        thongBao('Vui lòng nhập lớp', 'thatbai');
                    
                    }

                    $ngay = date("d/m/Y", strtotime($ngay));

                    if (!ktraLop($lop)) {

                        thongBao('Sai tên lớp', 'thatbai');

                    }

                    kiemtraNgay($ngay);
                    
                    for ($i=1; $i < 6; $i++) { 
                        diemDanh($lop, $i, $sohsvang, $ngay);
                        soHSVang($lop, $i, $sohsvang, $ngay);
                    }
                    
                    thongBao('', 'thanhcong');
                }

                $html = "<form method='post'>
                <label for='ngay'>Ngày cần cập nhật: </label>
                <input type='date' name='ngay' id='ngay' value='$ngay'>
                <label for='lop'>Lớp (Nhập đúng tên lớp - VD: 12/9): </label>
                <input type='text' name='lop' id='lop' value='$lop'>
                <hr>
                <label for='sohsvang'>Số học sinh vắng</label>
                <input id='sohsvang' name='sohsvang' type='number' value='$sohsvang'><button id='luusohs'class='btn btn-success'>Cập nhật</button>
                <div id='noidung'></div>
                <button class='btn btn-success btn-block'>Cập nhật</button>
                </form>";

                $js .= 'document.getElementById("luusohs").onclick = function(e){
                    e.preventDefault();
                    noidung = document.getElementById("noidung");
                    sohsvang = document.getElementById("sohsvang").value;
                    noidung1 = `<form method="POST"><table class="table">
                    <thead>
                        <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Họ tên (có hoặc không dấu)</th>
                        </tr>
                    </thead>
                    <tbody>`;
                    let noidung2 = "";
                    for (i = 0; i < sohsvang; i++) {
                        j = i+1;
                        noidung2 += `<tr>
                        <th scope="row">${j}</th>
                        <td><input name="hs-${j}" placeholder="Họ và tên (Có hoặc không dấu)" style="width: 100%"></td>
                        </tr>`;
                    }
                    noidung3 = `</tbody>
                    </table>
                    <input type="hidden" value="${sohsvang}" name="sohs" required>`;
                    sohsvang = parseInt(sohsvang);
                    if (typeof sohsvang == "number") {
                        noidung.innerHTML = noidung1+noidung2+noidung3;
                    } else {
                        noidung.innerHTML = "Số học sinh phải là kiểu số!";
                    }
                }';

                $html .= "<br><a class='btn btn-info' href='?'>Quay về trang trước</a>";

                break;
            
            default:
                $html = 'Phương thức không tồn tại!';
                break;
        }
    } else {
        $html .= "<p>Hãy chọn 1 trong các phương thức bên dưới để bắt đầu: </p>
        <a class='btn btn-info' href='?phuongthuc=diemdanh'>Thêm/chỉnh sửa dữ liệu điểm danh</a>
        <a class='btn btn-info' href='?phuongthuc=diemdanhhangloat'>Thêm/chỉnh sửa dữ liệu điểm danh hàng loạt</a>
        <a class='btn btn-info' href='?phuongthuc=sodaubai'>Thêm/chỉnh sửa sổ đầu bài</a>";
    }

    if (isset($_GET['thongbao'])){
        $thongbao = $_GET['thongbao'];
        
        switch ($thongbao) {
            case 'thanhcong':
                $notify = '<div class="alert alert-success" role="alert">Cập nhật thành công</div>';
                break;

            case 'thatbai':
                if (isset($_GET['loinhan'])) {
                
                    $loinhan = htmlspecialchars($_GET['loinhan']);
                
                } else {
                    $loinhan='';
                }
                
                $notify = "<div class='alert alert-danger' role='alert'>Cập nhật thất bại. <b>$loinhan</b></div>";
                break;
        }
    }
?>

    <main>
        <div class="container-fluid" id="main">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="text-center"><?php echo $pageName ?></h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col thongbao"><?php echo $notify ?></div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php echo $html ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php 
    require_once('../include/footer-module.php');
?>  
<script src="<?php echo $url ?>/include/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
    
</script>
<?php 
    require_once('../include/footer.php');
    echo '<script>';
    echo $js;
    echo '</script>';
?>