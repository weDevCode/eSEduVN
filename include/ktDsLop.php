<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if ($db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'))==0 || $db->getMulData(DB_TABLE_PREFIX.'dslop', array('lop'))==0) {

        die('<h1>Quản trị viên hệ thống cần nhập danh sách lớp và khối mới có thể xem trang này (#02)</h1>');

    } else {
        $dskhoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array('khoi'));

        for ($i=0; $i < count($dskhoi); $i++) { 
            
            $count = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'COUNT(*)', 'khoi', $dskhoi[$i]['khoi']);

            if ($count==0) {
            
                die('<h1>Quản trị viên hệ thống cần nhập danh sách lớp và khối mới có thể xem trang này (#02)</h1>');
            
            }
        }

        $count2 = $db->getSingleData(DB_TABLE_PREFIX.'quydinh', 'COUNT(*)', 'buoi', 'a');
        if ($count2>0) {

            die('<h1>Quản trị viên hệ thống cần xác định buổi học của toàn bộ khối. Ví dụ khối nào học buổi sáng, khối nào học buổi chiều (#02.1)</h1>');

        }
    }
?>