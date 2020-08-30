<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    
    define('isSet', 1);

    require_once('include/db.php');

    require_once('include/init_include.php');

    $pageName = "Trang chủ";

    require_once('include/header.php');
    
    require_once('include/menu_non_sadmin.php');

    $content = $db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat', 'ghichu');
?>

<main style="min-height: 65vh; padding: 25px 0">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-center"><?php echo SITE_NAME ?></h1>
                <div class="thongbao">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">
                                Thông báo
                            </h2>
                            <p class="card-text">
                                <?php echo $content ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-4"><a href="<?php echo $url ?>/diemdanh" class="btn btn-primary btn-block">Điểm danh</a></div>
            <div class="col-12 col-lg-4"><a href="<?php echo $url ?>/thoikhoabieu" class="btn btn-success btn-block">Thời khoá biểu</a></div>
            <div class="col-12 col-lg-4"><a href="<?php echo $url ?>/sodaubai" class="btn btn-secondary btn-block">Sổ đầu bài</a></div>
        </div>
    </div>
</main>

<?php 
    require_once('include/footer-module.php');
    require_once('include/footer.php');
?>