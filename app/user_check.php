<?php
//if we haven't given the user a session name, send them to login.
if(!$_SESSION['user'])
{
header('Location: http://' . $_SERVER['HTTP_HOST'] . '/login.php');
}
?>
