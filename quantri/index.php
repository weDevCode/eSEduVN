<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    require_once('../include/loginCheck.php');
    require_once('../include/db.php');
    $pageName = 'Quản trị';
    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "giaothuc");
    $url = $giaothuc.$db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "diachi");
?>

<?php 
    $ghichu = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "ghichu");
    if (isset($_POST['ghichu'])) {
        $ghichu = $_POST['ghichu'];
        $db->updateADataRow(DB_TABLE_PREFIX.'caidat', 'giatri', "$ghichu", 'tencaidat', "ghichu");
    }
    $sothanhvien = $db->getSingleData(DB_TABLE_PREFIX.'nguoidung', 'COUNT(*)');
    require_once('../include/admin_include.php');
?>

<?php 
    require_once('../include/header.php');
?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"><?php echo SITE_NAME ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Xem trang
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="..">Trang chủ</a>
                    <a class="dropdown-item" href="../diemdanh">Điểm danh</a>
                    <a class="dropdown-item" href="../sodaubai">Sổ đầu bài</a>
                    <a class="dropdown-item" href="../thoikhoabieu">Thời khoá biểu</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Thêm/Xoá thành viên</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Cài đặt chung</a>
            </li>
            </ul>
            <a href="../dangxuat"><button class="btn btn-danger">Đăng xuất</button></a>
        </div>
    </nav>

    <div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 card">
                    <h3 class="card-title"><i class="fi-ensuxl-warning-solid"></i> <span class="align-middle">Số</span></h3>
                    Có Số học sinh vắng trong ngày hôm nay
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