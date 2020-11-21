<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $url ?>/quantri"><?php echo SITE_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Xem trang
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="..">Trang chủ</a>
                <a class="dropdown-item" href="../thongbao">Thông báo</a>
                <a class="dropdown-item" href="../diemdanh">Điểm danh</a>
                <a class="dropdown-item" href="../sodaubai">Sổ đầu bài</a>
                <a class="dropdown-item" href="../thoikhoabieu">Thời khoá biểu</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="thanhvien">Quản lý thành viên</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="quanlylopvskhoi">Quản lý lớp & khối</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="capnhatdulieu">Cập nhật dữ liệu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="capnhatthongbao">Cập nhật thông báo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="caidatchung">Cài đặt chung</a>
        </li>
        </ul>
        <a href="../dangxuat"><button class="btn btn-danger">Đăng xuất</button></a>
    </div>
</nav>