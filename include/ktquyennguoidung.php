<?php 
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }

    function ktQuyen(string $quyen)
    {
        global $db, $tennguoidung;

        $ktraquyen = $db->getSingleData(DB_TABLE_PREFIX.'quyen', $quyen, 'tendangnhap', $tennguoidung);
        
        $la_admin = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'la_admin', 'tendangnhap', $tennguoidung);

        if ($ktraquyen==1||$la_admin==1) {
            // đủ quyền
        } else {
            die("Bạn không có quyền truy cập trang này!");
        }
    }
?>