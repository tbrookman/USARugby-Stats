<?php
include_once './include_mini.php';

$game_id ?: $request->get('id');

echo "<table>";

$game_card_events = $db->getGameCardEvents($game_id);
if ($iframe) {
  echo get_header_string('game_events');
}
foreach ($game_card_events as $game_card_event) {
    echo "<tr><td>{$game_card_event['minute']}'</td>";
    echo "<td>".eType($game_card_event['type'])."</td>";
    echo "<td>".teamName($game_card_event['team_id'])."</td>";
    echo "<td>".playerName($game_card_event['player_id'])."</td>";

    if (editCheck() && !$iframe) {
        echo "<td><form style='margin: 0; padding: 0' name='dForm{$game_card_event['id']}' id='dForm{$game_card_event['id']}'>";
        echo "<input name='dCard{$game_card_event['id']}' class='dCard' id='dCard{$game_card_event['id']}' type='button' value='Delete Card' />";
        echo "<input type='hidden' class='dId' name='event_id' id='event_id' value='{$game_card_event['id']}' />";
        echo "<input type='hidden' name='refresh' id='refresh' value='game_card_events.php?game_id=$game_id' />";

        echo "</form></td>\r";
    }

}

echo "</table>";
