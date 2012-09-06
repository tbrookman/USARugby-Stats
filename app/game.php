<?php
include_once './include_micro.php';

$iframe = $request->get('iframe');
$include_file = empty($iframe) ? './include.php' : './include_mini.php';
include_once $include_file;

// If a game_id is given, let that take over.
if (!$game_id = $request->get('id')) {
  $game_uuid = $request->get('uuid');
  $game_id = $db->getSerialIDByUUID('games', $game_uuid);
}

if ((!$ops = $request->get('ops')) || empty($iframe)) {
  $ops = array(
    'game_info',
    'game_score',
    'game_rosters',
    'game_score_events',
    'game_sub_events',
    'game_card_events',
  );
}
  if (!empty($game_id)) {
    $game = $db->getGame($game_id);
    // Game Information.
    if (in_array('game_info', $ops)) {
      if (!$iframe) {
        echo "<h1>Game Info</h1>";
      }
      echo "<div id='info'>\r";
      //Get the teams and kickoff and competition
      include_once './game_info.php';
      echo "</div>\r";
    }

    // Overall Game Score.
    if (in_array('game_score', $ops)) {
      if (!$iframe) {
        echo "<h2>Score</h2>";
      }
      echo "<div id='score'>\r";
      //Get the rosters for this game
      include_once './game_score.php';
      echo "</div>\r";
    }

    // Rosters
    if (in_array('game_rosters', $ops)) {
      if (!$iframe) {
        echo "<h2>Rosters</h2> ";
      }
      $home_id = $game['home_id'];
      $away_id = $game['away_id'];
      //Get the rosters for this game
      include_once './game_rosters.php';
    }

    // Player Scores - Individual
    if (in_array('game_score_events', $ops)) {
      if (!$iframe) {
        echo "<h2>Scores</h2>\r";
      }
      echo "<div id='scores'>";
      //Get the scoring events for this game
      include_once './game_score_events.php';
      echo "</div>";
      //if we can edit/add, show the necessary form info
      if (editCheck() && !$iframe) {
        echo "<div id='score_submit'>";
        include './add_score.php';
        echo "</div>";
      }
    }

    // Subs.
    if (in_array('game_sub_events', $ops)) {
      if (!$iframe) {
        echo "<h2>Subs</h2>";
      }
       echo "<div id='subs'>";
      //Get the subs for this game
      include_once './game_sub_events.php';
      echo "</div>";
      //if we can edit/add, show the necessary form info
      if (editCheck() && !$iframe) {
        echo "<div id='sub_submit'>";
        include './add_sub.php';
        echo "</div>";
      }
    }

    // Cards.
    if (in_array('game_card_events', $ops)) {
      if (!$iframe) {
        echo "<h2>Cards</h2>";
      }
      echo "<div id='cards'>";
      //Get the yellow/red cards for this game
      include_once './game_card_events.php';
      echo "</div>";

      //if we can edit/add, show the necessary form info
      if (editCheck() && !$iframe) {
          echo "<div id='card_submit'>";
          include './add_card.php';
          echo "</div>";
      }
    }
    if (!$iframe && editCheck()) {
      echo "<div id='signoff'>";
      //Get the ref, coaches, and #4's signoffs
      include_once './signatures.php';
      echo "</div>";
    }


  }
/*
  else {
    $game = $db->getGame($game_id);
    $home_id = $game['home_id'];
    $away_id = $game['away_id'];
    echo "<h2>Rosters</h2> ";
    //Get the rosters for this game
    include_once './game_rosters.php';
  }
}*/


include_once './footer.php';
mysql_close();
