<?php
include_once './include_mini.php';

//verify we can edit.  1 is usarugby only.  Redirect if not?
if (editCheck(1)) {

    echo "<table class='table'>\n";
    echo "<thead><tr><th>Login</th><th>Team</th><th>Access</th><th>&nbsp;</th><th>&nbsp;</th></tr><thead>\n";

    $query = "SELECT * FROM `users` WHERE 1";
    echo "<tbody>";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        $login = empty($row['login']) ? '-- Login Pending --' : $row['login'];
        $class = empty($row['login']) ? 'class="info"' : '';
        echo '<tr ' . $class . '>';
        echo "<td>$login</td>\n";

        //for all team users, output that instead of nothing
        if (!isset($row['team']) || !$row['team']) {$tout='All Teams';} else {
            $tout = teamName($row['team']);
        }

        echo "<td>$tout</td>\n";
        echo "<td>".accessName($row['access'])."</td>\n";
        echo "<td><input name='eUser{$row['id']}' class='eUser btn btn-warning' id='eUser{$row['id']}' type='button' value='Edit User' /></td>\n";
        echo "<input name='eId{$row['id']}' class='eId' id='eId{$row['id']}' type='hidden' value='{$row['id']}' />\n";
        echo "<td><input name='dUser{$row['id']}' class='dUser btn btn-danger' id='dUser{$row['id']}' type='button' value='Delete User' /></td>\n";
        echo "<input name='dId{$row['id']}' class='dId' id='dId{$row['id']}' type='hidden' value='{$row['id']}' />\n";
        echo "</tr>\n";

    }

    echo "</tbody></table>\n";

}
