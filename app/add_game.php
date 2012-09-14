<?php
include_once './include_mini.php';

$comp_id = $_GET['id'];
?>

<h4>Add a Game</h4>

<form name='addgame' id='addgame' method='POST' action=''>

<label for="field" id="field_label">Field Number</label>
<input id='field' name='field' type='text' size='1'>
<br/>

<label for="gnum" id="gnum_label">Competition Game Number</label>
<input id='gnum' name='gnum' type='text' size='1'>
<label class="error" for="gnum" id="gnum_error">This field is required.</label>
<br/>
<label for="kdate" id="kdate_label">Game Date</label>
<?php
// Determine date stard and end.
$comp = $db->getCompetition($comp_id);
$game_earliest = $comp['start_date'];
$game_latest = $comp['end_date'];
echo "<input id='kdate' name='kdate' type='text' size='10' class='date_select input-small' data-date-startdate='$game_earliest' data-date-enddate='$game_latest'>"
?>
<input name="ko_time" id="ko_time" type="text" size="2" class="input-small time-entry">
<label class="error" for="ko_time" id="ko_time_error">This field is required.</label>
<br/>



<label for="home" id="home_label">Home Team</label>
<select name='home' id='home'>
<option value=''></option>

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
<label class="error" for="home" id="home_error">This field is required.</label>
<br/>

<label for="away" id="away_label">Away Team</label>
<select name='away' id='away'>
<option value=''></option>

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
<label class="error" for="away" id="away_error">This field is required.</label>
<br/>

<input type='hidden' name='grefresh' id='grefresh' value='<?php echo "comp_games.php?id=$comp_id"; ?>'>
<input type='hidden' name='comp_id' id='comp_id' value='<?php echo $comp_id; ?>'>
<input type='submit' name='submit' class='button' id='add_game' value='Add Game'>
</form>

<!--this is to hide the errors after a jquery refresh upon adding a new team to the comp-->
<script type='text/javascript'>$('.error').hide();</script>

<?php
include_once './footer.php';
