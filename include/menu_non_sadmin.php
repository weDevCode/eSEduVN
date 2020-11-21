<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }

    $buttons = "<a href='$url/quantri'><button class='btn btn-success'>Đăng nhập</button></a>";

    $style = "style='margin: 0 2px; vertical-align: middle'";

    if (!isset($_COOKIE['khoaphien'])&&!isset($_SESSION['khoaphien'])) {
    
        $buttons;
    
    } elseif (isset($_SESSION['khoaphien'])) {
    
        $khoaphien = mysqli_real_escape_string($db->conn, $_SESSION['khoaphien']);
    
        $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', "$khoaphien");
    
        if ($check > 0) {

            $ktAdmin = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'la_admin', 'tendangnhap', $tennguoidung);
    
            if ($ktAdmin == 1) {
                $buttons = "<a href='$url/quantri' $style><button class='btn btn-info'>Quản trị</button></a>
                <a href='$url/trangcanhan' $style><button class='btn btn-success'>Trang cá nhân</button></a>
                <a href='$url/dangxuat' $style><button class='btn btn-danger'>Đăng xuất</button></a>";
            } else {
                $buttons = "<a href='$url/trangcanhan'><button class='btn btn-info' $style>Trang cá nhân</button></a>
                <a href='$url/dangxuat' $style><button class='btn btn-danger'>Đăng xuất</button></a>";
            }

    
        }
    
    } else {
    
        $khoaphien = mysqli_real_escape_string($db->conn, $_COOKIE['khoaphien']);
    
        $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', "$khoaphien");
    
        if ($check > 0) {
    
            $ktAdmin = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'la_admin', 'tendangnhap', $tennguoidung);
    
            if ($ktAdmin == 1) {
                $buttons = "<a href='$url/quantri' $style><button class='btn btn-info'>Quản trị</button></a>
                <a href='$url/trangcanhan' $style><button class='btn btn-success'>Trang cá nhân</button></a>
                <a href='$url/dangxuat' $style><button class='btn btn-danger'>Đăng xuất</button></a>";
            } else {
                $buttons = "<a href='$url/trangcanhan' $style><button class='btn btn-info'>Trang cá nhân</button></a>
                <a href='$url/dangxuat' $style><button class='btn btn-danger'>Đăng xuất</button></a>";
            }
    
        }
    
    }
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $url ?>"><?php echo SITE_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url ?>">Trang chủ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url ?>/thongbao" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Thông báo
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?php echo $url ?>/thoikhoabieu" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Thời khoá biểu
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo $url ?>/thoikhoabieu">Xem</a>
                    <a class="dropdown-item" href="<?php echo $url ?>/thoikhoabieu/quanly">Quản lý</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?php echo $url ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sổ Đầu Bài
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo $url ?>/sodaubai">Xem</a>
                    <a class="dropdown-item" href="<?php echo $url ?>/sodaubai/quanly">Quản lý</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?php echo $url ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Điểm danh
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo $url ?>/diemdanh">Xem</a>
                    <a class="dropdown-item" href="<?php echo $url ?>/diemdanh/quanly">Quản lý</a>
                </div>
            </li>
        </ul>
        <?php echo $buttons ?>
    </div>
</nav>