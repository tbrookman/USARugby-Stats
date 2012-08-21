<?php
include_once ('./include_mini.php');

$team_id = $_POST['team'];
$comp_id = $_POST['comp_id'];

$query = "INSERT INTO `ct_pairs` VALUES ('','$comp_id','$team_id')";
$result = mysql_query($query);

date_default_timezone_set('America/Detroit');
$edate = date('Y-m-d H:G:i');

$query = "INSERT INTO `event_rosters` VALUES ('','{$_SESSION['user']}','$edate','$comp_id','$team_id','')";
$result = mysql_query($query);

?>