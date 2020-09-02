<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/init_include.php');
    
    require_once('../include/loginCheck.php');

    require_once('../include/db.php');

    require_once('../include/include.php');

    require_once('../include/ktraAdmin.php');

    $pageName = 'Cập nhật eSEduVN';

    $thong_bao = '';

    require_once('../include/365ngay.php');
?>

<?php 
    require_once('../include/header.php');
    require_once('../include/menu_sadmin.php');
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col"><?php echo $pageName ?></div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    require_once('../include/footer.php');
?>  