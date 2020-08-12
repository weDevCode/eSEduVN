<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    require_once('../include/loginCheck.php');
    require_once('../include/db.php');
    $pageName = 'Quản trị';
    require_once('../include/init_include.php');
?>

<?php 
    $ghichu = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "ghichu");
    if (isset($_POST['ghichu'])) {
        $ghichu = $_POST['ghichu'];
        $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', "$ghichu", 'tencaidat', "ghichu");
    }
    $sothanhvien = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)');
    require_once('../include/include.php');
    require_once('../include/ktngayluutru.php');
    $table = DB_TABLE_PREFIX.'sohsvang';
    $ngayhientai = currentDate();
    $kqua = $db->query("SELECT sohsvang FROM $table WHERE ngay='$ngayhientai' AND tietso='5'");
    if (mysqli_num_rows($kqua)>0) {
        echo $kqua = mysqli_fetch_assoc($kqua);
        echo '<pre>';
        var_dump($kqua);
        echo '</pre>';
    } else {
        $sohsvang = 0;
    }
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');
?>

    <div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 card">
                    <h3 class="card-title"><i class="fi-ensuxl-warning-solid"></i> <span class="align-middle"><?php echo $sohsvang ?></span></h3>
                    Có <?php echo $sohsvang ?> học sinh vắng trong tiết 5 toàn trường
                </div>
                <div class="col-lg-4 col-md-4 col-12 card">
                    <h3 class="card-title"><i class="fi-cnsuxl-user-tie-circle"></i> <span class="align-middle"><?php echo $sothanhvien ?></span></h3>
                    <p>Số thành viên trên <b><?php echo SITE_NAME ?></b> là <?php echo $sothanhvien ?> thành viên</p>
                </div>
                <div class="col-lg-4 col-md-4 col-12 card">
                    <h3 class="card-title"><i class="fi-cwluhl-clock-wide"></i> <span class="align-middle time"></span></h3>
                    <p>Thời gian hiện tại: <span class="time"></span></p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>Xin chào, <b style="color: red"><?php echo $tennguoidung ?></b></p>
                    <p>Đây là trang quản trị của <b>eSEduVN</b>, hãy nhấn vào 1 trong các nút bên dưới để bắt đầu quản trị!</p>
                </div>
                <div class="col-12">
                    <button class="btn btn-info btn-block">Hướng dẫn sử dụng eSEduVN</button>
                    <button class="btn btn-primary btn-block">Quản lý thành viên</button>
                    <button class="btn btn-success btn-block">Thêm/Xoá/Chỉnh sửa thời khoá biểu</button>
                    <button class="btn btn-success btn-block">Xem trang điểm danh</button>
                    <button class="btn btn-success btn-block">Xem/chỉnh sửa sổ đầu bài</button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Ghi chú</h2>
                    <p>Bạn có thể dùng ghi chú để thông báo với các thành viên quản trị khác.</p>
                    <form method="POST">
                        <textarea name="ghichu" id="ghichu" style="width: 100%; max-width: 100%; padding: 20px" rows="10"><?php echo $ghichu ?></textarea>
                        <button class="btn btn-info btn-block">Lưu</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    
<?php 
    require_once('../include/footer-module.php');
?>  

    <script src="<?php echo $url ?>/include/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#ghichu'
    });
        var d = new Date();
        ngay = d.getDate();
        thang = d.getMonth()+1;
        nam = d.getFullYear();
        gio = ('0' + d.getHours()).slice(-2);
        phut = ('0' + d.getMinutes()).slice(-2);
        giay = ('0' + d.getUTCSeconds()).slice(-2);
        ngaydu = gio+':'+phut+':'+giay+' '+ngay+'/'+thang+'/'+nam;
        timeSection = document.querySelectorAll('.time');
        for (let i = 0; i < timeSection.length; i++) {
            timeSection[i].innerHTML = ngaydu;
        }
        setInterval(() => {
            var d = new Date();
            ngay = d.getDate();
            thang = d.getMonth()+1;
            nam = d.getFullYear();
            gio = ('0' + d.getHours()).slice(-2);
            phut = ('0' + d.getMinutes()).slice(-2);
            giay = ('0' + d.getUTCSeconds()).slice(-2);
            ngaydu = gio+':'+phut+':'+giay+' '+ngay+'/'+thang+'/'+nam;
            timeSection = document.querySelectorAll('.time');
            for (let i = 0; i < timeSection.length; i++) {
                timeSection[i].innerHTML = ngaydu;
            }
        }, 1000);
      
    </script>
<?php 
    require_once('../include/footer.php');
?>