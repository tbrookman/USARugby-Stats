<?php

use Source\APSource;
use Source\DataSource;
/**
 * used to get a players team in a game for adding a scoring event
 * we look for the player id in the players list
 * must use !== in case its at the 0 spot
 *
 * @param unknown $player_id
 * @param unknown $game_id
 * @return unknown
 */

function getTeam($player_id, $game_id)
{
    $query = "SELECT * FROM `game_rosters` WHERE game_id = '$game_id'";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        if (strpos($row['player_ids'], "-$player_id-")!==false)
            return $row['team_id'];

    }
}

/**
 * get event value to update score
 *
 * @param unknown $type
 * @return unknown
 */
function getValue($type)
{
    $query = "SELECT value FROM `event_types` WHERE event_id = '$type'";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        return $row['value'];

    }
}

/**
 * when we add a score we need to update the game score
 *
 * @param unknown $game_id
 */
function updateScore($game_id)
{
    //first get the id's of the home and away teams
    $query = "SELECT * FROM `games` WHERE id = '$game_id'";
    $result = mysql_query($query);
    $homep = 0;
    $awayp = 0;
    while ($row=mysql_fetch_assoc($result)) {
        $home_id = $row['home_id'];
        $away_id = $row['away_id'];
        $game_uuid = $row['uuid'];
    }

    //get total home team points using getValue function
    $query = "SELECT * FROM `game_events` WHERE game_id = '$game_id' AND type<10 AND team_id='$home_id'";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        $homep = $homep+getValue($row['type']);
    }

    //get total away team points using getValue function
    $query = "SELECT * FROM `game_events` WHERE game_id = '$game_id' AND type<10 AND team_id='$away_id'";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        $awayp = $awayp+getValue($row['type']);
    }

    //update score
    $query = "UPDATE `games` SET home_score='$homep', away_score='$awayp' WHERE id = '$game_id'";
    $result = mysql_query($query);

    $client = APSource::factory();
    $db = new DataSource;
    $home_team = $db->getTeam($home_id);
    $away_team = $db->getTeam($away_id);
    $competitors = array(
        0 => array(
            'uuid' => $home_team['uuid'],
            'label' => 'home',
            'score' => $homep
        ),
        1 => array(
            'uuid' => $away_team['uuid'],
            'label' => 'away',
            'score' => $awayp
        )
    );
    $command = $client->getCommand('UpdateEvent', array('competitors' => $competitors));
    $command->setUuid($game_uuid);
    $command->execute();
}


/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function pExists($id)
{
    $query = "SELECT id FROM `players` WHERE uuid = '$id'";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        if ($row['id']) {return true;} else {return false;}
    }
}


/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function tExists($id)
{
    $query = "SELECT id FROM `teams` WHERE uuid = '$id'";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
        if ($row['id']) {return true;} else {return false;}
    }
}

function getPositionList()
{
    $counts = array(
        'Lock' => 2,
        'Wing' => 2,
        'Reserve' => 8,
    );

    $positions = array(
        'LHP' => 'Loose-Head Prop',
        'H' => 'Hooker',
        'THP' => 'Tight-Head Prop',
        'OSF' => 'Open Side Flanker',
        'BSF' => 'Blind Side Flanker',
        'N8' => 'Number 8',
        'SH' => 'Scrum Half',
        'FH' => 'Fly Half',
        'IC' => 'Inside Center',
        'OC' => 'Outside Center',
        'FB' => 'Fullback',
    );
    foreach ($counts as $pos_name => $count) {
        $pos_short = strtoupper(substr($pos_name, 0, 1));
        for ($i = 1; $i <= $count; $i++) {
            $positions[$pos_short . $i] = $pos_name . ' ' . $i;
        }
    }

    return $positions;
}

function getPositionNameByCode($code)
{
    $positions = getPositionList();
    return $positions[$code];
}
