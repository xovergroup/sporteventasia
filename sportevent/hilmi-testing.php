<?php 
include_once "inc/app-top-index.php";
include_once "organizer/classes/CRUD.php";
include_once "organizer/classes/Order.php";
include_once "organizer/classes/Miscellaneous.php";


/*

$order = new Order($mysqli, "SELECT register_order_no FROM event_registration ORDER BY register_id DESC LIMIT 1");

echo $order->generateNewOrderNo();
*/

$misc = new Miscellaneous();


echo $unique1 = $misc->generateUniqueRandStr(true, true, true); echo "<br>";
echo $unique2 = $misc->generateUniqueRandStr(true, true, true); echo "<br>";

include_once "inc/app-bottom.php"; 
?>