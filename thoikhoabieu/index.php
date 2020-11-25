<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);
    require_once('../include/db.php');
    $pageName = 'Thời khoá biểu';
    require_once('../include/init_include.php');
    require_once('../include/ktDsLop.php');
?>

<?php 
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $check_id = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'COUNT(*)', 'id', $id);
        if ($check_id > 0) {
            $lop = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'lop', 'id', $id);

            $chunhiemlophientai = $db->getSingleData(DB_TABLE_PREFIX.'quyen', 'hovaten', 'chunhiem', $lop);

            if ($chunhiemlophientai === '0') {
                $chunhiemlophientai = 'Không có';
            }

            $content = "<h3 class='text-center'>Thời khoá biểu lớp $lop (GVCN: $chunhiemlophientai)</h3>";
            $content .= $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'noidung', 'id', $id);
        } else {
            $content = "<p>Lỗi, không tìm thấy thời khoá biểu nào có id($id) được chỉ định</p>";
        }
    } else {
        $content = "<p>Đây là trang dùng để xem thời khoá biểu của toàn bộ các lớp, hãy chọn 1 lớp để tiếp tục</p>";
    }
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_non_sadmin.php');
?>
<main>
    <div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-3 col-lg-4" id="dslop">
                <button id="dslopToggle" class="btn btn-info btn-block">Danh sách lớp (nhấn để hiện/ẩn)</button>
                <ul>
                    <?php 
                        $phtml = '';
                        $khoi = $db->getMulData(DB_TABLE_PREFIX.'dskhoi', array(
                            'khoi'
                        ));
                        
                        for ($i=0; $i < count($khoi); $i++) {
                            $_khoi = $khoi[$i]['khoi'];
                            $html = 
                            <<<HTML
                                <li>
                                    <h3>Khối $_khoi</h3>
                                    <div class="card">
                                        <div class="list-group list-group-flush">
                            HTML;
                            $cac_lop = $db->getMulData(DB_TABLE_PREFIX.'dslop', array(
                                'lop',
                                'khoi'
                            ), 'khoi', $_khoi);
                            for ($j=0; $j < count($cac_lop); $j++) { 
                                $_lop = $cac_lop[$j]['lop'];
                                $id = $db->getSingleData(DB_TABLE_PREFIX.'tkb', 'id', 'lop', $_lop);
                                if ($id == 0) {
                                    $html .= 
                                    <<<HTML
                                        <span class="list-group-item text-dark">Lớp $_lop</span>
                                    HTML;
                                } else {
                                    $html .= "<a href='?id=$id' class='list-group-item text-dark' style='font-weight: bold'>Lớp $_lop</a>";
                                }
                            }
                            $html .= 
                            <<<HTML
                                        </div>
                                    </div>
                                </li>
                            HTML;
                            $phtml .= $html;
                        }
                        echo $phtml;
                    ?>
                </ul>
            </div>
            <div class="col-12 col-md-9 col-lg-8" id="tkb">
                <?php 
                    echo $content;
                ?>
            </div>
        </div>
    </div>
</main>
<?php 
    require_once('../include/footer-module.php');
?>  

<?php 
    require_once('../include/footer.php');
?>