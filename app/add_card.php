<form name='addcard' id='addcard' method='POST' action=''>

<label for="cardmin" id="cardmin_label">Min.</label>
<?php
echo "<select id='cardmin'>\n";
for($k=1;$k<121;$k++){
echo "<option value='$k'>$k</option>\n";
}
echo "</select>";
?>
<label class="error" for="cardmin" id="cardmin_error">This field is required.</label>

<label for="cardtype" id="cardtype_label">Type</label>
<select name='cardtype' id='cardtype'>
<option value=''></option>
<option value='21'>Yellow Card</option>
<option value='22'>Red Card</option>
</select>
<label class="error" for="cardtype" id="cardtype_error">This field is required.</label>

<label for="cardplayer" id="cardplayer_label">Player</label>
<select name='cardplayer' id='cardplayer'>
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
<label class="error" for="cardplayer" id="cardplayer_error">This field is required.</label>

<input type='hidden' name='cardrefresh' id='cardrefresh' value='<?php echo "http://$_SERVER['HTTP_HOST']/game_card_events.php?game_id=$game_id"; ?>'>
<input type='hidden' name='card_game_id' id='card_game_id' value='<?php echo "$game_id"; ?>'>
<input type='submit' name='submit' class='button' id='add_card' value='Add Card'>
</form>
