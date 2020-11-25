<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }
    if ($pageName=='') {
        $pageName = 'Không tên';
    }
    @session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageName." - ".SITE_NAME ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        main {
            min-height: 65vh; 
            padding: 25px 0;
        }

        #footer {
            padding-top: 20px;
        }

        #dslop ul li {
            list-style: none;
        }

        #dslop ul {
            padding: 0;
        }

        #dslop button {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <noscript>
        <div style="position: fixed; top: 0px; left: 0px; z-index: 3000; height: 100vh; width: 100%; background-color: #FFFFFF">
            <h1 style="margin-left: 10px; color: red">Trình duyệt không hỗ trợ Javascript hoặc Javascript đã bị tắt. Bạn vui lòng dùng trình duyệt
        khác hoặc bật Javascript lên để tiếp tục!!</h1>
        </div>
        <style>
            #main {
                display: none;
            }
        </style>
    </noscript>