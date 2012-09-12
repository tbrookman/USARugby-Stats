<?php
include_once './include_mini.php';
if (editCheck(1)) {

    echo "<label for='login' id='login_label'>User Email</label>";
    echo "<input id='login' name='login' type='text' value='{$row['login']}'>";
    //echo "<input id='login' name='login' type='text' value=''>";
    echo "<label class='error' for='login' id='login_error'>This field is required.</label><br/>";

    /*echo "<label for='uuid' id='uuid_label'>User UUID</label>";
    echo "<input id='uuid' name='uuid' type='text' value=''>";
    echo "<label class='error' for='uuid' id='uuid_error'>This uuid is invalid.</label><br/>";*/

    echo "<label for='team' id='team_label'>Team</label>";
    echo "<select name='team' id='team'>";
    echo "<option value=''>No team (for Admin and Ref only)</option>";
    $query2 = "SELECT id, name FROM `teams` WHERE hidden=0";
    $result2 = mysql_query($query2);
    while ($row2=mysql_fetch_assoc($result2)) {
        echo "<option value='{$row2['id']}'>{$row2['name']}</option>";
    }
    echo "</select>";
    echo "<br/>";

    echo "<label for='access' id='access_label'>Access</label>";
    echo "<select name='access' id='access'>";
    echo "<option value=''></option>";
    echo "<option value='1'>Administrator</option>";
    echo "<option value='2'>Referee</option>";
    echo "<option value='3'>Specific Team</option>";
    echo "<option value='4'>View Only</option>";
    echo "</select>";
    echo "<label class='error' for='access' id='access_error'>This field is required.</label>";
    echo "<br/>";

    echo "<input type='button' class='add' id='addUser' name='addUser' value='Add User' />";
}
