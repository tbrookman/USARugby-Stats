<div id="wrapper" class="container-fluid">
	<div class="row-fluid">
		<form name='addsub' id='addsub' method='POST' action=''>
		<div class="alert error alert-error" id="form-validation-error">
		  <button type="button" class="close" data-dismiss="alert">×</button>
		  <div class="error-message"></div>
		</div>

		<div class="row-fluid">

	        <div id="submin-wrapper" class="span1">
	          <div class="control-group">
	            <label for="submin" id="submin_label" class="control-label">Min.</label>
	            <div class="controls">
	                <?php
						echo "<select id='submin' class='input-mini required'>\n";
						for ($k=1;$k<121;$k++) {
						    echo "<option value='$k'>$k</option>\n";
						}
						echo "</select>";
					?>
	            </div>
	          </div>
	        </div>

	        <div id="subtype-wrapper" class="span2">
	          <div class="control-group">
	            <label for="subtype" id="subtype_label" class="control-label">Type</label>
	            <div class="controls">
	                <select name='subtype' id='subtype' class='input-medium required'>
						<option value=''></option>
						<option value='11'>Tactical</option>
						<option value='13'>Injury</option>
						<option value='15'>Blood</option>
						<option value='17'>Front Row Card</option>
					</select>
	            </div>
	          </div>
	        </div>

	        <div id="player_on-wrapper" class="span2">
	          <div class="control-group">
	           <label for="player_on" id="player_on_label" class="control-label">Player On</label>
	            <div class="controls">
	                <select name='player_on' id='player_on' class='input-medium required'>
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

	        <div id="player_off-wrapper" class="span2">
	          <div class="control-group">
	            <label for="player_off" id="player_off_label" class="control-label">Player Off</label>
	            <div class="controls">
	                <select name='player_off' id='player_off' class='input-medium required'>
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



		<input type='hidden' name='subrefresh' id='subrefresh' value='<?php $host = $_SERVER['HTTP_HOST']; echo "http://$host/game_sub_events.php?game_id=$game_id"; ?>'>
		<input type='hidden' name='sub_game_id' id='sub_game_id' value=<?php echo "$game_id"; ?>>

			 <div id="submit-wrapper" class="span1">
	          <div class="control-group">
	            <label for="submit" id="submit_label" class="control-label">&nbsp;</label>
	            <div class="controls">
	               <input type='submit' name='submit' class='button btn btn-primary' id='add_sub' value='Add Sub'>
	            </div>
	          </div>
	        </div>

	    </div>



		</form>
	</div>
</div>
