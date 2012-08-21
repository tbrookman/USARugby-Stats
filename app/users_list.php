<?php
include_once ('./include_mini.php');

//verify we can edit.  1 is usarugby only.  Redirect if not?
if(editCheck(1)){

echo "<table>\n";
echo "<tr><td>Login</td><td>Team</td><td>Access</td><td>&nbsp;</td><td>&nbsp;</td></tr>\n";

$query = "SELECT * FROM `users` WHERE 1";

$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
echo "<tr>";
echo "<td>{$row['login']}</td>\n";

//for all team users, output that instead of nothing
if(!isset($row['team']) || !$row['team']){$tout='All Teams';}
else
{
$tout = teamName($row['team']);
}

echo "<td>$tout</td>\n";
echo "<td>".accessName($row['access'])."</td>\n";
echo "<td><input name='eUser{$row['id']}' class='eUser' id='eUser{$row['id']}' type='button' value='Edit User' /></td>\n";
echo "<input name='eId{$row['id']}' class='eId' id='eId{$row['id']}' type='hidden' value='{$row['id']}' />\n";
echo "<td><input name='dUser{$row['id']}' class='dUser' id='dUser{$row['id']}' type='button' value='Delete User' /></td>\n";
echo "<input name='dId{$row['id']}' class='dId' id='dId{$row['id']}' type='hidden' value='{$row['id']}' />\n";
echo "</tr>\n";

}

echo "</table>\n";

}
?>