<?
include_once ('./include_mini.php');

$team_id = $_POST['team_id'];
$comp_id = $_POST['comp_id'];

$query = "DELETE FROM `ct_pairs` WHERE team_id='$team_id' AND comp_id='$comp_id'";
$result = mysql_query($query);

$query = "DELETE FROM `event_rosters` WHERE team_id='$team_id' AND comp_id='$comp_id'";
$result = mysql_query($query);
?>