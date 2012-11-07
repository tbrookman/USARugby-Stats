<?php
include_once './session.php';
$_SESSION = array(); // destroy all $_SESSION data
setcookie(session_name(), "", time() - 3600, "/");
session_destroy();
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
