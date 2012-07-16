<form name='addsub' id='addsub' method='POST' action=''>

<label for="submin" id="submin_label">Min.</label>
<?php
echo "<select id='submin'>\n";
for($k=1;$k<121;$k++){
echo "<option value='$k'>$k</option>\n";
}
echo "</select>";
?>
<label class="error" for="submin" id="submin_error">This field is required.</label>

<label for="subtype" id="subtype_label">Type</label>
<select name='subtype' id='subtype'>
<option value=''></option>
<option value='11'>Tactical</option>
<option value='13'>Injury</option>
<option value='15'>Blood</option>
<option value='17'>Front Row Card</option>
</select>
<label class="error" for="subtype" id="subtype_error">This field is required.</label>

<label for="player_on" id="player_on_label">Player On</label>
<select name='player_on' id='player_on'>
<?php
echo "<option value=''>--".teamName($away_id)."--</option>";
foreach ($awayps as $awayp){
echo "<option value='$awayp'>".playerName($awayp)."</option>";
}
echo "<option value=''>--".teamName($home_id)."--</option>";
foreach ($homeps as $homep){
echo "<option value='$homep'>".playerName($homep)."</option>";
}
?>
</select>
<label class="error" for="player_on" id="player_on_error">This field is required.</label>

<label for="player_off" id="player_off_label">Player Off</label>
<select name='player_off' id='player_off'>
<?php
echo "<option value=''>--".teamName($away_id)."--</option>";
foreach ($awayps as $awayp){
echo "<option value='$awayp'>".playerName($awayp)."</option>";
}
echo "<option value=''>--".teamName($home_id)."--</option>";
foreach ($homeps as $homep){
echo "<option value='$homep'>".playerName($homep)."</option>";
}
?>
</select>
<label class="error" for="player_off" id="player_off_error">This field is required.</label>

<input type='hidden' name='subrefresh' id='subrefresh' value='<?php echo "http://$_SERVER['HTTP_HOST']/game_sub_events.php?game_id=$game_id"; ?>'>
<input type='hidden' name='sub_game_id' id='sub_game_id' value=<?php echo "$game_id"; ?>>
<input type='submit' name='submit' class='button' id='add_sub' value='Add Sub'>
</form>
