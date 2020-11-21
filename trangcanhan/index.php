<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/db.php');

    require_once('../include/init_include.php');

    $pageName = "Trang cá nhân";

    require_once('../include/header.php');
    
    require_once('../include/menu_non_sadmin.php');

    require_once('../include/loginCheck.php');

    
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-12"></div>
            <div class="col-lg-6 col-12"></div>
        </div>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    require_once('../include/footer.php');
?>