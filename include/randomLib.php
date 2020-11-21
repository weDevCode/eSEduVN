<?php 
    /*============================
        eSEduVN (e-systemEduVN)
        Made with love by Tien Minh Vy
    ============================*/
    if(!defined('isSet')){
        die('<h1>Direct access is not allowed!</h1>');
    }
    require_once("RandomLib/vendor/autoload.php");
    $factory = new RandomLib\Factory;
    $generatorLow = $factory->getLowStrengthGenerator();
    $generatorMedium = $factory->getMediumStrengthGenerator();
    $generatorHigh = $factory->getHighStrengthGenerator();
?>