<?php
include_once './include_mini.php';

if (empty($game_id)) {
    if (!$game_id = $request->get('id')) {
        $game_id = $request->get('game_id');
    }
}

$game = $db->getGame($game_id);
$home_id = $game['home_id'];
$away_id = $game['away_id'];
echo teamName($away_id, empty($iframe))." - {$game['away_score']}<br/>";
echo teamName($home_id, empty($iframe))." - {$game['home_score']}<br/>";
