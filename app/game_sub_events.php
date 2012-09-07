<?php
include_once './include_mini.php';

$game_id ?: $request->get('id');

echo "<table>";

$game_sub_events = $db->getGameSubEvents($game_id);
if ($iframe) {
  echo get_header_string('game_events');
}
foreach ($game_sub_events as $game_sub_event) {
    echo "<tr><td>{$game_sub_event['minute']}'</td>";
    echo "<td>".eType($game_sub_event['type'])."</td>";
    echo "<td>".teamName($game_sub_event['team_id'], !$iframe)."</td>";
    echo "<td>".playerName($game_sub_event['player_id'])."</td>";

    if (editCheck() && !$iframe) {
        echo "<td><form style='margin: 0; padding: 0' name='dForm{$game_sub_event['id']}' id='dForm{$game_sub_event['id']}'>";
        echo "<input name='dSub{$game_sub_event['id']}' class='dSub' id='dSub{$game_sub_event['id']}' type='button' value='Delete Sub' />";
        echo "<input type='hidden' class='dId' name='event_id' id='event_id' value='{$game_sub_event['id']}' />";
        echo "<input type='hidden' name='subDrefresh' id='subDrefresh' value='game_sub_events.php?game_id=$game_id' />";

        echo "</form></td>\r";
    }

}

echo "</table>";
