<?php
include_once ('./include_mini.php');

//verify we can edit.  1 is usarugby only.  Redirect if not?
if(editCheck(1)){

$comp_id = $_GET['id'];
?>

<h4>Add a Team</h4>

<form name='addteam' id='addteam' method='POST' action=''>

<label for="team" id="team_label">Team</label>
<select name='team' id='team'>
<option value=''></option>
<?php

//give a list of every team to choose from
$query = "SELECT team_id FROM ct_pairs WHERE comp_id=$comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$andsort = $andsort."AND id != '{$row['team_id']}' ";
}

$query = "SELECT * FROM `teams` WHERE 1 $andsort";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
?>

</select>
<label class="error" for="team" id="team_error">This field is required.</label>
<br/>

<input type='hidden' name='trefresh' id='trefresh' value='<?php echo "comp_teams.php?id=$comp_id"; ?>'>
<input type='hidden' name='lrefresh' id='lrefresh' value='<?php echo "add_team.php?id=$comp_id"; ?>'>
<input type='hidden' name='comp_id' id='comp_id' value='<?php echo $comp_id; ?>'>
<input type='submit' name='submit' class='button' id='add_team' value='Add Team'>
</form>

<?php
}
?>