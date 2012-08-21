<?php
include_once ('./include_mini.php');

$login = mysql_real_escape_string($_POST['login']);
$pw = mysql_real_escape_string($_POST['pw']);
if($pw){
$pw = md5($pw);
$pwq = " password='$pw',";
}
else
{
$pwq = '';
}

$user_id = $_POST['user_id'];
$access = $_POST['access'];
if(!$access){$access=4;}
$team = $_POST['team'];

$query = "UPDATE `users` SET login='$login',$pwq team='$team', access='$access' WHERE id='$user_id'";
$result = mysql_query($query);
echo $query;
?>