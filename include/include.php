<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    @session_start();
    if (isset($_SESSION['khoaphien'])) {
        $khoaphien = mysqli_real_escape_string($db->conn, $_SESSION['khoaphien']);

        $tennguoidung = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'tendangnhap', 'khoaphien', "$khoaphien");
    } elseif(isset($_COOKIE['khoaphien'])) {
        $khoaphien = mysqli_real_escape_string($db->conn, $_COOKIE['khoaphien']);
        
        $tennguoidung = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'tendangnhap', 'khoaphien', "$khoaphien");
    }
?>