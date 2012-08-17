<?php
include_once './config.php';
$username = $config['username'];
$password = $config['password'];
$database = $config['database'];
$server   = $config['server'] ? $config['server'] : 'localhost';

mysql_connect($server,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
?>