<?
include_once ('./include_mini.php');

$id = $_POST['user_id'];

$query = "DELETE FROM `users` WHERE id='$id'";
$result = mysql_query($query);

?>