<div id="wrapper" class="container-fluid">
  <div class="row-fluid">
    <form name='addstatus' id='addstatus' method='POST' action=''>
      <div class="alert error alert-error" id="form-validation-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <div class="error-message"></div>
      </div>
      <div class="row-fluid">

          <div id="cardplayer-wrapper" class="span2">
            <div class="control-group">
              <label for="gamestatus" id="gamestatus_label" class="control-label">Game Status</label>
              <div class="controls">
                <select name='gamestatus' id='gamestatus' data-placeholder="Game Status" class='required input-medium chzn-select'>
                    <option value=""></option>
                    <?php
                    $status = game_status($game_id);
                    foreach (game_status_list() as $key => $value) {
                        if ($value == $status) {
                            echo "<option value='$key' selected='selected'>".$value."</option>";
                        } else {
                            echo "<option value='$key'>".$value."</option>";
                        }
                    }
                    ?>
                </select>
              </div>
            </div>
          </div>

          <div id="submit-wrapper" class="span1">
            <div class="control-group">
              <label for="submit" id="submit_label" class="control-label">&nbsp;</label>
              <div class="controls">
                 <input type='hidden' name='statusrefresh' id='statusrefresh' value='<?php echo $request->getScheme() . '://' . $request->getHost() . "/add_status.php"; ?>'>
                 <input type='hidden' name='status_game_id' id='status_game_id' value='<?php echo "$game_id"; ?>'>
                 <input type='submit' name='submit' class='button btn btn-primary' id='add_status' value='Add Status'>
              </div>
            </div>
          </div>
        <div> <!--row-fluid-->
    </form>
  </div>
</div>
