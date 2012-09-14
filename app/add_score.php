<form name='addscore' id='addscore' method='POST' action='' class="">
<div class="alert error alert-error" id="form-validation-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <div class="error-message"></div>
</div>
<!--<label for="minute" id="minute_label" class="span1">Min.</label>
<label for="type" id="type_label" class="span4">Type</label>
<label for="player" id="player_label" class="span4">Player</label>-->
<br/>
<div class="controls controls-row labels">
<label for="minute" id="minute_label" class="span1 control-label">Min.</label>
<label for="type" id="type_label" class="span4 control-label">Type</label>
<label for="player" id="player_label" class="span4 control-label">Player</label>
</div>

<div class="controls controls-row control-fields">
<?php
echo "<select id='minute' class='required span1'>\n";
for ($k=1;$k<121;$k++) {
    echo "<option value='$k'>$k</option>\n";
}
echo "</select>";
?>

<select name='type' id='type' class='required span4'>
<option value=''></option>
<option value='1'>Try</option>
<option value='2'>Conversion</option>
<option value='3'>Penalty Kick</option>
<option value='4'>Drop Goal</option>
<option value='5'>Penalty Try</option>
</select>


<select name='player' id='player' class ="span4">
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
</div>
<input type='hidden' name='refresh' id='refresh' value='<?php $host = $_SERVER['HTTP_HOST']; echo "http://$host/game_score_events.php?id=$game_id"; ?>'>
<input type='hidden' name='game_id' id='game_id' value='<?php echo "$game_id"; ?>'>
<input type='submit' name='submit' class='button' id='add_score' value='Add Score'>
</form>
