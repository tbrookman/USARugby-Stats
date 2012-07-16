<?
include_once ('./include_mini.php');

if(editCheck(1)){

$login = mysql_real_escape_string($_POST['login']);
$pw = md5(mysql_real_escape_string($_POST['pw']));
$access = $_POST['access'];
if(!$access){$access=4;}

if($access==4){
$team=-1;
}
else
{
$team = $_POST['team'];
}

$query = "SELECT login FROM `users` WHERE login='$login'";
$result = mysql_query($query);
$numrows = mysql_numrows($result);

if($numrows){
echo "That login is already taken.  User not added.";
}
else
{
$query = "INSERT INTO `users` VALUES ('','$login','$pw','$team','$access')";
$result = mysql_query($query);
}

mysql_close();
}
?>