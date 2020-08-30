<?php 
    
    if ($db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'))==0 || $db->getMulData(DB_TABLE_PREFIX.'dslop', array('lop'))==0) {

        die('<h1>Quản trị viên eSEduVN cần nhập danh sách lớp và khối mới có thể xem trang này (#02)</h1>');

    } else {
        $dskhoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'));

        for ($i=0; $i < count($dskhoi); $i++) { 
            
            $count = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)', 'khoi', $dskhoi[$i]['khoi']);
            
            if ($count==0) {
            
                die('<h1>Quản trị viên eSEduVN cần nhập danh sách lớp và khối mới có thể xem trang này (#02)</h1>');
            
            }
        }
    }
?>