<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/init_include.php');

    require_once('../include/loginCheck.php');

    require_once('../include/include.php');

    require_once('../include/db.php');

    require_once('../include/ktraAdmin.php');
    
    $pageName = 'Cài đặt chung';
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');
    function zeroToStr(&$value)
    {
        return $value = str_replace(0, '', $value);
    }
    $content = '';
    $js = '';
    $tenwebsite = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'tenwebsite');
    $diachi = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachi');
    zeroToStr($tenwebsite);
    zeroToStr($diachi);
    if (isset($_POST['tenwebsite'])&&isset($_POST['giaothuc'])&&isset($_POST['diachi'])) {
        $tenwebsite = $_POST['tenwebsite'];
        $giaothuc = $_POST['giaothuc'];
        $diachi = $_POST['diachi'];
        if ($tenwebsite==''||$giaothuc==''||$diachi=='') {
            $js = "Swal.fire({
                title: 'Lỗi!',
                text: 'Các ô bắt buộc không được để trống!',
                icon: 'error',
                confirmButtonText: 'Ok'
            })";
        } else {
            $js = "Swal.fire({
                title: 'Thành công!',
                text: 'Đã cập nhật thành công giá trị của (các) ô!',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
            setTimeout(function(){location.replace('')}, 1500)";
            $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $tenwebsite, 'tencaidat', 'tenwebsite');
            $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $giaothuc, 'tencaidat', 'giaothuc');
            $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $diachi, 'tencaidat', 'diachi');
        }
    }

    $content = "<h3 class='text-center'>Chỉnh sửa</h3>
    <form method='POST'>
        <label for='tenwebsite'>Tên trang web (*)</label>
        <input id='tenwebsite' name='tenwebsite' value='$tenwebsite' type='text' class='form-control' required>
        <label for='giaothuc'>Giao thức (*)</label>
        <input id='giaothuc' name='giaothuc' value='$giaothuc' type='text' class='form-control' required>
        <label for='diachi'>Đường dẫn (*)</label>
        <input id='diachi' name='diachi' value='$diachi' type='text' class='form-control' required>
        <br><button class='btn btn-success btn-block'>Lưu thay đổi</button>
        <b>Các ô được đánh dấu (*) là bắt buộc</b>
    </form>";

    if (isset($_GET['loai'])) {
        $loai = $_GET['loai'];
        switch ($loai) {
            case 'giovaotiet':

                // init

                for ($i=1; $i < 6; $i++) { 
                    $sang["$i-gio"] = '';
                    $chieu["$i-gio"] = '';
                    $sang["$i-phut"] = '';
                    $chieu["$i-phut"] = '';
                }

                // end

                if (isset($_POST['thoiluong'])) {
                    $thoiluong = $_POST['thoiluong'];
                    if (is_numeric($thoiluong)) {
                        if ($thoiluong < 0 || $thoiluong > 60) {
                            $js = "Swal.fire({
                                title: 'Lỗi!',
                                text: 'Thời lượng tiết phải nằm trong khoảng từ 0 đến 60!',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                              })";
                        } else {
                            $js = "Swal.fire({
                                title: 'Thành công!',
                                text: 'Đã cập nhật thành công!',
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            })";
                            
                            if ($db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'thoiluongtiet')==0) {
                                $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array(
                                    'tencaidat',
                                    'giatri'
                                ), array(
                                    'thoiluongtiet',
                                    $thoiluong
                                ));
                            } else {
                                $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $thoiluong, 'tencaidat', 'thoiluongtiet');
                            }

                            for ($i=1; $i < 6; $i++) { 
                                if ($_POST["sang-$i-gio"]=='' || $_POST["sang-$i-phut"]=='' || $_POST["chieu-$i-gio"]=='' || $_POST["chieu-$i-phut"]=='') {
                                    $_POST["sang-$i-gio"] = 1;
                                    $_POST["sang-$i-phut"] = 0;
                                    $_POST["chieu-$i-gio"] = 1;
                                    $_POST["chieu-$i-phut"] = 0;
                                }
                                if (!is_numeric($_POST["sang-$i-gio"]) || !is_numeric($_POST["sang-$i-phut"]) || !is_numeric($_POST["chieu-$i-gio"]) || !is_numeric($_POST["chieu-$i-phut"])) {
                                    $js = "Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Các ô chỉ nhận giá trị số mà thôi!',
                                        icon: 'error',
                                        confirmButtonText: 'Ok'
                                    })";
                                    break;
                                } else {
                                    $sang["$i-gio"] = (int) $_POST["sang-$i-gio"];
                                    $sang["$i-phut"] = (int) $_POST["sang-$i-phut"];
                                    $chieu["$i-gio"] = (int) $_POST["chieu-$i-gio"];
                                    $chieu["$i-phut"] = (int) $_POST["chieu-$i-phut"];
                                    if ( ($sang["$i-gio"] <= 0 || $sang["$i-gio"] > 12) || ($chieu["$i-gio"] <= 0 || $chieu["$i-gio"] > 12) ) {
                                        $js = "Swal.fire({
                                            title: 'Lỗi!',
                                            text: 'Giờ phải nằm trong khoảng từ 1 đến 12!',
                                            icon: 'error',
                                            confirmButtonText: 'Ok'
                                        })";
                                    } elseif ( ($sang["$i-phut"] < 0 || $sang["$i-phut"] > 59) || ($chieu["$i-phut"] < 0 || $chieu["$i-phut"] > 59) ) {
                                        $js = "Swal.fire({
                                            title: 'Lỗi!',
                                            text: 'Phút phải nằm trong khoảng từ 0 đến 59!',
                                            icon: 'error',
                                            confirmButtonText: 'Ok'
                                        })";
                                    } else {
                                        if ($db->getSingleData(DB_TABLE_PREFIX.'giovaotiet', 'COUNT(*)')<20) {
                                            
                                            $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
                                                'ten',
                                                'thoiluong'
                                            ), array(
                                                "sang-$i-gio",
                                                $sang["$i-gio"]
                                            ));

                                            $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
                                                'ten',
                                                'thoiluong'
                                            ), array(
                                                "sang-$i-phut",
                                                $sang["$i-phut"]
                                            ));

                                            $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
                                                'ten',
                                                'thoiluong'
                                            ), array(
                                                "chieu-$i-gio",
                                                $chieu["$i-gio"]
                                            ));

                                            $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
                                                'ten',
                                                'thoiluong'
                                            ), array(
                                                "chieu-$i-phut",
                                                $chieu["$i-phut"]
                                            ));

                                        } else {
                                            $db->updateADataRow(DB_TABLE_PREFIX.'giovaotiet', 'thoiluong', $sang["$i-gio"], 'ten', "sang-$i-gio");
                                            $db->updateADataRow(DB_TABLE_PREFIX.'giovaotiet', 'thoiluong', $sang["$i-phut"], 'ten', "sang-$i-phut");
                                            $db->updateADataRow(DB_TABLE_PREFIX.'giovaotiet', 'thoiluong', $chieu["$i-gio"], 'ten', "chieu-$i-gio");
                                            $db->updateADataRow(DB_TABLE_PREFIX.'giovaotiet', 'thoiluong', $chieu["$i-phut"], 'ten', "chieu-$i-phut");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                $thoiluong = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'thoiluongtiet');
                
                $giovaotietdb = $db->getMulData(DB_TABLE_PREFIX.'giovaotiet', array(
                    'ten',
                    'thoiluong'
                ));
                if ($giovaotietdb==0) {
                    // chưa xử lý
                } elseif (count($giovaotietdb)==20) {

                    for ($i=0; $i < count($giovaotietdb); $i++) { 
            
                        $ten1 = ''; $ten2 = '';
            
                        foreach ($giovaotietdb[$i] as $key => $value) {
            
                            if ($key == 'ten') {
            
                                $ten1 = $value;
            
                            } elseif ($key == 'thoiluong') {
            
                                $ten2 = $value;
            
                            }
            
                            $giovaotiet[$ten1] = $ten2;
            
                        }
                    }
            
                    for ($i=1; $i < 6; $i++) {
            
                        $sang["$i-gio"] = $giovaotiet["sang-$i-gio"];
            
                        $sang["$i-phut"] = $giovaotiet["sang-$i-phut"];
            
                        $chieu["$i-gio"] = $giovaotiet["chieu-$i-gio"];
            
                        $chieu["$i-phut"] = $giovaotiet["chieu-$i-phut"];
                        
                    }
                }

                $content = <<<HTML
                    <h3 class="text-center">Giờ vào tiết</h3>
                    <form method="POST">
                HTML;
                $content .= "<label for='thoiluong'>Thời lượng mỗi tiết</label>
                <input id='thoiluong' name='thoiluong' type='number' min=0 max=60 required value='$thoiluong'> Phút";
                $content .= <<<HTML
                    <!--  -->
                    <h4 class="text-center">Buổi sáng</h4>
                    <!--  -->
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tiết số</th>
                                <th scope="col">Giờ</th>
                                <th scope="col">Phút</th>
                            </tr>
                        </thead>
                        <tbody>
                    HTML;
                $content .= 
                    "<tr>
                        <th scope='row'>1</th>
                        <td><input type='number' min=1 max=12 name='sang-1-gio' value='".$sang["1-gio"]."'></td>
                        <td><input type='number' min=0 max=59 name='sang-1-phut' value='".$sang["1-phut"]."'></td>
                    </tr>
                    <tr>
                        <th scope='row'>2</th>
                        <td><input type='number' min=1 max=12 name='sang-2-gio' value='".$sang["2-gio"]."'></td>
                        <td><input type='number' min=0 max=59 name='sang-2-phut' value='".$sang["2-phut"]."'></td>
                    </tr>
                    <tr>
                        <th scope='row'>3</th>
                        <td><input type='number' min=1 max=12 name='sang-3-gio' value='".$sang["3-gio"]."'></td>
                        <td><input type='number' min=0 max=59 name='sang-3-phut' value='".$sang["3-phut"]."'></td>
                    </tr>
                    <tr>
                        <th scope='row'>4</th>
                        <td><input type='number' min=1 max=12 name='sang-4-gio' value='".$sang["4-gio"]."'></td>
                        <td><input type='number' min=0 max=59 name='sang-4-phut' value='".$sang["4-phut"]."'></td>
                    </tr>
                    <tr>
                        <th scope='row'>5</th>
                        <td><input type='number' min=1 max=12 name='sang-5-gio' value='".$sang["5-gio"]."'></td>
                        <td><input type='number' min=0 max=59 name='sang-5-phut' value='".$sang["5-phut"]."'></td>
                    </tr>";
                    $content .= <<<HTML
                        </tbody>
                    </table>
                    <!--  -->
                    <h4 class="text-center">Buổi chiều</h4>
                    <!--  -->
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Tiết số</th>
                                <th scope="col">Giờ</th>
                                <th scope="col">Phút</th>
                            </tr>
                        </thead>
                        <tbody>
                    HTML;
                    $content .=
                            "<tr>
                                <th scope='row'>1</th>
                                <td><input type='number' min=1 max=12 name='chieu-1-gio' value='".$chieu["1-gio"]."'></td>
                                <td><input type='number' min=0 max=59 name='chieu-1-phut' value='".$chieu["1-phut"]."'></td>
                            </tr>
                            <tr>
                                <th scope='row'>2</th>
                                <td><input type='number' min=1 max=12 name='chieu-2-gio' value='".$chieu["2-gio"]."'></td>
                                <td><input type='number' min=0 max=59 name='chieu-2-phut' value='".$chieu["2-phut"]."'></td>
                            </tr>
                            <tr>
                                <th scope='row'>3</th>
                                <td><input type='number' min=1 max=12 name='chieu-3-gio' value='".$chieu["3-gio"]."'></td>
                                <td><input type='number' min=0 max=59 name='chieu-3-phut' value='".$chieu["3-phut"]."'></td>
                            </tr>
                            <tr>
                                <th scope='row'>4</th>
                                <td><input type='number' min=1 max=12 name='chieu-4-gio' value='".$chieu["4-gio"]."'></td>
                                <td><input type='number' min=0 max=59 name='chieu-4-phut' value='".$chieu["4-phut"]."'></td>
                            </tr>
                            <tr>
                                <th scope='row'>5</th>
                                <td><input type='number' min=1 max=12 name='chieu-5-gio' value='".$chieu["5-gio"]."'></td>
                                <td><input type='number' min=0 max=59 name='chieu-5-phut' value='".$chieu["5-phut"]."'></td>
                            </tr>";
                    $content .= <<<HTML
                            </tbody>
                        </table>
                        <br>
                        <button class="btn btn-success btn-block">Lưu</button>
                    </form>
                    HTML;
                break;
            
            
            case 'smtp':

                $tennggui = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'tenngguiSMTP');
                $congSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'congSMTP');
                $maychuSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'maychuSMTP');
                $diachiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachiSMTP');
                $matkhauSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'matkhauSMTP');

                zeroToStr($tennggui);
                zeroToStr($congSMTP);
                zeroToStr($maychuSMTP);
                zeroToStr($diachiSMTP);
                
                if ($db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'matkhauSMTP')>0) {
                    $matkhauSMTP = 'xxxxxxxxxxxxxxxxxxxx';
                } else {
                    zeroToStr($matkhauSMTP);
                }

                if (isset($_POST['tennggui'])&&isset($_POST['congSMTP'])&&isset($_POST['maychuSMTP'])&&isset($_POST['diachiSMTP'])&&isset($_POST['matkhauSMTP'])) {

                    $tennggui = mysqli_real_escape_string($db->conn, $_POST['tennggui']);
                    $congSMTP = mysqli_real_escape_string($db->conn, $_POST['congSMTP']);
                    $maychuSMTP = mysqli_real_escape_string($db->conn, $_POST['maychuSMTP']);
                    $diachiSMTP = mysqli_real_escape_string($db->conn, $_POST['diachiSMTP']);
                    $matkhauSMTP = mysqli_real_escape_string($db->conn, $_POST['matkhauSMTP']);

                    ($tennggui=='') ? $tennggui = 'eSEduVN' : $tennggui;
                    ($congSMTP=='') ? $congSMTP = 25 : $congSMTP;

                    if ($maychuSMTP==''||$diachiSMTP==''||$matkhauSMTP=='') {
                        $js = "Swal.fire({
                            title: 'Thất bại!',
                            text: 'Vui lòng điền đầy đủ các ô bắt buộc!',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });";
                    } elseif (!is_numeric($congSMTP)) {
                        $js = "Swal.fire({
                            title: 'Thất bại!',
                            text: 'Cổng SMTP phải là một số!',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });";
                    } else {
                        $js = "Swal.fire({
                            title: 'Thành công!',
                            text: 'Đã cập nhật thành công giá trị của (các) ô!',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                        setTimeout(function(){location.replace('')}, 1500)";

                        $kiemtra_tennggui = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'tenngguiSMTP');
                        $kiemtra_congSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'congSMTP');
                        $kiemtra_maychuSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'maychuSMTP');
                        $kiemtra_diachiSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'diachiSMTP');
                        $kiemtra_matkhauSMTP = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)', 'tencaidat', 'matkhauSMTP');

                        ($kiemtra_tennggui>0) ? $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $tennggui, 'tencaidat', 'tenngguiSMTP') : $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array('tencaidat','giatri'), array('tenngguiSMTP', $tennggui));
                        ($kiemtra_congSMTP>0) ? $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $congSMTP, 'tencaidat', 'congSMTP') : $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array('tencaidat','giatri'), array('congSMTP', $congSMTP));
                        ($kiemtra_maychuSMTP>0) ? $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $maychuSMTP, 'tencaidat', 'maychuSMTP') : $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array('tencaidat','giatri'), array('maychuSMTP', $maychuSMTP));
                        ($kiemtra_diachiSMTP>0) ? $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $diachiSMTP, 'tencaidat', 'diachiSMTP') : $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array('tencaidat','giatri'), array('diachiSMTP', $diachiSMTP));
                        if ($matkhauSMTP!='xxxxxxxxxxxxxxxxxxxx') {
                            ($kiemtra_matkhauSMTP>0) ? $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', $matkhauSMTP, 'tencaidat', 'matkhauSMTP') : $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array('tencaidat','giatri'), array('matkhauSMTP',$matkhauSMTP));
                        }

                    }
                }

                $content = "<h3 class='text-center'>Cài đặt Mail/SMTP</h3>
                <p>Nếu bạn muốn bật tính năng xác minh 2 bước qua email, tính năng quên mật khẩu khi đăng nhập
                và tính năng cho khách truy cập nhận email thông báo của hệ thống, bạn cần thiết lập một số
                thông tin SMTP tại đây.</p>
                <form method='POST'>
                    <label for='tennggui'>Tên người gửi (Mặc định là eSEduVN)</label>
                    <input id='tennggui' name='tennggui' value='$tennggui' type='text' class='form-control'>
                    <label for='congSMTP'>Cổng (Có 3 cổng là 25/587/465, mặc định là 25)</label>
                    <input id='congSMTP' name='congSMTP' value='$congSMTP' type='number' class='form-control'>
                    <label for='maychuSMTP'>Tên máy chủ SMTP (Ví dụ: smtp.vidu.tld) (*)</label>
                    <input id='maychuSMTP' name='maychuSMTP' value='$maychuSMTP' type='text' class='form-control' required>
                    <label for='diachiSMTP'>Địa chỉ gửi thư (Ví dụ: noreply@vidu.tld) (*)</label>
                    <input id='diachiSMTP' name='diachiSMTP' value='$diachiSMTP' type='text' class='form-control' required>
                    <label for='matkhauSMTP'>Mật khẩu của địa chỉ trên (*)</label>
                    <input id='matkhauSMTP' name='matkhauSMTP' value='$matkhauSMTP' type='password' class='form-control' required>
                    <br><button class='btn btn-success btn-block'>Lưu thay đổi</button>
                    <b>Các ô được đánh dấu (*) là bắt buộc</b>
                </form>";
                
                break;

            default:
                $content = "<b>Lỗi do người dùng định nghĩa sai phương thức!</b>";
                break;
            }
    }
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col"><h3 class="text-center"><?php echo $pageName ?></h3></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-4 col-12">
                <a href="caidatchung" class="btn btn-success btn-block">Cài đặt chung</a><br>
                <a href="?loai=giovaotiet" class="btn btn-success btn-block">Giờ vào tiết</a><br>
                <a href="?loai=smtp" class="btn btn-success btn-block">Mail/SMTP</a><br>
                <?php require_once('../include/thanhdieuhuong_sadmin.php'); ?>
            </div>
            <div class="col-lg-8 col-sm-8 col-12">
                <?php echo $content ?>
            </div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    require_once('../include/footer.php');
    echo '<script>';
    echo $js;
    echo '</script>';
?>