<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Truy cập trực tiếp bị cấm!</h1>');
    }

    require_once('db.php');

    $ktAdmin = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'la_admin', 'tendangnhap', $tennguoidung);

    if ($ktAdmin!=1) {
        $url = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'giaothuc').$db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'diachi');
        
        die("<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css' integrity='sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk' crossorigin='anonymous'>
        <h1>Bạn không phải là admin nên bạn không có quyền truy cập trang này! Hãy truy cập một trong các trang bên dưới để tiếp tục</h1>
        <a href='$url/thoikhoabieu/quanly' class='btn btn-success'>Quản lý thời khoá biểu</a>
        <a href='$url/diemdanh/quanly' class='btn btn-success'>Quản lý điểm danh</a>
        <a href='$url/sodaubai/quanly' class='btn btn-success'>Quản lý sổ đầu bài</a>
        <a href='$url/thoikhoabieu' class='btn btn-info'>Xem trang thời khoá biểu</a>
        <a href='$url/diemdanh' class='btn btn-info'>Xem trang điểm danh</a>
        <a href='$url/sodaubai' class='btn btn-info'>Xem trang sổ đầu bài</a>");
    }
?>