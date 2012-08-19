<?php
//Start session
include_once ('./session.php');

$user=isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

echo $_SESSION['warning'];
$_SESSION['warning']='';

if(!$user){
echo "<form id='getaccess' name='getaccess' method='POST' action='check.php'>\n";
echo "Login<input type='text' class='normal' name='login' />\n";
echo "Password<input type='password' name='pw' />\n";
echo "<input type='submit' name='submit' class='normal' value='Login'>\n";
echo "</form>\n";
}else{
header('Location: http://' . $_SERVER['HTTP_HOST']);
}
?>
