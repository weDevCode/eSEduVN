<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }

    $soluongngay = $db->getSingleData(DB_TABLE_PREFIX.'luutrungay', 'COUNT(*)');

    if ($soluongngay>365) {
        $delURL = $url.'/quantri/xoasoluongngay.php';

        $thong_bao = "Bạn cần phải xoá số lượng ngày cũ trước khi có thể tiếp tục. Khi thông báo này xuất hiện đồng nghĩa với việc
        người dùng hiện tại sẽ không thể nhập dữ liệu lên các trang điểm danh, sổ đầu bài được nữa.
        Để có thể xoá dữ liệu cũ, bạn truy cập tại đây: <a href='$delURL'>$delURL</a>";
    }
?>