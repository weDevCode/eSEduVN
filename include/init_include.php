<?php 
    $giaothuc = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "giaothuc");
    $url = $giaothuc.$db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', "diachi");
?>