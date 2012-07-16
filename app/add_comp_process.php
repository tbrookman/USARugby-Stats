<?
include_once ('./include_mini.php');

$name = mysql_real_escape_string($_POST['name']);
$type = mysql_real_escape_string($_POST['type']);
$max_event = mysql_real_escape_string($_POST['max_event']);
$max_match = mysql_real_escape_string($_POST['max_match']);
$start_date = mysql_real_escape_string($_POST['start_date']);
$end_date = mysql_real_escape_string($_POST['end_date']);

$query = "INSERT INTO `comps` VALUES ('','{$_SESSION['user']}','$name','$start_date','$end_date','$type','$max_event','$max_match','0')";
$result = mysql_query($query);

header("Location: http://" . $_SERVER['HTTP_HOST']);

?>
