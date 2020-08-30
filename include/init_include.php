<?php 
    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX."caidat", "giatri", "tencaidat", "giaothuc");

    $url = $giaothuc.$db->getSingleData(DB_TABLE_PREFIX."caidat", "giatri", "tencaidat", "diachi");

    define("SITE_NAME", $db->getSingleData(DB_TABLE_PREFIX."caidat", "giatri", "tencaidat", "tenwebsite"));

    date_default_timezone_set("Asia/Ho_Chi_Minh");
    
    if(!defined('isInstalled')){
        die('<h1>Bạn cần chạy file install.php '.AUTHOR.' trước khi sử dụng!</h1>');
    }
?>