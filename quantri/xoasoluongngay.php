<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/init_include.php');

    require_once('../include/loginCheck.php');
    
    require_once('../include/db.php');

    require_once('../include/ktraAdmin.php');
    
    $pageName = 'Xoá số lượng ngày';
    
    $thong_bao = '<form method="post">
    <h3>Bạn có đồng ý xoá số lượng ngày hiện tại trong cơ sở dữ liệu không?</3>
    <p>Việc này sẽ xoá toàn bộ dữ liệu điểm danh và sổ đầu bài hiện tại!!</p>
    <input type="hidden" name="xacnhan" value="true">
    <button>Đồng ý</button>
    </form>';

    if (isset($_POST['xacnhan'])) {
        if ($_POST['xacnhan']=='true') {
            $table = DB_TABLE_PREFIX.'luutrungay';
            $db->query("DELETE FROM $table");
            $table = DB_TABLE_PREFIX.'dsdiemdanhcaclop';
            $db->query("DELETE FROM $table");
            $table = DB_TABLE_PREFIX.'sodaubai';
            $db->query("DELETE FROM $table");
            $urlQuanTri = $url.'/quantri/';
            $thong_bao = "Đã xoá thành công, <a href='$urlQuanTri'>nhấn vào đây để quay lại trang quản lý</a>";
        }
    }
?>

<div class="thongbao">
    <?php echo $thong_bao ?>
</div>