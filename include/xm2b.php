<?php 
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }

    require_once("2faLib/vendor/autoload.php");

    $tfa = new RobThree\Auth\TwoFactorAuth("eSEduVN");

    $secret = $tfa->createSecret();
?>