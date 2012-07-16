<?
include_once ('./include_mini.php');

$game_id = $_POST['game_id'];
$field = $_POST['field'];
$game_num = $_POST['gnum'];
$kod = $_POST['kdate'];
$koh = $_POST['koh'];
$kom = $_POST['kom'];

$kod = date('Y-m-d',$kod);
$kfull = $kod.' '.$koh.':'.$kom.':00';

$query = "UPDATE `games` SET user_create='{$_SESSION['user']}', comp_game_id='$game_num', kickoff='$kfull', field_num='$field' WHERE id='$game_id'";
$result = mysql_query($query);
?>