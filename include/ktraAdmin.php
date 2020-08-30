<?php 
    if(!defined('isSet')){
        die('<h1>Truy cập trực tiếp bị cấm!</h1>');
    }

    require_once('db.php');

    $ktAdmin = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'la_admin', 'tendangnhap', $tennguoidung);

    if ($ktAdmin!=1) {
        die('<h1>Bạn khôn phải là admin nên bạn không có quyền truy cập trang này! Hãy quay lại trang trước để tiếp tục</h1>');
    }
?>