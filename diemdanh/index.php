<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);
    require_once('../include/db.php');
    $pageName = 'Điểm danh';
    require_once('../include/init_include.php');
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_non_sadmin.php');
    require_once('../include/ktngayluutru.php');
    require_once("../include/ktgiovaotiet.php");
    require_once("../include/ktThoigianhientai.php");
    $content = '';
    $js = '';
    
?>

<div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-3 col-lg-4" id="dslop">
                <h3 class="text-center">Danh sách lớp</h3>
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
                                $id = $db->getSingleData(DB_TABLE_PREFIX.'dslop', 'id', 'lop', $_lop);
                                $html .= "<a href='?id=$id' class='list-group-item text-dark' style='font-weight: bold'>Lớp $_lop</a>";
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

<?php 
    require_once('../include/footer-module.php');
    echo "<script>";
    echo $js;
    echo "</script>";
    require_once('../include/footer.php');
?>