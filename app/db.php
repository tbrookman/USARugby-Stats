<?php
include_once './config.php';
$username = $config['username'];
$password = $config['password'];
$database = $config['database'];

mysql_connect(localhost,$username,$password);  
@mysql_select_db($database) or die( "Unable to select database");
?>