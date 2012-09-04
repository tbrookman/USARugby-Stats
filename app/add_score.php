<form name='addscore' id='addscore' method='POST' action=''>

<label for="minute" id="minute_label">Min.</label>
<?php
echo "<select id='minute'>\n";
for ($k=1;$k<121;$k++) {
    echo "<option value='$k'>$k</option>\n";
}
echo "</select>";
?>
<label class="error" for="minute" id="minute_error">This field is required.</label>

<label for="type" id="type_label">Type</label>
<select name='type' id='type'>
<option value=''></option>
<option value='1'>Try</option>
<option value='2'>Conversion</option>
<option value='3'>Penalty Kick</option>
<option value='4'>Drop Goal</option>
<option value='5'>Penalty Try</option>
</select>
<label class="error" for="type" id="type_error">This field is required.</label>

<label for="player" id="player_label">Player</label>
<select name='player' id='player'>
<?php
echo "<option value='team$away_id'>--".teamName($away_id)."--</option>";
foreach ($awayps as $awayp) {
    echo "<option value='$awayp'>".playerName($awayp)."</option>";
}
echo "<option value='team$home_id'>--".teamName($home_id)."--</option>";
foreach ($homeps as $homep) {
    echo "<option value='$homep'>".playerName($homep)."</option>";
}
?>
</select>
<label class="error" for="player" id="player_error">This field is required.</label>

<input type='hidden' name='refresh' id='refresh' value='<?php $host = $_SERVER['HTTP_HOST']; echo "http://$host/game_score_events.php?id=$game_id"; ?>'>
<input type='hidden' name='game_id' id='game_id' value='<?php echo "$game_id"; ?>'>
<input type='submit' name='submit' class='button' id='add_score' value='Add Score'>
</form>
