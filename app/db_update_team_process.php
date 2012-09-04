<?php
include_once './include_mini.php';

if (editCheck(1)) {

    $name = mysql_real_escape_string($_POST['name']);
    $short = mysql_real_escape_string($_POST['short']);
    $num = mysql_real_escape_string($_POST['num']);

    $query = "INSERT INTO `teams` VALUES ('','0','{$_SESSION['user']}','$num','$name','$short')";
    $result = mysql_query($query);
}
