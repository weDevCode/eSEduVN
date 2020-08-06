<?php 
    /**
     * Return the current date
     * @return string
     */
    function currentDate()
    {
        return date("d")."/".date("m")."/".date("Y");
    }
    $ktsoluongngay = $db->getSingleData(DB_TABLE_PREFIX.'luutrungay', 'COUNT(*)');
    if ($ktsoluongngay > 365) {
        $content = "<b>Bạn cần liên hệ với quản trị viên để xoá bớt dữ liệu để tiếp tục.</b>";
    } else {
        $ktngay = $db->getSingleData(DB_TABLE_PREFIX.'luutrungay', 'COUNT(*)', 'ngay', currentDate());
        if ($ktngay==0) {
            $db->insertADataRow(DB_TABLE_PREFIX.'luutrungay', 'ngay', currentDate());
        }
    }
?>