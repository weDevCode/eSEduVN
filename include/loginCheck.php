<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    require_once('db.php');

    @session_start();

    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "giaothuc");
    
    $redt = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "diachi").'/dangxuat';
    
    if (!isset($_COOKIE['khoaphien'])&&!isset($_SESSION['khoaphien'])) {
    
        header("Location: ".$giaothuc.$redt, true, 303);
    
    } elseif (isset($_SESSION['khoaphien'])) {
    
        $khoaphien = mysqli_real_escape_string($db->conn, $_SESSION['khoaphien']);
    
        $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', "$khoaphien");
    
        if ($check == 0) {
    
            header("Location: ".$giaothuc.$redt, true, 303);
    
        }
    
    } else {
    
        $khoaphien = mysqli_real_escape_string($db->conn, $_COOKIE['khoaphien']);
    
        $check = $db->getSingleData(DB_TABLE_PREFIX.'phien', 'COUNT(*)', 'khoaphien', "$khoaphien");
    
        if ($check == 0) {
    
            header("Location: ".$giaothuc.$redt, true, 303);
    
        }
    
    }

    
?>