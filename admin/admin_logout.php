<?php
session_start();
$_SESSION = []; // Unset all session variables
session_destroy();
header("Location: admin_login.php");
exit();
