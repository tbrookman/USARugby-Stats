<?php
include_once './include_mini.php';

$comp_id = $_GET['id'];
?>

<h4>Add a Game</h4>

<form name='addgame' id='addgame' method='POST' action='' class="form-inline">
<div class="alert error alert-error" id="add_game_error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Warning!</strong> Best check yo self, you're not looking too good.
</div>
<i class="icon-plus-sign"></i><input id='field' name='field' type='text' size='1' class="input-medium" placeholder="Field #">

<input id='gnum' name='gnum' type='text' size='1' class="input-medium required" placeholder="Competition Game #">
<!--<label class="error" for="gnum" id="gnum_error">This field is required.</label>-->

<?php
// Determine date stard and end.
$comp = $db->getCompetition($comp_id);
$game_earliest = $comp['start_date'];
$game_latest = $comp['end_date'];
echo "<input id='kdate' name='kdate' type='text' size='10' class='date_select input-small required' data-date-startdate='$game_earliest' data-date-enddate='$game_latest' placeholder='Date'> @ "
?>
<input name="ko_time" id="ko_time" type="text" size="2" class="input-small time-entry required" placeholder='Time'>


<select name='home' id='home' class="required" placeholder="Home Team">
<option value=''>Home Team</option>

<?php
$query = "SELECT * FROM `ct_pairs` WHERE comp_id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $query1 = "SELECT * FROM `teams` WHERE id = {$row['team_id']}";
    $result1 = mysql_query($query1);
    while ($row1=mysql_fetch_assoc($result1)) {
        echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
    }
}
?>

</select>

<select name='away' id='away' class="required" placeholder="Away Team">
<option value=''>Away Team</option>

<?php
$query = "SELECT * FROM `ct_pairs` WHERE comp_id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $query1 = "SELECT * FROM `teams` WHERE id = {$row['team_id']}";
    $result1 = mysql_query($query1);
    while ($row1=mysql_fetch_assoc($result1)) {
        echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
    }
}
?>

</select>
<br/>

<input type='hidden' name='grefresh' id='grefresh' value='<?php echo "comp_games.php?id=$comp_id"; ?>'>
<input type='hidden' name='comp_id' id='comp_id' value='<?php echo $comp_id; ?>'>
<input type='submit' name='submit' class='button' id='add_game' value='Add Game'>

</form>

<!--this is to hide the errors after a jquery refresh upon adding a new team to the comp-->
<script type='text/javascript'>$('.error').hide();</script>

<?php
include_once './footer.php';
