<?php 
    define('isSet', 1);
    require_once('include/db.php');
    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "giaothuc");
    $redt = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "diachi").'/dangnhap';
    session_start();
    session_unset();
    session_destroy();
    setcookie('khoaphien', "", time() - (86400 * 365), "/");
    echo $giaothuc.$redt;
    header("Location: ".$giaothuc.$redt, true, 303);
?>