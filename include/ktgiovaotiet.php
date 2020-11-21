<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    $giovaotietdb = $db->getMulData(DB_TABLE_PREFIX.'giovaotiet', array(
        'ten',
        'thoiluong'
    ));
    if ($giovaotietdb==0) {

        die("<h1>Bạn cần liên hệ quản trị viên để cập nhật dữ liệu giờ vào tiết mới có thể sử dụng được (#03)</h1>");

    } elseif ($db->getSingleData(DB_TABLE_PREFIX.'caidat', 'giatri', 'tencaidat','thoiluongtiet')=='') {

        die("<h1>Bạn cần liên hệ quản trị viên để cập nhật dữ liệu thời lượng buổi học mới có thể sử dụng được (#04)</h1>");

    } elseif (count($giovaotietdb)==20) {

        for ($i=0; $i < count($giovaotietdb); $i++) { 

            $ten1 = ''; $ten2 = '';

            foreach ($giovaotietdb[$i] as $key => $value) {

                if ($key == 'ten') {

                    $ten1 = $value;

                } elseif ($key == 'thoiluong') {

                    $ten2 = $value;

                }

                $giovaotiet[$ten1] = $ten2;

            }
        }

        for ($i=1; $i < 6; $i++) {

            $sang["$i-gio"] = $giovaotiet["sang-$i-gio"];

            $sang["$i-phut"] = $giovaotiet["sang-$i-phut"];

            $chieu["$i-gio"] = $giovaotiet["chieu-$i-gio"];

            $chieu["$i-phut"] = $giovaotiet["chieu-$i-phut"];
            
        }
    }

    

    
?>