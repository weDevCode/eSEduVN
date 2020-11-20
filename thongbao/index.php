<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    define('isSet', 1);

    require_once('../include/db.php');

    $pageName = 'Thông báo';

    require_once('../include/init_include.php');

    require_once('../include/ktDsLop.php');
?>

<?php
    require_once('../include/header.php');

    require_once('../include/menu_non_sadmin.php');

    require_once('../include/ktngayluutruTXem.php');

    require_once("../include/ktgiovaotiet.php");

    require_once("../include/ktThoigianhientai.php");

    $html = '';
    $trang= 1;
    $count = $db->getSingleData(DB_TABLE_PREFIX.'thongbao', 'COUNT(*)');
    if ($count > 0) {
        $arr = $db->getMulData(DB_TABLE_PREFIX.'thongbao', array('tieude','noidung','thoigian'));
        if (isset($_GET['trang'])) {
            $trang = mysqli_real_escape_string($db->conn, $_GET['trang']);
            if ($trang > ceil($count/10)) {
                thongBao('Số trang quá to so với số lượng thông báo','thatbai');
            }
            $tbdau = ($trang-1)*10;
            $tbcuoi = $tbdau+9;
            if ($count-1>=$tbdau && $count-1<=$tbcuoi) { // nếu count nằm trong khoảng
                $tbcuoi = $count-1;
            }
        } else { // nếu không đặt trang
            $tbdau = 0;
            // nếu count <= 10
            if ($count <= 10) {
                $tbcuoi = $count-1;
            } else {
                $tbcuoi = 9;
            }
            
        }

        for ($i=$tbcuoi; $i >= $tbdau; $i--) {
            $html .= "<div class='card'>
            <div class='card-body'>
                <h3 class='card-title'>".$arr[$i]['tieude']."</h3>
                ".$arr[$i]['noidung']."
                <h6><span class='badge badge-primary'>".$arr[$i]['thoigian']."</span></h6>
                </div>
            </div>";
        }
        $max = ceil($count/10);
    } else {
        $max = 0;
    }

    function thongBao($loinhan, $loai)
    {
        global $url;
        header('Location: '.$url."/quantri/capnhatthongbao?thongbao=$loai&loinhan=$loinhan!", true);
        die();
    }

    $thongbaoHTML = '';
    if (isset($_GET['thongbao'])) {
        $thongbao = $_GET['thongbao'];
        if (isset($_GET['loinhan'])) {
            $loinhan = htmlspecialchars($_GET['loinhan']);
        } else {
            $loinhan = '';
        }
        switch ($thongbao) {
            case 'thanhcong':
                $thongbaoHTML = "<div class='alert alert-success' role='alert'>$loinhan</div>";
                break;

            case 'thatbai':
                $thongbaoHTML = "<div class='alert alert-danger' role='alert'>$loinhan</div>";
                break;
        }
    }

?>

<main>
    <div class="container-fluid" id="main">
        <div class="row">
            <div class="col">
                <h2 class="text-center"><?php echo $pageName ?></h2>
                <p class="text-center">Nơi cập nhật những thông báo mới nhất</p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <?php echo $thongbaoHTML ?>
            </div>
        </div>

        <form method='POST' class="row">
            <div class="col-4">
                <input type="text" placeholder="Tên" name="ten" id="ten" class='form-control' required>
            </div>
            <div class="col-4">
                <input type="email" placeholder="Email" name="email" id="email" class='form-control' required>
            </div>
            <div class="col-4"><button class="btn btn-block btn-success">Nhận thông báo qua email</button></div>
        </form>

        <div class="row">
            <div class="col">
                <?php echo $html ?>
            </div>
        </div>

        <form method="GET" class="row">
            <div class="col-2">
                <label for="trang">Nhập trang để tìm</label>
            </div>
            <div class="col-8">
                <input type="number" min="1" max='<?php echo $max ?>' value='<?php echo $trang ?>' name="trang" id="trang" class="form-control">
            </div>
            <div class="col-2">
                <button class="btn btn-info btn-block">Tra cứu</button>
            </div>
        </form>
    </div>
</main>

<?php 
    require_once('../include/footer-module.php');
    echo "<script>";
    echo $js;
    echo "</script>";
    require_once('../include/footer.php');
?>