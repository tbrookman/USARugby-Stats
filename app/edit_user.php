<?php
include_once './include_mini.php';

if (!isset($user_id) || !$user_id) {$user_id=$_GET['id'];}

//get info for the user with id in url
$query = "SELECT * FROM `users` WHERE id = $user_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    $team = $row['team'];
    $access = $row['access'];

    echo "<label for='login' id='login_label'>User Name</label>";
    echo "<input id='login' name='login' type='text' value='{$row['login']}'>";
    echo "<label class='error' for='login' id='login_error'>This field is required.</label><br/>";

    echo "Password<input id='pw' name='pw' type='text' value=''>";
    echo "<br/>";

    echo "Team<select name='team' id='team'>";
    echo "<option value=''></option>";
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
    echo "<option value='2'>Ref Access</option>";
    echo "<option value='3'>Specific Team Access</option>";
    echo "<option value='4'>Press Access</option>";
    echo "</select>";
    echo "<label class='error' for='access' id='access_error'>This field is required.</label>";
    echo "<br/>";

}

if (editCheck(1)) {
    echo "<input type='button' class='edit' id='eUserSubmit' name='eUserSubmit' value='Submit Edits' />";
    echo "<input type='hidden' id='user_id' value='$user_id' />";
}

echo "<script type='text/javascript'>";
//to hide errors on load
echo "$('.error').hide();";
//to select our team and access values in dropdowns
echo "$('#team option[value=\"$team\"]').attr('selected', 'selected');";
echo "$('#access option[value=\"$access\"]').attr('selected', 'selected');";
echo "</script>";
