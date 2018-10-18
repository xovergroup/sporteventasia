<?php
include "inc/app-top.php";

session_destroy();
header("Location: login-admin.php?msg=2");

?>