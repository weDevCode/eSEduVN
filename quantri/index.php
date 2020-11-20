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

    $pageName = 'Quản trị';

    $thong_bao = '';

    require_once('../include/365ngay.php');
?>

<?php 
    $ghichu = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "ghichu");

    if (isset($_POST['ghichu'])) {

        $ghichu = $_POST['ghichu'];

        $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', "$ghichu", 'tencaidat', "ghichu");
    }
    $sothanhvien = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)');

    $table = DB_TABLE_PREFIX.'sohsvang';

    $ngayhientai = currentDate();

    $kqua = $db->query("SELECT sohsvang FROM $table WHERE ngay='$ngayhientai' AND tietso='5'");

    if (mysqli_num_rows($kqua)>0) {
    
        $sohsvang = 0;
    
        while ($row = mysqli_fetch_assoc($kqua)) {
    
            $sohsvang += $row['sohsvang'];
        }
    } else {
        $sohsvang = 0;
    }
?>

<?php 
    
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');
?>

    <main>
        <div class="container-fluid" id="main">
            <div class="row">
                <div class="col">
                    <?php echo $thong_bao ?>
                </div>
            </div>
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
                        <a href='https://eseduvn.tienminhvy.name.vn' target="_blank" class="btn btn-info btn-block">Hướng dẫn sử dụng eSEduVN</a>
                        <a href='thanhvien' class="btn btn-primary btn-block">Quản lý thành viên</a>
                        <a href='<?php echo $url ?>/thoikhoabieu' class="btn btn-success btn-block">Thêm/Xoá/Chỉnh sửa thời khoá biểu</a>
                        <a href='<?php echo $url ?>/diemdanh' class="btn btn-success btn-block">Xem trang điểm danh</a>
                        <a href='<?php echo $url ?>/sodaubai' class="btn btn-success btn-block">Xem/chỉnh sửa sổ đầu bài</a>
                    </div>
                </div>
            </div>

            <!-- <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-center">Thông báo</h2>
                        <p class="text-center">Dùng để viết thông báo đặt ở trang chủ</p>
                        <form method="POST">
                            <textarea name="ghichu" id="ghichu" style="width: 100%; max-width: 100%; padding: 20px" rows="10"><?php echo $ghichu ?></textarea>
                            <button class="btn btn-info btn-block">Lưu</button>
                        </form>
                    </div>
                </div>
            </div> -->

        </div>
    </main>
    
<?php 
    require_once('../include/footer-module.php');
?>  

    <script src="<?php echo $url ?>/include/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#ghichu',
        branding: false
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