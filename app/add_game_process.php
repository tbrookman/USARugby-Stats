<?
include_once ('./include_mini.php');

$field = $_POST['field'];
$game_num = $_POST['gnum'];
$kod = $_POST['kdate'];
$koh = $_POST['koh'];
$kom = $_POST['kom'];
$home = $_POST['home'];
$away = $_POST['away'];
$comp_id = $_POST['comp_id'];

$kod = date('Y-m-d',$kod);
$kfull = $kod.' '.$koh.':'.$kom.':00';

$query = "INSERT INTO `games` VALUES ('','{$_SESSION['user']}','$comp_id','$game_num','$home','$away','$kfull','$field','0','0','0','0','0','0','0')";
$result = mysql_query($query);

$now = date('Y-m-d H:i:s');
$numbers = '-1-2-3-4-5-6-7-8-9-10-11-12-13-14-15-16-17-18-19-20-21-22-23-24-25-26-27-28-29-30-';
$frontrows = '-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-0-';

$game_id = mysql_insert_id();

$query = "INSERT INTO `game_rosters` VALUES ('','{$_SESSION['user']}','$now','$comp_id','$game_id','$home','','$numbers','$frontrows')";
$result = mysql_query($query);

$query = "INSERT INTO `game_rosters` VALUES ('','{$_SESSION['user']}','$now','$comp_id','$game_id','$away','','$numbers','$frontrows')";
$result = mysql_query($query);

?>