<?php 
    $giovaotietdb = $db->getMulData(DB_TABLE_PREFIX.'giovaotiet', array(
        'ten',
        'thoiluong'
    ));

    if (count($giovaotietdb)==20) {

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