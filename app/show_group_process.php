<?php
include_once './include_mini.php';

$id = $_POST['id'];

$query = "UPDATE `comps` SET hidden=0 WHERE id='$id'";
$result = mysql_query($query);