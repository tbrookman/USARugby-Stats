<?php
include_once ('./include_mini.php');

$id = $_POST['id'];
$game_id = $_POST['game_id'];

$query = "SELECT * FROM `game_events` WHERE id = $id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$type = $row['type'];
}

if ($type == 11 || $type == 13 || $type == 15 || $type == 17)
{
$pid = $id+1;
}
else
{
$pid = $id-1;
}

$query = "DELETE FROM `game_events` WHERE id='$id' OR id='$pid'";
$result = mysql_query($query);

?>