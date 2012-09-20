<?php
include_once './include_micro.php';
$iframe = $request->get('iframe');
$ops = $request->get('ops');
$team_uuid = $request->get('team_uuid');
include_once './include.php';

if (!empty($team_uuid)) {
  $team_id = $db->getSerialIDByUUID('teams', $team_uuid);
}

if (empty($team_id)) {
    $team_id = $request->get('team_id');
}

?>
<div id="wrapper" class="container-fluid team-games">
  <?php
    $team_games = $db->getTeamGames($team_id);
    if (empty($team_games)) {
      ?>
      <div class="alert alert-no-games">
        <h4>No Games Yet!</h4>
      </div>
      <?php
    }
    else {
      // Regular display.
      if (empty($iframe)) {
        foreach ($team_games as $team_game) {
            $kickoff = date('M d - g:ia', strtotime($team_game['kickoff']));
            echo "<a href='game.php?id={$team_game['id']}'>";
            echo teamNameNL($team_game['away_id'])." @ ".teamNameNL($team_game['home_id'])." - $kickoff</a><br/>";
        }
      }
      // Iframe.
      else {
        $opstring = '';
        if (!empty($ops)) {
          foreach ($ops as $key => $op) {
            $opstring .= '&ops[' . $key . ']=' . $op;
          }
        }
        ?>
        <div class="row-fluid span-12 game-switcher-row">
          <select name="team_games" class="chzn-game-switcher input-large">
             <?php
                foreach($team_games as $team_game) {
                  $kickoff = date('Y-m-d', strtotime($team_game['kickoff']));
                  print "<option value='{$team_game['id']}''>" . teamNameNL($team_game['away_id']) . " @ " . teamNameNL($team_game['home_id']) .  " - $kickoff </option>";
                }
              ?>
          </select>
        </div>
        <div class="row-fluid game-loadspace" data-requested-ops=<?php print "'" . $opstring . "'"; ?>></div>
        <?php
      }
    }
?>
</div>
<?php



