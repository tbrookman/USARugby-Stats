<?php

use Source\DataSource;

function getPlayerData($player_id, $comp_id = NULL, $iframe = FALSE) {
    include_once './include_micro.php';
    include_once './include.php';
    if (empty($db)) {
      $db = new DataSource();
    }
    $player_data = $db->getPlayer($player_id);
    $output = "<div id='wrapper' class='container-fluid player player-$player_id'><div class='row-fluid span-12 player_info'>";
    $picture_url = getFullImageUrl($player_data['picture_url']);
    $full_name = $player_data['firstname'] . ' ' .$player_data['lastname'];
    $output .= "<div class='span1 pull-left left-col'>";
    $output .= "<img src='$picture_url' class='img-polaroid player-picture player-picture-medium' alt='$full_name' onerror='imgError(this);'/>";
    $output .= $full_name;
    $output .= "</div>";
    if (empty($comp_id)) {
        // Get all game events for player.
        $game_events = $db->getPlayerGameEvents($player_id);
    }

    if (!empty($game_events)) {
        $output .= "<div class='span4 pull-left right-col player-game-events'>";
        $output .= "<table class='table table-bordered table-striped'><tr>";
        $game_data_keys = array(
            'Game',
            'PTS',
            'Tries',
            'Cons',
            'Pens',
            'DGs',
        );

        foreach ($game_data_keys as $col_name) {
            $output .= "<th>$col_name</th>";
        }
        $output .= "</tr>";

        // Sort by game id.
        $display_data = array();
        foreach ($game_events as $game_event) {
            $game_id = $game_event['game_id'];
            if (empty($display_data[$game_id])) {
                $game_data = array();
                foreach ($game_data_keys as $game_data_key) {
                    $game_data[strtolower($game_data_key)] = 0;
                }
            }
            else {
                $game_data = $display_data[$game_id];
            }

            $game_data['game'] = teamName($game_event['home_id'], empty($iframe)) . ' @ ' . teamName($game_event['away_id'], empty($iframe));
            $game_data['pts'] = empty($game_data['pts']) ? $game_event['value'] : $game_data['pts'] + $game_event['value'];

            switch ($game_event['type']) {
                // Try - Tries. @todo - do penalty tries count as tries?
                case 1:
                    $game_data['tries'] = empty($game_data['tries']) ? 1 : $game_data['tries'] + 1;
                    break;

                // Conversion - Cons.
                case 2:
                    $game_data['cons'] = empty($game_data['cons']) ? 1 : $game_data['cons'] + 1;
                    break;

                // Penalty Kick - Pens.
                case 3:
                    $game_data['pens'] = empty($game_data['pens']) ? 1 : $game_data['pens'] + 1;
                    break;

                // Drop Goals - DGs.
                case 4:
                    $game_data['dgs'] = empty($game_data['dgs']) ? 1 : $game_data['dgs'] + 1;
                    break;
            }
            $display_data[$game_id] = $game_data;
        }

        foreach ($display_data as $game_id => $final_game_data) {
            $output .= "<tr>";
            foreach ($final_game_data as $game_data_key => $game_data_value) {
                $output .= "<td>$game_data_value</td>";
            }
            $output .= "</tr>";
        }
        $output .= "</table></div>";
    }

    $output .= '</div></div>';

    return $output;
}
