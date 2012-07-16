<?
include_once ('./include_mini.php');

$roster_id = $_POST['roster_id'];
$player_ids = $_POST['players'];

//players is an array to hold current player ids which is string seperated by -
$players = array();
$players = explode('-',substr($player_ids,1,(strlen($player_ids)-2)));

//Use our player ID's to get their names: lastname, firstname
$options=array();
foreach ($players as $player){
$options[$player]=rplayerName($player);
}

//Get options into alphebetical order
asort($options);

//Glue string back together separated by -
$player_ids = implode('-',array_keys($options));
$player_ids = '-'.$player_ids.'-';

$query = "UPDATE `event_rosters` SET player_ids='$player_ids' WHERE id='$roster_id'";
$result = mysql_query($query);

?>