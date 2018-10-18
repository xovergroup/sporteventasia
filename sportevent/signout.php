<?php
include "inc/app-top.php";

session_destroy();
header("Location: index.php?msg=3");

?>