<?php
include_once './include_mini.php';

$id = $_POST['id'];

$query = "UPDATE `teams` SET hidden=1 WHERE id='$uuid'";
$result = mysql_query($query);
