<?php
include_once './include_micro.php';
$iframe = $request->get('iframe');
$team_uuid = $request->get('team_uuid');
include_once './include.php';

if (!empty($team_uuid)) {
    $team_id = $db->getSerialIDByUUID('teams', $team_uuid);
    $team = $db->getTeam($team_id);
    $game_rows = array();
}

if (empty($team_id)) {
    $team_id = $request->get('team_id');
}

?>
<div id="wrapper" class="container-fluid team-games">
  <?php
    $team_games = $db->getTeamGames($team_id);
    // If we're not looking at a team - we may be on a competition (top level)
    //  related group - try to look it up.
    if (empty($team_games)) {
        // team_uuid in this case would be comp_uuid
        $team_games = $db->getCompetitionGames($team_uuid);
    }
    if (empty($team_games)) {
        echo '<!-- No Games -->';
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
            if (!empty($iframe)) {
                foreach ($team_games as $team_game) {
                    $game = array();
                    $resource = $db->getResource($team_game['field_num']);
                    $loc_url = getResourceMapUrl($resource);
                    $game['comp_game_id'] = $team_game['comp_game_id'];
                    $game['kickoff'] = date('M d', strtotime($team_game['kickoff']));
                    $game['kickoff_time'] = date('g:ia', strtotime($team_game['kickoff']));
                    $game['score'] = "<b>" . "{$team_game['home_score']} - {$team_game['away_score']}" . "</b>";
                    $game['away_id'] = teamNameNL($team_game['away_id']);
                    $game['home_id'] = teamNameNL($team_game['home_id']);
                    $game['field'] = "<a href=" . "$loc_url" . ">" . "{$resource['title']}" . "</a>";
                    $game_rows[] = $game;
               }
            }
            if (empty($twig)) {
                $loader = new Twig_Loader_Filesystem(__DIR__.'/views');
                $twig = new Twig_Environment($loader, array());
            }
          echo $twig->render('comp-games.twig', array('gamerows' => $game_rows));
      }

    }
?>
</div>
<?php

include './footer.php';
