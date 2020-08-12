<?php 
    if (isset($_SESSION['khoaphien'])) {
        $khoaphien = $_SESSION['khoaphien'];
        $tennguoidung = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'tendangnhap', 'khoaphien', "$khoaphien");
    } elseif(isset($_COOKIE['khoaphien'])) {
        $khoaphien = $_COOKIE['khoaphien'];
        $tennguoidung = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'tendangnhap', 'khoaphien', "$khoaphien");
    }
?>