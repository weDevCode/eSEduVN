<?php 
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><?php echo SITE_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $url ?>">Trang chủ</a>
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
        <a href="<?php echo $url ?>/quantri"><button class="btn btn-info">Quản trị</button></a>
    </div>
</nav>