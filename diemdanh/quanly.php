<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/loginCheck.php');

    require_once('../include/db.php');

    $pageName = 'Điểm danh';

    require_once('../include/init_include.php');

    require_once('../include/ktDsLop.php');

    require_once("../include/include.php");

    require_once("../include/ktquyennguoidung.php");

    ktQuyen('diemdanh');
?>

<?php 
    require_once('../include/header.php');

    require_once('../include/menu_non_sadmin.php');

    require_once('../include/ktngayluutru.php');

    require_once("../include/ktgiovaotiet.php");

    require_once("../include/ktThoigianhientai.php");

    $content = "Đây là trang dùng để chỉnh sửa dữ liệu điểm danh học sinh vắng các lớp, hãy chọn 1 lớp để tiếp tục";
    $js = '';
    $ngayhientai = currentDate();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $kiemtra = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)', 'id', $id);
        $content = "Hãy chọn 1 trong các lớp ở thanh danh sách lớp để tiếp tục";
        if ($kiemtra==0) {
            $content = "<b>Lỗi do người dùng định nghĩa id không tồn tại</b>";
        } else {
            switch ($sangHayChieu) {
                case 'am':
                    $buoicuaNgDung = 'sang';
                    break;
                
                default:
                    $buoicuaNgDung = 'chieu';
                    break;
            }
            $khoi = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'khoi', 'id', $id);
            $buoi = $db->getSingleData(DB_TABLE_PREFIX.'quydinh', 'buoi', 'khoi', $khoi);
            $thoiluongtiet = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'thoiluongtiet');

            function diemDanh($lop, $tietso, $sohsvang)
            {
                
                global $db, $table, $tennguoidung, $ngayhientai;
                
                $lop = mysqli_real_escape_string($db->conn, $lop);
                
                $tietso = mysqli_real_escape_string($db->conn, $tietso);
                
                $sohsvang = mysqli_real_escape_string($db->conn, $sohsvang);

                if (!is_numeric($tietso)||!is_numeric($sohsvang)) {
                    die('Phải là dữ liệu kiểu số');
                }
                
                $ktra = $db->query("SELECT COUNT(*) FROM `$table` WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngayhientai';");
                
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
                    WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngayhientai'");
                
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
                    VALUES ('$lop', '$tietso', '$noidung', '$ngayhientai', '$tennguoidung');");
                
            }
            }
            function soHSVang($lop, $tietso, $sohsvang)
            {
                
                global $db, $ngayhientai;
                
                $lop = mysqli_real_escape_string($db->conn, $lop);
                
                $tietso = mysqli_real_escape_string($db->conn, $tietso);
                
                $sohsvang = mysqli_real_escape_string($db->conn, $sohsvang);
                
                if (!is_numeric($tietso)||!is_numeric($sohsvang)) {
                    die('Phải là dữ liệu kiểu số');
                }

                $table = DB_TABLE_PREFIX.'sohsvang';
                
                $kqua = $db->query("SELECT COUNT(*) FROM $table WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngayhientai'");
                
                if (mysqli_num_rows($kqua)>0) {
                
                    $kqua = mysqli_fetch_assoc($kqua);
                
                    if ($kqua['COUNT(*)']>0) {
                
                        $db->query("UPDATE $table
                                SET sohsvang='$sohsvang'
                                WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngayhientai'");
                
                    } else {
                
                        $db->query("INSERT INTO $table (lop, sohsvang, tietso, ngay)
                                VALUES ('$lop', '$sohsvang', '$tietso', '$ngayhientai');");
                
                    }
                
                }
            }
            function xuLyBuoiHoc($buoihoc)
            {
                
                global $id, $db, $content, $js, $ketThucTiet, $gioHienTai, $phutHienTai, $buoicuaNgDung;
                
                $content = "";
                
                $ktra = false;
                
                for ($i=1; $i <= count($ketThucTiet)/2; $i++) { 

                    if ($buoicuaNgDung == 'chieu') {
                        if ($buoihoc["$i-gio"]==12) {
                            $buoihoc["$i-gio"] = 0;
                        }
						if ($gioHienTai==12) {
                            $gioHienTai = 0;
                        }
                    }

                    $tBanDau = $buoihoc["$i-gio"] * 60 + $buoihoc["$i-phut"];
                    
                    $tKetThuc = $tBanDau + 45 ;

                    $tHienTai = $gioHienTai * 60 + $phutHienTai;

                    if ($tKetThuc-$tHienTai>45) {
                        $ktra = false;
                        $keTiep = $i;
                        break;
                    } elseif ($tKetThuc-$tHienTai>=0&&$tKetThuc-$tHienTai<=45) {

                        $ktra = true;

                        $conlai = $tKetThuc-$tHienTai;
                
                        $content = "<b>Thời lượng còn lại:</b> <span id='conlai'>".$conlai."</span> phút"."<br>";

                        break;
                    } else {
                        $ktra = false;
                        $keTiep = $i+1;
                    }

                }



                if ($ktra) {
                    global $table, $ngayhientai;
                    $table = DB_TABLE_PREFIX."dsdiemdanhcaclop";
                    $lop = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'lop', 'id', $id);
                    $tietso = $i;
                    if (isset($_POST['sohs'])) {
                        $sohsvang = $_POST['sohs'];
                        soHSVang($lop, $tietso, $sohsvang);
                        diemDanh($lop, $tietso, $sohsvang);
                        $js = "Swal.fire({
                            title: 'Thành công!',
                            text: 'Cập nhật dữ liệu thành công',
                            icon: 'success',
                            confirmButtonText: 'OK'
                          });";
                    }

                    $kqua = $db->query("SELECT noidung FROM $table WHERE lop='$lop' AND tietso='$tietso' AND ngay='$ngayhientai'");

                    if (mysqli_num_rows($kqua)>0) {
                        $kqua = mysqli_fetch_assoc($kqua);
                        $noidung = unserialize($kqua['noidung']);
                        $js1 = '';
                        for ($i=1; $i <= count($noidung); $i++) {
                            $js1 .= "<tr>
                            <th scope='row'>$i</th>
                            <td><input name='hs-$i' value='".$noidung[$i]."' placeholder='Họ và tên (Có hoặc không dấu)' style='width: 100%'></td>
                            </tr>";
                        }
                        $js .= 'noidung1 = `<form method="POST"><table class="table">
                        <thead>
                            <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Họ tên (có hoặc không dấu)</th>
                            </tr>
                        </thead>
                        <tbody>`;
                        let noidung2 = `'.$js1.'`;
                        noidung3 = `</tbody>
                        </table>
                        <input type="hidden" value="'.count($noidung).'" name="sohs" required>
                        <button class="btn btn-success btn-block">Cập nhật</button></form>`;
                        noidung.innerHTML = noidung1+noidung2+noidung3;';
                    }

                    $chunhiemlophientai = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $lop);

                    if ($chunhiemlophientai === '0') {
                        $chunhiemlophientai = 'Không có';
                    }

                    $content .= 
                    <<<HTML
                        <label for='sohsvang'>Số học sinh vắng</label>
                        <input id='sohsvang' name='sohsvang' type="number"><button id="luusohs"class="btn btn-success">Cập nhật</button>
                        <div id="noidung"></div>
                        <b>Bạn đang cập nhật dữ liệu cho lớp $lop (GVCN: $chunhiemlophientai)</b>
                    HTML;

                    $js .= 'document.getElementById("luusohs").onclick = function(){
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
                        <input type="hidden" value="${sohsvang}" name="sohs" required>
                        <button class="btn btn-success btn-block">Cập nhật</button></form>`;
                        sohsvang = parseInt(sohsvang);
                        if (typeof sohsvang == "number") {
                            noidung.innerHTML = noidung1+noidung2+noidung3;
                        } else {
                            noidung.innerHTML = "Số học sinh phải là kiểu số!";
                        }
                    }';
                    $js .= "
                    gioKetThuc = ".$ketThucTiet["$tietso-gio"].";
                    phutKetThuc = ".$ketThucTiet["$tietso-phut"].";
                    setInterval(function(){ 
                        let date = new Date();
                        gio = date.getHours()%12;
                        phut = date.getMinutes();
                        if (gio==gioKetThuc&&phut==phutKetThuc) {
                            location.reload();
                        }
                        if (gioKetThuc==gio+1) {
                            conlai = phutKetThuc + 60 - phut;
                        } else {
                            conlai = phutKetThuc - phut;
                        }
                        
                        document.getElementById('conlai').innerHTML = conlai;
                    }, 1000);";
                } else {
                    if ($keTiep>5) {
                        $content = "Hết giờ quy định, hãy quay lại vào ngày mai!";
                    } else {
						if ($buoihoc["$keTiep-gio"]==0) {
							$buoihoc["$keTiep-gio"] = 12;
						}
                        $content = "Hết giờ quy định, tiết $keTiep sẽ bắt đầu vào ".$buoihoc["$keTiep-gio"]." giờ ".$buoihoc["$keTiep-phut"]." phút.";
                        $js .= "
                            gioBatDau = ".$buoihoc["$keTiep-gio"].";
                            phutBatDau = ".$buoihoc["$keTiep-phut"].";
                            setInterval(function(){ 
                                let date = new Date();
                                gio = date.getHours()%12;
                                phut = date.getMinutes();
                                if (gio==gioBatDau&&phut==phutBatDau) {
                                    location.reload();
                                }
                            }, 1000);";
                    }
                }




            }



            if ($buoi==$buoicuaNgDung) {
                switch ($buoi) {
                    case 'sang':
                        for ($i=1; $i <= count($sang)/2; $i++) { 
                            $ketThucTiet["$i-gio"] = (($sang["$i-phut"]+$thoiluongtiet)>=60) ? $sang["$i-gio"]+1 : $sang["$i-gio"];
                            $ketThucTiet["$i-phut"] = (($sang["$i-phut"]+$thoiluongtiet)>=60) ? ($sang["$i-phut"]+$thoiluongtiet)-60 : $sang["$i-phut"]+$thoiluongtiet;
                        }

                        xuLyBuoiHoc($sang);

                        break;
                    
                    case 'chieu':
                        for ($i=1; $i <= count($chieu)/2; $i++) { 
                            $ketThucTiet["$i-gio"] = (($chieu["$i-phut"]+$thoiluongtiet)>=60) ? $chieu["$i-gio"]+1 : $chieu["$i-gio"];
                            $ketThucTiet["$i-phut"] = (($chieu["$i-phut"]+$thoiluongtiet)>=60) ? ($chieu["$i-phut"]+$thoiluongtiet)-60 : $chieu["$i-phut"]+$thoiluongtiet;
                            if ($ketThucTiet["$i-gio"]==13) {
                                $ketThucTiet["$i-gio"] = 1;
                            }
                        }

                        xuLyBuoiHoc($chieu);

                        break;

                    default:
                        $content = "<b>Lỗi CSDL (#02)</b>";
                        break;
                }
            } else {
                switch ($buoi) {
                    case 'sang':
                        $buoi = 'Sáng';
                        break;
                    
                    default:
                        $buoi = 'Chiều';
                        break;
                }
                $content = "<b>Lớp này chỉ cho phép khai báo vào buổi $buoi</b>";
            }
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
                        $dsquydinhbuoi = $db->getSingleData(DB_TABLE_PREFIX.'quydinh', 'COUNT(*)');
                        if (count($khoi)!=$dsquydinhbuoi) {
                            $content = "Chưa thiết lập đủ về quy định buổi của các khối";
                        }
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
                ?>
            </div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    require_once('../include/footer.php');
    echo "<script>";
    echo $js;
    echo "</script>";
?>