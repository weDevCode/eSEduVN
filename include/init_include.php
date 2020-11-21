<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Truy cập trực tiếp bị cấm!</h1>');
    }

    require_once('db.php');

    if (!defined('isInstalled')){
        die('<h1>Bạn cần chạy file caidat.php của eSEduVN trước khi sử dụng! (#00)</h1>');
    }

    require_once('include.php');

    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX."caidat", "giatri", "tencaidat", "giaothuc");

    $url = $giaothuc.$db->getSingleData(DB_TABLE_PREFIX."caidat", "giatri", "tencaidat", "diachi");

    define("SITE_NAME", $db->getSingleData(DB_TABLE_PREFIX."caidat", "giatri", "tencaidat", "tenwebsite"));

    date_default_timezone_set("Asia/Ho_Chi_Minh");    
?>