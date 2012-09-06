<?php
include_once './include_mini.php';

$game_id ?: $request->get('id');

$game = $db->getGame($game_id);
$home_id = $game['home_id'];
$away_id = $game['away_id'];
echo teamName($away_id, !$iframe)." - {$game['away_score']}<br/>";
echo teamName($home_id, !$iframe)." - {$game['home_score']}<br/>";
