<div id="wrapper" class="container-fluid">
	<div class="row-fluid">
		<form name='addcard' id='addcard' method='POST' action=''>
		<div class="alert error alert-error" id="form-validation-error">
		  <button type="button" class="close" data-dismiss="alert">×</button>
		  <div class="error-message"></div>
		</div>
		<div class="row-fluid">

	        <div id="cardmin-wrapper" class="span1">
	          <div class="control-group">
	            <label for="cardmin" id="cardmin_label" class="control-label">Min.</label>
	            <div class="controls">
	                <?php
						echo "<select id='cardmin' class='required input-mini'>\n";
						for ($k=1;$k<121;$k++) {
						    echo "<option value='$k'>$k</option>\n";
						}
						echo "</select>";
					?>
	            </div>
	          </div>
	        </div>


	        <div id="cardtype-wrapper" class="span2">
	          <div class="control-group">
	            <label for="cardtype" id="cardtype_label" class="control-label">Type</label>
	            <div class="controls">
	                <select name='cardtype' id='cardtype' class='required input-medium'>
						<option value=''></option>
						<option value='21'>Yellow Card</option>
						<option value='22'>Red Card</option>
					</select>
	            </div>
	          </div>
	        </div>

	        <div id="cardplayer-wrapper" class="span2">
	          <div class="control-group">
	            <label for="cardplayer" id="cardplayer_label" class="control-label">Player</label>
	            <div class="controls">
	                <select name='cardplayer' id='cardplayer' class='required input-medium'>
						<?php
						echo "<option value=''>--".teamName($away_id)."--</option>";
						foreach ($awayps as $awayp) {
						    echo "<option value='$awayp'>".playerName($awayp)."</option>";
						}
						echo "<option value=''>--".teamName($home_id)."--</option>";
						foreach ($homeps as $homep) {
						    echo "<option value='$homep'>".playerName($homep)."</option>";
						}
						?>
					</select>
	            </div>
	          </div>
	        </div>



		<input type='hidden' name='cardrefresh' id='cardrefresh' value='<?php $host = $_SERVER['HTTP_HOST']; echo "http://$host/game_card_events.php?game_id=$game_id"; ?>'>
		<input type='hidden' name='card_game_id' id='card_game_id' value='<?php echo "$game_id"; ?>'>

	        <div id="submit-wrapper" class="span1">
	          <div class="control-group">
	            <label for="submit" id="submit_label" class="control-label">&nbsp;</label>
	            <div class="controls">
	               <input type='submit' name='submit' class='button btn btn-primary' id='add_card' value='Add Card'>
	            </div>
	          </div>
	        </div>
        <div>
		</form>
	</div>
</div>
