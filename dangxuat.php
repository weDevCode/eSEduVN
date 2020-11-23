<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);
    require_once('include/db.php');
    @session_start();
    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "giaothuc");
    $redt = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "diachi").'/dangnhap';
    $khoaphien = '';
    if (isset($_SESSION['khoaphien'])) {
        $khoaphien = $_SESSION['khoaphien'];
    } elseif (isset($_COOKIE['khoaphien'])) {
        $khoaphien = $_COOKIE['khoaphien'];
    }
    session_destroy();
    setcookie('khoaphien', "", time() - (86400 * 365), "/");
    if ($khoaphien!='') {
        $result = $db->deleteADataRow(DB_TABLE_PREFIX.'phien', 'khoaphien', $khoaphien);
    }
    header("Location: ".$giaothuc.$redt, true, 303);
?>