<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/db.php');

    $pageName = 'Điểm danh';

    require_once('../include/init_include.php');

    require_once('../include/ktDsLop.php');
?>

<?php 
    require_once('../include/header.php');

    require_once('../include/menu_non_sadmin.php');

    require_once('../include/ktngayluutruTXem.php');

    require_once("../include/ktgiovaotiet.php");
    
    require_once("../include/ktThoigianhientai.php");

    $content = "Đây là trang dùng để xem danh sách điểm danh học sinh vắng của toàn bộ các lớp. Hãy chọn 1 lớp
    để tiếp tục!";
    $content2 = '';
    $js = '';
    
    function sort_ngay($a,$b) {
        return strtotime(str_replace('/', '-', $a['ngay'])) - strtotime(str_replace('/', '-', $b['ngay']));
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)', 'id', $id);
        if ($kiemtra==0) {
            $content = "<b>Lỗi do người dùng định nghĩa id không tồn tại</b>";
        } else {
            
            function chonNgay($ngaykt)
            {
                global $db, $chonngay;
                $chonngay = "<select id='luachonngay' name='luachonngay'>";

                $dsngay = $db->getMulData(DB_TABLE_PREFIX.'luutrungay', array('ngay', 'id'));

                usort($dsngay, "sort_ngay");
                
                for ($i=0; $i < count($dsngay); $i++) { 
                    $ngay = $dsngay[$i]['ngay'];
                    if ($ngay==$ngaykt) {
                        $chonngay .= "<option value='$ngay' selected>$ngay</option>";
                    } else {
                        $chonngay .= "<option value='$ngay'>$ngay</option>";
                    }
                }

                $chonngay .= "</select>";
            }

            $ngayhientai = currentDate();
            chonNgay($ngayhientai);
            
            $lop = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'lop', 'id', $id);

            if (isset($_POST['luachonngay'])) {
                $ngaydachon = $_POST['luachonngay'];
                $ktra = $db->getSingleData(DB_TABLE_PREFIX.'luutrungay', 'COUNT(*)', 'ngay', $ngaydachon);
                if ($ktra) {
                    chonNgay($ngaydachon);
                    $table = DB_TABLE_PREFIX.'dsdiemdanhcaclop';
                    $kqua = $db->query("SELECT tietso, noidung, nguoidung FROM $table WHERE ngay='$ngaydachon' AND lop='$lop'");
                    if (mysqli_num_rows($kqua)>0) {
                        while ($row = mysqli_fetch_assoc($kqua)) {
                            foreach ($row as $key => $value) {
                                if ($key=='tietso') {
                                    // echo $value;
                                    $content2 .= "<p><b>Tiết số: $value</b></p>";
                                } elseif ($key=='noidung'||$key=='nguoidung') {
                                    switch ($key) {
                                        case 'noidung':
                                            $value = unserialize($value);
                                            $content2 .= '<table class="table">
                                            <thead>
                                                <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Họ tên học sinh vắng</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                            for ($i=1; $i <= count($value); $i++) { 
                                                $content2 .= "<tr>
                                                <th scope='row'>$i</th>
                                                <td><p>".$value[$i]."</p></td>
                                                </tr>";
                                            }
                                            $content2 .= '</tbody>
                                            </table>';
                                            break;

                                        case 'nguoidung':
                                            $hovaten = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'tendangnhap', $value);
                                            
                                            $chucvu = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'chucvu', 'tendangnhap', $value);

                                            if ($chucvu==0) {
                                                $chucvu = 'Không';
                                            }

                                            $bomon = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'bomon', 'tendangnhap', $value);

                                            if ($bomon==0) {
                                                $bomon = 'Không';
                                            }

                                            $content2 .= "<p>
                                            <ul>
                                                <li><b>Giáo viên khai báo</b>: $hovaten</li>
                                                <li><b>Tên người dùng</b>: $value</li>
                                                <li><b>Chức vụ</b>: $chucvu</li>
                                                <li><b>Bộ môn</b>: $bomon</li>
                                            </ul> </p>";
                                            break;
                                    }
                                    
                                }
                            }
                        }
                    } else {
                        $content2 = "<b>Không tìm thấy</b>";
                    }
                } else {
                    $js = "Swal.fire({
                        title: 'Lỗi!',
                        text: 'Không tìm thấy ngày bạn chỉ định trong CSDL',
                        icon: 'error',
                        confirmButtonText: 'OK'
                      })";
                }
                
            }

            $chunhiemlophientai = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $lop);

            if ($chunhiemlophientai === '0') {
                $chunhiemlophientai = 'Không có';
            }

            $content = "<form method='POST'><label for='luachonngay'>Lựa chọn ngày: </label> $chonngay
            <button class='btn btn-success'>Tra cứu</button></form>";
            $content2 .= "<p><b>Bạn đang xem lớp $lop (GVCN: $chunhiemlophientai)</b></p>";
        }
    }
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
                        $phtml = '';
                        $khoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                            'khoi'
                        ));
                        for ($i=0; $i < count($khoi); $i++) {
                            $_khoi = $khoi[$i]['khoi'];
                            $html = 
                            <<<HTML
                                <li>
                                    <h3>Khối $_khoi</h3>
                                    <div class="card">
                                        <div class="list-group list-group-flush">
                            HTML;
                            $cac_lop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array(
                                'lop',
                                'khoi'
                            ), 'khoi', $_khoi);
                            for ($j=0; $j < count($cac_lop); $j++) { 
                                $_lop = $cac_lop[$j]['lop'];
                                $id = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'id', 'lop', $_lop);
                                $html .= "<a href='?id=$id' class='list-group-item text-dark' style='font-weight: bold'>Lớp $_lop</a>";
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
            <div class="col-12 col-md-9 col-lg-8" id="diemdanh">
                <?php 
                    echo $content;
                    echo $content2;
                ?>
            </div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    echo "<script>";
    echo $js;
    echo "</script>";
    require_once('../include/footer.php');
?>