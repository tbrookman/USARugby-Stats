<div id="wrapper" class="container-fluid">
  <div class="row-fluid">
    <form name='addscore' id='addscore' method='POST' action='' class="form-inline span11">
      <div class="alert error alert-error" id="form-validation-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <div class="error-message"></div>
      </div>
      <div class="row-fluid">
        <div id="minute-wrapper" class="span1">
          <div class="control-group">
            <label for="minute" id="minute_label" class="control-label">Min.</label>
            <div class="controls">
            <?php
              echo "<select id='minute' class='input-mini required'>\n";
              for ($k=1;$k<121;$k++) {
                echo "<option value='$k'>$k</option>\n";
              }
              echo "</select>";
            ?>
            </div>
          </div>
        </div>

        <div id="type-wrapper" class="span2">
          <div class="control-group">
            <label for="type" id="type_label" class="control-label">Type</label>
            <div class="controls">
               <select name='type' id='type' class='input-medium required'>
                  <option value=''></option>
                  <option value='1'>Try</option>
                  <option value='2'>Conversion</option>
                  <option value='3'>Penalty Kick</option>
                  <option value='4'>Drop Goal</option>
                  <option value='5'>Penalty Try</option>
              </select>
            </div>
          </div>
        </div>

        <div id="player-wrapper" class="span3">
          <div class="control-group">
            <label for="player" id="player_label" class="control-label">Player</label>
            <div class="controls">
              <select name='player' id='player' class ="input-medium">
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
          </div>
        </div>

        <div id="submit-wrapper" class="span2">
          <div class="control-group">
            <label for="submit" id="submit_label" class="control-label">&nbsp;</label>
            <div class="controls">
              <input type='hidden' name='refresh' id='refresh' value='<?php echo $request->getScheme() . '://' . $request->getHost() . "/game_score_events.php?id=$game_id"; ?>'>
              <input type='hidden' name='game_id' id='game_id' value='<?php echo "$game_id"; ?>'>
              <input type='submit' name='submit' class='button btn btn-primary' id='add_score' value='Add Score'>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
