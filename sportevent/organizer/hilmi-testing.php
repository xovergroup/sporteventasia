<?php 
include_once "inc/app-top.php";
include_once "classes/CustomDateTime.php";
include_once "classes/Price.php";

$price = new Price();



$price->today = "2018-09-29";
$price->earlyBirdEndDate = "2018-09-27";
$price->fullPrice = 70;
$price->earlyBirdPrice = 50;

$price->checkEarlyBirdPrice();
echo $price->realPrice;



include_once "inc/app-bottom.php"; 

?>