<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    function createTable(string $prefix = '')
    {
        
        global $db;

        // Tạo bảng user
        // CREATE TABLE ".$prefix."nguoidung ( 
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     email VARCHAR(320) NOT NULL,
        //     matkhaubam VARCHAR(255) NOT NULL,
        //     PRIMARY KEY (id), 
        //     UNIQUE (tendangnhap),
        //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        // );

        $db->query("CREATE TABLE ".$prefix."nguoidung ( 
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            email VARCHAR(320) NOT NULL,
            matkhaubam VARCHAR(255) NOT NULL,
            PRIMARY KEY (id), 
            UNIQUE (tendangnhap),
            thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );");

        // Bảng dslop
        // CREATE TABLE ".$prefix."dslop (
        //     id INT NOT NULL AUTO_INCREMENT, 
        //     lop CHAR(7) NOT NULL, 
        //     khoi CHAR(7) NOT NULL, 
        //     PRIMARY KEY (id), 
        //     UNIQUE (lop)
        // );
        $db->query("CREATE TABLE ".$prefix."dslop (
            id INT NOT NULL AUTO_INCREMENT, 
            lop CHAR(7) NOT NULL, 
            khoi CHAR(7) NOT NULL, 
            PRIMARY KEY (id), 
            UNIQUE (lop)
        );");
        // Bảng dskhoi
        // CREATE TABLE ".$prefix."dskhoi (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     khoi CHAR(7) NOT NULL,
        //     PRIMARY KEY (id),
        //     UNIQUE (khoi)
        //     ) ;
        $db->query("CREATE TABLE ".$prefix."dskhoi (
            id INT NOT NULL AUTO_INCREMENT,
            khoi CHAR(7) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (khoi)
            );");
        // Bảng phiên đăng nhập
        // CREATE TABLE ".$prefix."phien (
        //     id INT NOT NULL AUTO_INCREMENT, 
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     khoaphien CHAR(255) NOT NULL, 
        //     PRIMARY KEY (id),
        //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        // );
        $db->query("CREATE TABLE ".$prefix."phien (
            id INT NOT NULL AUTO_INCREMENT, 
            tendangnhap VARCHAR(255) NOT NULL,
            khoaphien CHAR(255) NOT NULL, 
            PRIMARY KEY (id),
            thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );");
        // Bảng cài đặt
        // CREATE TABLE ".$prefix."caidat ( 
            // id INT NOT NULL AUTO_INCREMENT,
            // tencaidat CHAR(20) NOT NULL,
            // giatri longtext NOT NULL,
            // PRIMARY KEY (id),
        // );
        $db->query("CREATE TABLE ".$prefix."caidat ( 
            id INT NOT NULL AUTO_INCREMENT,
            tencaidat CHAR(20) NOT NULL,
            giatri longtext NOT NULL,
            PRIMARY KEY (id)
        );");
        // Bảng TKB
        // CREATE TABLE ".$prefix."tkb (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     lop CHAR(7) NOT NULL,
        //     noidung longtext NOT NULL,
        //     PRIMARY KEY (id),
        //     UNIQUE (lop),
        //     thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        //     );
        $db->query("CREATE TABLE ".$prefix."tkb (
            id INT NOT NULL AUTO_INCREMENT,
            lop CHAR(7) NOT NULL,
            noidung longtext NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (lop),
            thoigian TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            );");
        // CREATE TABLE ".$prefix."quyen ( 
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     hovaten VARCHAR(50) NOT NULL,
        //     chucvu CHAR(16) NOT NULL,
        //     bomon CHAR(16) NOT NULL,
        //     chunhiem CHAR(7) NOT NULL,
        //     diemdanh TINYINT UNSIGNED NOT NULL,
        //     tkb TINYINT UNSIGNED NOT NULL,
        //     sodaubai TINYINT UNSIGNED NOT NULL,
        //     la_admin TINYINT UNSIGNED NOT NULL,
        //     PRIMARY KEY (id),
        //     UNIQUE (tendangnhap)
        //     );
        $db->query("CREATE TABLE ".$prefix."quyen ( 
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            hovaten VARCHAR(50) NOT NULL,
            chucvu CHAR(16) NOT NULL,
            bomon CHAR(16) NOT NULL,
            chunhiem CHAR(7) NOT NULL,
            diemdanh TINYINT UNSIGNED NOT NULL,
            tkb TINYINT UNSIGNED NOT NULL,
            sodaubai TINYINT UNSIGNED NOT NULL,
            la_admin TINYINT UNSIGNED NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (tendangnhap)
            );");
        // CREATE TABLE ".$prefix."quydinh (
        //     id INT NOT NULL AUTO_INCREMENT,
        // 	   khoi CHAR(7) NOT NULL,
        //     buoi CHAR(5) NOT NULL,
        //     PRIMARY KEY (id),
        //     UNIQUE (khoi)
        //     );
        $db->query("CREATE TABLE ".$prefix."quydinh (
            id INT NOT NULL AUTO_INCREMENT,
        	   khoi CHAR(7) NOT NULL,
            buoi CHAR(5) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (khoi)
            );");
        // CREATE TABLE ".$prefix."giovaotiet ( 
        //     id INT NOT NULL AUTO_INCREMENT,
        //     ten CHAR(20) NOT NULL,
        //     thoiluong TINYINT(60) NOT NULL,
        //     PRIMARY KEY (id),
        //     UNIQUE (ten)
        // );
        $db->query("CREATE TABLE ".$prefix."giovaotiet ( 
            id INT NOT NULL AUTO_INCREMENT,
            ten CHAR(20) NOT NULL,
            thoiluong TINYINT(60) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (ten)
        );");
        // CREATE TABLE ".$prefix."luutrungay (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     ngay CHAR(10) NOT NULL,
        //     PRIMARY KEY (id),
        //     UNIQUE (ngay)
        // );
        $db->query("CREATE TABLE ".$prefix."luutrungay (
            id INT NOT NULL AUTO_INCREMENT,
            ngay CHAR(10) NOT NULL,
            PRIMARY KEY (id),
            UNIQUE (ngay)
        );");
        // CREATE TABLE ".$prefix."dsdiemdanhcaclop (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     lop CHAR(7) NOT NULL,
        //     tietso TINYINT UNSIGNED NOT NULL,
        //     noidung longtext NOT NULL,
        //     ngay CHAR(10) NOT NULL,
        //     nguoidung VARCHAR(50) NOT NULL,
        //     PRIMARY KEY (id)
        // );
        $db->query("CREATE TABLE ".$prefix."dsdiemdanhcaclop (
            id INT NOT NULL AUTO_INCREMENT,
            lop CHAR(7) NOT NULL,
            tietso TINYINT UNSIGNED NOT NULL,
            noidung longtext NOT NULL,
            ngay CHAR(10) NOT NULL,
            nguoidung VARCHAR(50) NOT NULL,
            PRIMARY KEY (id)
        );");
        // CREATE TABLE ".$prefix."sohsvang (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     lop CHAR(7) NOT NULL,
        //     sohsvang SMALLINT UNSIGNED NOT NULL,
        //     tietso TINYINT UNSIGNED NOT NULL,
        //     ngay CHAR(10) NOT NULL,
        //     PRIMARY KEY (id)
        //     );
        $db->query("CREATE TABLE ".$prefix."sohsvang (
            id INT NOT NULL AUTO_INCREMENT,
            lop CHAR(7) NOT NULL,
            sohsvang SMALLINT UNSIGNED NOT NULL,
            tietso TINYINT UNSIGNED NOT NULL,
            ngay CHAR(10) NOT NULL,
            PRIMARY KEY (id)
            );");
        // CREATE TABLE ".$prefix."sodaubai (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     lop CHAR(7) NOT NULL,
        //     tietso TINYINT(3) UNSIGNED NOT NULL,
        //     noidung LONGTEXT NOT NULL,
        //     danhgia CHAR(10) NOT NULL,
        //     ngay CHAR(10) NOT NULL,
        //     nguoidung VARCHAR(50) NOT NULL,
        //     PRIMARY KEY (id)
        // );

        $db->query("CREATE TABLE ".$prefix."sodaubai (
            id INT NOT NULL AUTO_INCREMENT,
            lop CHAR(7) NOT NULL,
            tietso TINYINT(3) UNSIGNED NOT NULL,
            noidung LONGTEXT NOT NULL,
            danhgia CHAR(10) NOT NULL,
            ngay CHAR(10) NOT NULL,
            nguoidung VARCHAR(50) NOT NULL,
            PRIMARY KEY (id)
        );");
        // Table thongbao
        // CREATE TABLE ".$prefix."sodaubai (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     lop CHAR(7) NOT NULL,
        //     tietso TINYINT(3) UNSIGNED NOT NULL,
        //     noidung LONGTEXT NOT NULL,
        //     danhgia CHAR(10) NOT NULL,
        //     ngay CHAR(10) NOT NULL,
        //     nguoidung VARCHAR(50) NOT NULL,
        //     PRIMARY KEY (id)
        // );

        $db->query("CREATE TABLE ".$prefix."thongbao ( 
            id INT NOT NULL AUTO_INCREMENT, 
            tieude TINYTEXT NOT NULL,
            noidung LONGTEXT NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            );");
        // Table xacminhnhanthongbao
        // CREATE TABLE ".$prefix."xacminhnhanthongbao (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     email VARCHAR(320) NOT NULL,
        //     token TINYTEXT NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id)
        //     );
        $db->query("CREATE TABLE ".$prefix."xacminhnhanthongbao (
            id INT NOT NULL AUTO_INCREMENT,
            email VARCHAR(320) NOT NULL,
            token TINYTEXT NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            );");
        // Table nhanthongbao
        // CREATE TABLE ".$prefix."nhanthongbao ( 
        //     id INT NOT NULL AUTO_INCREMENT,
        //     ten VARCHAR(255) NOT NULL,
        //     email VARCHAR(320) NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id),
        //     UNIQUE (email)
        //     );
        $db->query("CREATE TABLE ".$prefix."nhanthongbao ( 
            id INT NOT NULL AUTO_INCREMENT,
            ten VARCHAR(255) NOT NULL,
            email VARCHAR(320) NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE (email)
            );");
        // Table xacminhdoimatkhau
        // CREATE TABLE ".$prefix."xacminhdoimatkhau (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     token TINYTEXT NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id)
        //     );
        $db->query("CREATE TABLE ".$prefix."xacminhdoimatkhau (
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            token TINYTEXT NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            );");
        // Table xacminhdoiemail
        // CREATE TABLE ".$prefix."xacminhdoiemail (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     email_new VARCHAR(320) NOT NULL,
        //     token TINYTEXT NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id)
        //     UNIQUE (tendangnhap)
        //     );
        $db->query("CREATE TABLE ".$prefix."xacminhdoiemail (
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            email_new VARCHAR(320) NOT NULL,
            token TINYTEXT NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            UNIQUE (tendangnhap)
            );");
        // Table xacminhdoiemail
        // CREATE TABLE ".$prefix."xacminh2buocEmail (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     trangthai TINYINT(3) UNSIGNED NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id)
        //     );
        $db->query("CREATE TABLE ".$prefix."xacminh2buocEmail (
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            trangthai TINYINT(3) UNSIGNED NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE (tendangnhap)
            );");
        // Table xm2btokenemail
        // CREATE TABLE ".$prefix."xm2btokenemail (
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     token TINYTEXT NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id)
        //     );
        $db->query("CREATE TABLE ".$prefix."xm2btokenemail (
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            token TINYTEXT NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            );");
        // Table xm2b
        // CREATE TABLE ".$prefix."xm2b ( 
        //     id INT NOT NULL AUTO_INCREMENT,
        //     tendangnhap VARCHAR(255) NOT NULL,
        //     bat_xm2b TINYINT(3) UNSIGNED NOT NULL,
        //     secret_code VARCHAR(64) NOT NULL,
        //     thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        //     PRIMARY KEY (id), UNIQUE (tendangnhap)
        // );
        $db->query("CREATE TABLE ".$prefix."xm2b ( 
            id INT NOT NULL AUTO_INCREMENT,
            tendangnhap VARCHAR(255) NOT NULL,
            bat_xm2b TINYINT(3) UNSIGNED NOT NULL,
            secret_code VARCHAR(64) NOT NULL,
            thoigian TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id), UNIQUE (tendangnhap)
        );");
    }
?>


<?php 
    define('isSet', 1);
    define('SITE_NAME', 'eSEduVN');

    require_once('include/settings.php');

    if(defined('isInstalled')){
        die('<h1>Bạn đã cài đặt thành công eSEduVN rồi, bạn nên xoá file này trên máy chủ để tránh các vấn đề bảo mật!</h1>');
    }
    
    $pageName = 'Cài đặt';

    $content = '';

    $content2 = '';

    $thongBaoLoi = '';

$content = <<<HTML
        <p>Cám ơn bạn đã tải eSEduVN, trước khi có thể sử dụng thì bạn cần phải chạy file caidat.php trước</p>
        <p>Các thông tin bạn sẽ cần:</p>
        <ul>
            <li>Tên máy chủ cơ sở dữ liệu
            <li>Cổng kết nối cơ sở dữ liệu</li>
            <li>Tên cơ sở dữ liệu</li>
            <li>Tên người dùng cơ sở dữ liệu</li>
            <li>Mật khẩu của người dùng cơ sở dữ liệu</li>
        </ul>
        <p>
            Nếu bạn không rõ những thứ bên trên này là gì, vui lòng liên hệ với nhà cung cấp máy chủ của bạn
            để biết thêm thông tin chi tiết.
        </p>
        <p>Bạn nên đọc tài liệu về eSEduVN trước khi sử dụng phần mềm này.</p>
        <a href="?buoc=1" class="btn btn-success btn-block">Bắt đầu cài đặt</a>
HTML;

    if (isset($_GET['buoc'])) {
        switch ($_GET['buoc']) {
            case '1':

                $tenMayChuCsdl = 'localhost';

                $congKetNoiCsdl = 3306;

                $tenCsdl = '';

                $tenNgDungCsdl = '';

                $tienToBangCsdl = 'eseduvn_';

                if (isset($_POST['tenMayChuCsdl'])) {
                    $tenMayChuCsdl = $_POST['tenMayChuCsdl'];

                    $congKetNoiCsdl = $_POST['congKetNoiCsdl'];

                    $tenCsdl = $_POST['tenCsdl'];

                    $tenNgDungCsdl = $_POST['tenNgDungCsdl'];

                    $mkNgDungCsdl = $_POST['mkNgDungCsdl'];

                    $tienToBangCsdl = $_POST['tienToBangCsdl'];
                    
                    if ($tenMayChuCsdl=='' || $congKetNoiCsdl=='' || $tenCsdl=='' || $tenNgDungCsdl=='') {

                        $thongBaoLoi == "Vui lòng điền vào tất cả các ô có đánh dấu (*)";

                    } else {

                        @$connect = mysqli_connect($tenMayChuCsdl, $tenNgDungCsdl, $mkNgDungCsdl, $tenCsdl, $congKetNoiCsdl);

                        if ($connect==false) {
                            
                            $thongBaoLoi = "Đã xảy ra lỗi khi kết nối đến cơ sở dữ liệu, hãy kiểm tra tên máy chủ CSDL, cổng kết nối,
                            tên CSDL, tên người dùng và mật khẩu CSDL trước khi thử lại!";

                        } else {

                            $fileSetting = fopen('include/settings.php', 'w') or die('Không thể mở file settings.php trong thư mục include');

$settings = 
"<?php
\tif(!defined('isSet')){
\t\tdie('<h1>Truy cập trực tiếp bị cấm!</h1>');
\t}
\t// Cấu hình CSDL
\tdefine('DB_HOST', '$tenMayChuCsdl');
\tdefine('DB_PORT', $congKetNoiCsdl);
\tdefine('DB_NAME', '$tenCsdl');
\tdefine('DB_USERNAME', '$tenNgDungCsdl');
\tdefine('DB_PASSWORD', '$mkNgDungCsdl');
\tdefine('DB_TABLE_PREFIX', '$tienToBangCsdl');

\t// Cấu hình trang
\tdefine('AUTHOR', 'eSEduVN');

";

                            fwrite($fileSetting, $settings);

                            fclose($fileSetting);

                            $content2 = "<p>Chúc mừng, hệ thống đã kết nối đến cơ sở dữ liệu thành công,
                            Để tiếp tục, bạn nhấn vào nút bên dưới</p>
                            <a href='?buoc=2' class='btn btn-success btn-block'>Tiếp tục</a>";

                        }

                    }

                }

                $content = '<p>
                        Nếu bạn không rõ những thứ bên dưới này là gì, vui lòng liên hệ với nhà cung cấp máy chủ của bạn
                        để biết thêm thông tin chi tiết.
                    </p>
                    <p>
                        Các ô bắt buộc được đánh dấu (*)
                    </p>
                    <form method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tên máy chủ CSDL (*)</span>
                            </div>
                            <input name="tenMayChuCsdl" type="text" value="'.$tenMayChuCsdl.'" class="form-control" placeholder="Tên máy chủ CSDL" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Cổng kết nối cơ sở dữ liệu (*)</span>
                            </div>
                            <input name="congKetNoiCsdl" value="'.$congKetNoiCsdl.'" type="number" class="form-control" placeholder="Cổng" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tên CSDL (*)</span>
                            </div>
                            <input name="tenCsdl" value="'.$tenCsdl.'" type="text" class="form-control" placeholder="Tên CSDL" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tên người dùng CSDL (*)</span>
                            </div>
                            <input name="tenNgDungCsdl" value="'.$tenNgDungCsdl.'" type="text" class="form-control" placeholder="Tên người dùng CSDL" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Mật khẩu CSDL (*)</span>
                            </div>
                            <input name="mkNgDungCsdl" type="password" class="form-control" placeholder="Mật khẩu CSDL">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tiền tố bảng CSDL (tuỳ chọn)</span>
                            </div>
                            <input name="tienToBangCsdl" value="'.$tienToBangCsdl.'" type="text" class="form-control" placeholder="Mật khẩu CSDL" required>
                        </div>
                        <div><b>'.$thongBaoLoi.'</b></div>
                        <button class="btn btn-success btn-block">Kết nối đến CSDL</button>
                    </form>';

                    if ($content2!='') {
                        $content = $content2;
                    }

                break;

            case '2':
                require_once('include/db.php');

                @$ktra = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)');

                if ($ktra > 0) {

                    header("Location: http://". $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . "?buoc=3");

                } else {

                    $tenWebsite = 'eSEduVN';

                    $hoVaTen = '';

                    $tenNgDung = '';

                    $email = '';

                    if (isset($_POST['tenWebsite'])) {

                        $tenWebsite = mysqli_real_escape_string($db->conn, $_POST['tenWebsite']);
                        
                        $tenNgDung = mysqli_real_escape_string($db->conn, $_POST['tenNgDung']);

                        $hoVaTen = mysqli_real_escape_string($db->conn, $_POST['hoVaTen']);
                        
                        $mkNgDung = mysqli_real_escape_string($db->conn, $_POST['mkNgDung']);
                        
                        $xacnhanMkNgDung = mysqli_real_escape_string($db->conn, $_POST['xacnhanMkNgDung']);

                        $email = mysqli_real_escape_string($db->conn, $_POST['email']);

                        if ($tenNgDung=='' || $hoVaTen=='' || $mkNgDung=='' || $xacnhanMkNgDung=='' || $email=='') {

                            $thongBaoLoi = "Vui lòng điền vào các ô có đánh dấu (*)";

                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                            $thongBaoLoi = "Địa chỉ Email không hợp lệ";

                        } elseif ($mkNgDung!=$xacnhanMkNgDung) {

                            $thongBaoLoi = "Mật khẩu và xác nhận mật khẩu không khớp!";

                        } else {

                            createTable(DB_TABLE_PREFIX);

                            $db->insertMulDataRow(DB_TABLE_PREFIX.'nguoidung', array(
                                'tendangnhap',
                                'email',
                                'matkhaubam'
                            ), array(
                                $tenNgDung,
                                $email,
                                password_hash($mkNgDung, PASSWORD_DEFAULT)
                            ));

                            $db->insertMulDataRow(DB_TABLE_PREFIX.'quyen', array(
                                'tendangnhap',
                                'hovaten',
                                'chucvu',
                                'bomon',
                                'chunhiem',
                                'diemdanh',
                                'tkb',
                                'sodaubai',
                                'la_admin'
                            ), array(
                                $tenNgDung,
                                $hoVaTen,
                                '0',
                                '0',
                                '0',
                                '0',
                                '0',
                                '0',
                                '1'
                            ));

                            $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array(
                                'tencaidat',
                                'giatri'
                            ), array(
                                'giaothuc',
                                stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://'
                            ));

                            $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array(
                                'tencaidat',
                                'giatri'
                            ), array(
                                'diachi',
                                $_SERVER['SERVER_NAME'] . str_replace('/caidat.php', '', $_SERVER['PHP_SELF'])
                            ));

                            $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array(
                                'tencaidat',
                                'giatri'
                            ), array(
                                'ghichu',
                                ''
                            ));

                            $db->insertMulDataRow(DB_TABLE_PREFIX.'caidat', array(
                                'tencaidat',
                                'giatri'
                            ), array(
                                'tenwebsite',
                                $tenWebsite
                            ));

                            $content2 = "<p>Chúc mừng bạn, hệ thống đã thiết lập được 75% tiến độ,
                            Hãy nhấn vào nút bên dưới để tiếp tục đến bước 3</p>
                            <a href='?buoc=3' class='btn btn-success btn-block'>Đi đến bước 3</a>";

                        }
                    }

                    $content = 
                    '<p>Thiết lập chi tiết</p>
                    <form method="POST">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tên website</span>
                            </div>
                            <input value="'.$tenWebsite.'" name="tenWebsite" type="text" class="form-control" placeholder="Tên website">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Họ và tên (*)</span>
                            </div>
                            <input value="'.$hoVaTen.'" name="hoVaTen" type="text" class="form-control" placeholder="Họ và tên" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Tên người dùng (*)</span>
                            </div>
                            <input value="'.$tenNgDung.'" name="tenNgDung" type="text" class="form-control" placeholder="Tên người dùng" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Mật khẩu (*)</span>
                            </div>
                            <input name="mkNgDung" type="password" class="form-control" placeholder="Mật khẩu người dùng" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Xác nhận mật khẩu (*)</span>
                            </div>
                            <input name="xacnhanMkNgDung" type="password" class="form-control" placeholder="Xác nhận mật khẩu" required>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Email (*)</span>
                            </div>
                            <input value="'.$email.'" name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div><b>'.$thongBaoLoi.'</b></div>
                        <button class="btn btn-success btn-block">Lưu</button>
                    </form>';

                    if ($content2!='') {
                        $content = $content2;
                    }

                }

                break;

                case '3':
                    
                    require_once('include/db.php');

                    @$ktra = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'COUNT(*)');

                    if ($ktra==0) {

                        header("Location: http://".$_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . "?buoc=2");

                    } else {

                        if (isset($_POST['xacnhanhoanthanh'])) {
                            if ($_POST['xacnhanhoanthanh']=='true') {
                                $filesettings = fopen('include/settings.php', 'a');
                                
                                fwrite($filesettings, "\tdefine('isInstalled', 1);");

                                fclose($filesettings);

                                header("Location: http://".$_SERVER['SERVER_NAME'] . str_replace('caidat.php', '', $_SERVER['PHP_SELF']));
                            }
                        }

                        $content = "<p>Chúc mừng, bạn đã cài đặt thành công eSEduVN lên hệ thống máy chủ.
                        <b>Hãy nhấn nút bên dưới để hoàn tất cài đặt và chuyển đến trang chủ, nếu bạn không nhấn
                        vào nút bên dưới, eSEduVN sẽ không thể chạy được!</b></p>
                        <form method='POST'>
                            <input type='hidden' value='true' name='xacnhanhoanthanh'>
                            <button class='btn btn-success btn-block'>Hoàn tất cài đặt và đi đến trang chủ</button>
                        </form>";

                    }

                    break;
            
            default:
                die('Lỗi không xác định, hãy thử lại');
                break;
        }
    }

    // Kiểm tra tên miền 
    // echo $_SERVER['SERVER_NAME'];
    // Kiểm tra giao thức
    // echo $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';

    // Insert

    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "sang-$i-gio",
    //     $sang["$i-gio"]
    // ));
    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "sang-$i-phut",
    //     $sang["$i-phut"]
    // ));
    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "chieu-$i-gio",
    //     $chieu["$i-gio"]
    // ));
    // $db->insertMulDataRow(DB_TABLE_PREFIX.'giovaotiet', array(
    //     'ten',
    //     'thoiluong'
    // ), array(
    //     "chieu-$i-phut",
    //     $chieu["$i-phut"]
    // ));
?>
<?php 
    require_once('include/header.php');
?>

    <main class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-4"></div>
                <div class="col-12 col-lg-4 d-flex align-items-center" style="min-height: 100vh;">
                    <div class="card" style="width: 100%">
                        <div class="card-body">
                            <h5 class="card-title text-center">
                                Cài đặt eSEduVN
                            </h5>
                            <div class="card-text">
                                <?php echo $content ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4"></div>
            </div>
        </div>
    </main>

<?php 
    require_once('include/footer.php');
?>
