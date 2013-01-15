<?php

namespace Source;

class DataSource {

    /**
     * Initialize database connection.
     */
    function __construct() {
        include __DIR__ . '/../../app/config.php';
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];
        $server = $config['server'] ? $config['server'] : 'localhost';

        mysql_connect($server, $username, $password);
        @mysql_select_db($database) or die("Unable to select database");
    }

    /**
     * Add a game.
     */
    public function addGame($game_info) {
        $columns = array('id', 'user_create', 'comp_id', 'comp_game_id', 'home_id', 'away_id', 'kickoff', 'field_num', 'home_score', 'away_score', 'ref_id', 'ref_sign', '4_sign', 'home_sign', 'away_sign', 'uuid');
        $values = '';
        $count = 1;
        $max_count = count($columns);
        foreach ($columns as $col) {
            $values .= is_null($game_info[$col]) ? 'NULL' : "'" . $game_info[$col] . "'";
            if ($count < $max_count) {
                $values .= ',';
            }
            $count++;
        }
        $query = "INSERT INTO `games` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function updateGame($game_id, $game_info) {
        $original_game = $this->getGame($game_id);
        $query = "UPDATE `games` SET ";
        $count = 1;
        $max_count = count($original_game);
        $updated_game = array_merge($original_game, $game_info);
        foreach ($updated_game as $col => $new_value) {
            $query .= $col . "='" . $new_value . "'";
            if ($count < $max_count) {
                $query .= ",";
            }
            $count++;
        }
        $query .= " WHERE id='{$original_game['id']}'";
        $result = mysql_query($query);
        return $result;
    }

    /**
     * Retrieve game by serial id or uuid.
     *
     * @param mixed $id
     *  UUID or ID of the game.
     */
    public function getGame($id) {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
        $query = "SELECT * FROM `games` WHERE id=$search_id";
        $result = mysql_query($query);
        $game = mysql_fetch_assoc($result);
        return $game;
    }

    /**
     * Retrieve all teams.
     *
     * @param string $params.
     *  Set of params (WHERE, ORDER, etc)
     */
    public function getAllTeams($params = "") {
        $query = "SELECT * from `teams`" . $params;
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $teams[$row['uuid']] = $row;
        }
        return isset($teams) ? $teams : array();
    }

    /**
     * Retrieve team by id or uuid.
     *
     * @param mixed $id
     *  UUID or ID of the team.
     * @param string $params.
     *  Set of params (WHERE, ORDER, etc)
     */
    public function getTeam($id, $params = "") {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('teams', $id) : $id;
        $query = "SELECT * from `teams` WHERE id=$search_id" . $params;
        $result = mysql_query($query);
        $team = mysql_fetch_assoc($result);
        if (!empty($team['resources'])) {
            $team['resources'] = unserialize($team['resources']);
        }
        return $team;
    }

    public function addupdateTeam($team_info) {
        $columns = array('id', 'hidden', 'user_create', 'uuid', 'name', 'short', 'resources', 'logo_url', 'description', 'type');
        $values = '';
        $count = 1;
        $max_count = count($columns);
        if (!empty($team_info['resources']) && is_array($team_info['resources'])) {
            $team_info['resources'] = serialize($team_info['resources']);
        }
        foreach ($columns as $col) {
            $values .= is_null($team_info[$col]) ? 'NULL' : "'" . $team_info[$col] . "'";
            if ($count < $max_count) {
                $values .= ',';
            }
            $count++;
        }
        $query = "REPLACE INTO `teams` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function updateTeam($team_id, $team_info) {
        $original_team = $this->getTeam($team_id);
        $query = "UPDATE `teams` SET ";
        $count = 1;
        $max_count = count($original_team);
        $updated_team = array_merge($original_team, $team_info);
        if (!empty($updated_team['resources']) && is_array($updated_team['resources'])) {
            $updated_team['resources'] = serialize($updated_team['resources']);
        }
        foreach ($updated_team as $col => $new_value) {
          $query .= $col . "='" . $new_value . "'";
          if ($count < $max_count) {
            $query .= ",";
          }
          $count++;
        }
        $query .= " WHERE id='{$original_team['id']}'";
        $result = mysql_query($query);
        return $result;
    }

    public function getTeamGames($team_id) {
        $query = "SELECT g.*, c.league_type FROM games g JOIN comps c ON g.comp_id=c.id WHERE home_id = $team_id OR away_id = $team_id ORDER BY kickoff";
        $result = mysql_query($query);
        $team_games = array();
        if (!empty($result)) {
            while($team_game = mysql_fetch_assoc($result)) {
                $team_games[] = $team_game;
            }
        }
        return empty($team_games) ? FALSE : $team_games;
    }

    public function getCompetitionGames($comp_uuid) {
        $uuid = mysql_real_escape_string($comp_uuid);
        $query = "SELECT g.* FROM games g
          JOIN comp_top_group ctg ON ctg.id = g.comp_id
          JOIN teams t ON ctg.team_id = t.id
          WHERE t.uuid = '$uuid' ORDER BY g.kickoff;";
        $result = mysql_query($query);
        $games = array();
        if (!empty($result)) {
            while($game = mysql_fetch_assoc($result)) {
                $games[] = $game;
            }
        }
        return empty($games) ? FALSE : $games;
    }

    public function getCompetitionId($group_uuid) {
        $uuid = mysql_real_escape_string($group_uuid);
        $query = "SELECT ctg.id FROM comp_top_group ctg
          JOIN teams t ON ctg.team_id = t.id
          WHERE t.uuid = '$uuid';";
        $result = mysql_query($query);
        if (!empty($result)) {
            // Only fetch one result.
            $id = mysql_fetch_assoc($result);
        }
        return empty($id) ? FALSE : $id['id'];
    }

    public function getTeamRecordInCompetition($team_id, $comp_id) {
        $tries = 0;
        $record = array(
            'home_wins' => 0,
            'home_losses' => 0,
            'home_ties' => 0,
            'away_wins' => 0,
            'away_losses' => 0,
            'away_ties' => 0,
            'total_games' => 0,
            'points' => 0,
            'favor' => 0,
            'against' => 0,
            'try_bonus_total' => 0,
            'loss_bonus_total' => 0,
            'forfeits' => 0
            );
        $query = "SELECT g.*, s.status_name FROM `games` g, `game_status` s WHERE (g.home_id = $team_id OR g.away_id = $team_id) AND g.comp_id = $comp_id AND g.status = s.id";
        $result = mysql_query($query);
        if (!empty($result)) {
            while($team_game = mysql_fetch_assoc($result)) {
                $status = $team_game['status_name'];
                if ($status != 'Finished' && $status != 'Home Forfeit' && $status != 'Away Forfeit') {
                    continue;
                }
                $record['total_games']++;
                // Home games record.
                if ($team_game['home_id'] == $team_id) {
                    $record['favor'] += $team_game['home_score'];
                    $record['against']+= $team_game['away_score'];
                    if ($status == 'Home Forfeit') {
                        $record['favor'] = 0;
                        $record['points'] -= 1;
                        $record['forfeits'] += 1;
                        if ($record['against'] < 20) {
                            $record['against'] = 20;
                        }
                    } elseif ($status == 'Away Forfeit') {
                        if ($record['favor'] < 20) {
                            $record['favor'] = 20;
                            $tries = 4;
                        }
                    }
                    if ($record['favor'] > $record['against']) {
                        $record['home_wins']++;
                        $record['points'] += 4;
                    } elseif ($record['favor'] < $record['against']) {
                        $record['home_losses']++;
                        if ($record['favor'] + 7 >= $record['against']) {
                            $record['points'] += 1;
                            $record['loss_bonus_total'] ++;
                        }
                    } elseif ($record['favor'] == $record['against']) {
                        $record['home_ties']++;
                        $record['points'] += 2;
                    }
                }
                // Away record.
                else if ($team_game['away_id'] == $team_id) {
                    $record['favor']+= $team_game['away_score'];
                    $record['against']+= $team_game['home_score'];
                    if ($status == 'Away Forfeit') {
                        $record['favor'] = 0;
                        $record['points'] -= 1;
                        $record['forfeits'] += 1;
                        if ($record['against'] < 20) {
                            $record['against'] = 20;
                        }
                    } elseif ($status == 'Home Forfeit') {
                        if ($record['favor'] < 20) {
                            $record['favor'] = 20;
                            $tries = 4;
                        }
                    }
                    if ($record['favor'] > $record['against']) {
                        $record['away_wins']++;
                        $record['points'] += 4;
                    } elseif ($record['favor'] < $record['against']) {
                        $record['away_losses']++;
                        if ($record['favor'] + 7 >= $record['against']) {
                            $record['points'] += 1;
                            $record['loss_bonus_total'] ++;
                        }
                    } elseif ($record['favor'] == $record['against']) {
                        $record['away_ties']++;
                        $record['points'] += 2;
                    }
                }

                // Calculate Bonus Points.
                $tries_query = "SELECT COUNT(*) FROM game_events g, event_types t WHERE  t.id = g.type AND g.game_id = {$team_game['id']} AND t.name = 'Try' AND g.team_id = $team_id";
                $tries_result = mysql_fetch_row(mysql_query($tries_query));
                $tries_for_team_in_game = (int) $tries_result[0];
                if ($tries == 4 && $tries_for_team_in_game < 4) {
                    $tries_for_team_in_game = 4;
                }
                if ($tries_for_team_in_game >= 4) {
                    $record['points'] +=1;
                }
                $try_bonus_for_game = 0;
                if (!empty($tries_for_team_in_game) && $tries_for_team_in_game >= 4) {
                    $try_bonus_for_game = (($tries_for_team_in_game - ($tries_for_team_in_game % 4)) / 4);
                }
                $record['try_bonus_total'] = empty($record['try_bonus_total']) ? $try_bonus_for_game : $record['try_bonus_total'] + $try_bonus_for_game;
            }
        }

        $record['total_wins'] = $record['home_wins'] + $record['away_wins'];
        $record['total_losses'] = $record['home_losses'] + $record['away_losses'];
        $record['total_ties'] = $record['home_ties'] + $record['away_ties'];

        // Calculating winning percentage.
        $record['percent'] = ($record['total_games'] > 0) ? ($record['total_wins'] / $record['total_games']) : 0;
        $record['percent'] = number_format($record['percent'], 3);

        return $record;
    }

    /**
     * Retrieve a serial id by uuid.
     * @param string $table_name
     * @param string $uuid
     * @return string $id.
     */
    public function getSerialIDByUUID($table_name, $uuid) {
        $query = "SELECT id FROM `$table_name` WHERE uuid='$uuid'";
        $result = mysql_query($query);
        $serial_id = array();
        if (!empty($result)) {
          $serial_id = mysql_fetch_assoc($result);
        }
        return empty($serial_id['id']) ? FALSE : $serial_id['id'];
    }

    /**
     * Retrieve a uuid by serial id.
     * @param string $table_name
     * @param string $serial_id
     * @return string $uuid.
     */
    public function getUUIDBySerialID($table_name, $serial_id) {
        $table_name = mysql_real_escape_string($table_name);
        $serial_id = mysql_real_escape_string($serial_id);
        if (strpos($table_name, 'comp') !== FALSE) {
            $query = "SELECT t.uuid FROM teams t
              JOIN comp_top_group ctg ON ctg.team_id = t.id
              WHERE ctg.id = '$serial_id'";
        }
        else {
            $query = "SELECT uuid FROM `$table_name` WHERE id='$serial_id'";
        }
        $result = mysql_query($query);
        $uuid = mysql_fetch_assoc($result);
        return empty($uuid['uuid']) ? FALSE : $uuid['uuid'];
    }

    public function getRoster($game_id, $team_id) {
        $game_search_id = DataSource::uuidIsValid($game_id) ? $this->getSerialIDByUUID('games', $game_id) : $game_id;
        $team_search_id = DataSource::uuidIsValid($team_id) ? $this->getSerialIDByUUID('teams', $team_id) : $team_id;
        $query = "SELECT * FROM `game_rosters` WHERE game_id = $game_search_id AND team_id = $team_search_id";
        $result = mysql_query($query);
        $roster = mysql_fetch_assoc($result);
        return $roster;
    }

    public function addRoster($roster_data) {
        $columns = array('id', 'user_create', 'last_edit', 'comp_id', 'game_id', 'team_id', 'player_ids', 'numbers', 'frontrows', 'positions');
        $values = '';
        $count = 1;
        $max_count = count($columns);
        foreach ($columns as $col) {
            $values .= is_null($roster_data[$col]) ? 'NULL' : "'" . $roster_data[$col] . "'";
            if ($count < $max_count) {
                $values .= ',';
            }
            $count++;
        }
        $query = "INSERT INTO `game_rosters` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function getRosterById($id) {
        $query = "SELECT * FROM `event_rosters` WHERE id = $id";
        $result = mysql_query($query);
        $roster = mysql_fetch_assoc($result);
        return $roster;
    }

    public function getCompetition($comp_id) {
        $query = "SELECT * FROM `comps` WHERE id = $comp_id";
        $result = mysql_query($query);
        $competition = mysql_fetch_assoc($result);
        return $competition;
    }

    public function getAllCompetitions($params = '') {
        $query = "SELECT * from `comps`" . $params;
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $comps[$row['id']] = $row;
        }
        return isset($comps) ? $comps : FALSE;
    }

    // Add a competition.
    public function addCompetition($comp_info) {
        $columns = array('id', 'user_create', 'name', 'start_date', 'end_date', 'type', 'league_type', 'max_event', 'max_game', 'hidden');
        $values = '';
        $count = 1;
        $max_count = count($columns);
        foreach ($columns as $col) {
            $values .= is_null($comp_info[$col]) ? 'NULL' : "'" . $comp_info[$col] . "'";
            if ($count < $max_count) {
                $values .= ',';
            }
            $count++;
        }
        $query = "REPLACE INTO `comps` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        $comp_id = mysql_insert_id();

        // Remove associated "top level groups" and update with the latest.
        $query = "DELETE FROM comp_top_group WHERE id={$comp_info['id']};";
        $result = mysql_query($query);
        foreach ($comp_info['top_groups'] as $top_group) {
            $query = "INSERT INTO `comp_top_group` (id, team_id) VALUES ($comp_id, $top_group)";
            $result = mysql_query($query);
        }
        return $result;
    }

    public function getCompetitionTopGroups($comp_id) {
        $query = "SELECT * FROM comp_top_group WHERE id = $comp_id";
        $result = mysql_query($query);
        $teams = array();
        while ($row = mysql_fetch_assoc($result)) {
            $teams[] = $row['team_id'];
        }
        return $teams;
    }

    public function getCompetitionTeams($comp_id) {
        $query = "SELECT t.*, c.division_id FROM teams t, ct_pairs c WHERE c.team_id = t.id AND c.comp_id = $comp_id ORDER BY c.division_id, t.name";
        $result = mysql_query($query);
        $teams = array();
        while ($row = mysql_fetch_assoc($result)) {
            $teams[$row['uuid']] = $row;
        }
        return $teams;
    }

    public function getGameScoreEvents($id) {
        $game_score_events = array();
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
        $query = "SELECT * FROM `game_events` WHERE game_id = $search_id AND type < 10 ORDER BY minute, type";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $game_score_events[] = $row;
        }
        return $game_score_events;
    }

    public function getGameSubEvents($id) {
        $game_sub_events = array();
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
        $query = "SELECT * FROM `game_events` WHERE game_id = $search_id AND type > 10 AND type < 20 ORDER BY minute, team_id, type";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $game_sub_events[] = $row;
        }
        return $game_sub_events;
    }

    public function getGameCardEvents($id) {
        $game_card_events = array();
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('games', $id) : $id;
        $query = "SELECT * FROM `game_events` WHERE game_id = $search_id AND type > 20 ORDER BY minute, type, team_id";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
            $game_card_events[] = $row;
        }
        return $game_card_events;
    }

    public function getUser($id = NULL, $email = NULL) {
        if (!empty($id)) {
            $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('users', $id) : $id;
            if (empty($search_id)) {
                return FALSE;
            }
            $query = "SELECT * FROM `users` WHERE id=$search_id";
        } elseif (!empty($email)) {
            $query = "SELECT * FROM `users` WHERE login='$email'";
        } else {
            return FALSE;
        }
        $result = mysql_query($query);
        return empty($result) ? $result : mysql_fetch_assoc($result);
    }

    public function addUser($user_info) {
        $user_info['login'] = mysql_real_escape_string($user_info['login']);
        $columns = array();
        foreach ($user_info as $key_name => $user_info_piece) {
            if (isset($user_info_piece)) {
                $columns[] = $key_name;
            }
        }
        $values = array();
        foreach ($columns as $col_name) {
            $values[] = $user_info[$col_name];
        }
        $query = "INSERT INTO `users` (" . implode(',', $columns) . ") VALUES ('" . implode("', '", $values) . "')";
        $result = mysql_query($query);
        return $result;
    }

    public function removeUsers($users) {
        foreach ($users as $key => $user) {
            if (isset($user['email'])) {
                $query = "DELETE FROM `users` WHERE login = '{$user['email']}'";
            }
            elseif (isset($user['id'])) {
                $query = "DELETE FROM `users` WHERE id = '{$user['id']}'";
            }
            elseif (isset($user['uuid'])) {
                $query = "DELETE FROM `users` WHERE uuid = '{$user['uuid']}'";
            }
            $result[$key] = mysql_query($query);
        }
        return $result;
    }

    public function updateUser($id, $user_info) {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('users', $id) : $id;
        $original_user = $this->getUser($search_id);
        $user_info = array_merge($original_user, $user_info);
        $login = $user_info['login'];
        $team = $user_info['team'];
        $access = $user_info['access'];
        $uuid = $user_info['uuid'];
        $token = $user_info['token'];
        $secret = $user_info['secret'];
        $query = "UPDATE `users` SET login='$login', team='$team', access='$access', uuid='$uuid', token = '$token', secret='$secret' WHERE id='$search_id'";
        $result = mysql_query($query);
        return $result;
    }

    public function getPlayerGameEvents($player_id, $comp_id = NULL, $game_id = NULL) {
        $player_search_id = DataSource::uuidIsValid($player_id) ? $this->getSerialIDByUUID('players', $player_id) : $player_id;
        $game_events = array();
        if (empty($player_search_id)) {
            return FALSE;
        }
        $query = "SELECT
                  ge.game_id,
                  ge.player_id,
                  ge.type,
                  ge.minute,
                  evt.name,
                  evt.value,
                  gam.home_id,
                  gam.away_id,
                  gam.kickoff
                  FROM game_events ge
                  JOIN  games gam ON (ge.game_id = gam.id)
                  JOIN event_types evt ON (ge.type = evt.event_id)
                  WHERE ge.player_id=$player_search_id";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
          $game_events[] = $row;
        }
        return $game_events;
    }

    public function getGamesWithPlayerOnRoster($player_id, $comp_id = NULL) {
        $player_search_id = DataSource::uuidIsValid($player_id) ? $this->getSerialIDByUUID('players', $player_id) : $player_id;
        if (empty($player_search_id)) {
            return FALSE;
        }
        $games = array();
        $query = "SELECT DISTINCT
                  g.id as game_id,
                  g.home_id as home_id,
                  g.away_id as away_id,
                  g.kickoff as kickoff
                  FROM players p
                  JOIN teams t ON (p.team_uuid = t.uuid)
                  JOIN games g ON (t.id IN (g.home_id, g.away_id))
                  JOIN game_rosters gr ON (g.id = gr.game_id)
                  WHERE gr.player_ids LIKE '%-$player_search_id-%'";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
          $games[] = $row;
        }
        return $games;
    }


    public function addupdatePlayer($player_info) {
        $columns = $this->showColumns('players');
        $values = '';
        $count = 1;
        $max_count = count($columns);
        foreach ($columns as $col_key => $col) {
            if (array_key_exists($col, $player_info)) {
                $values .= is_null($player_info[$col]) ? 'NULL' : "'" . $player_info[$col] . "'";
                if ($count < $max_count) {
                  $values .= ',';
                }
            }
            else {
                unset($columns[$col_key]);
            }
            $count++;
        }
        $query = "REPLACE INTO `players` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function getPlayer($id) {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('players', $id) : $id;
        if (empty($search_id)) {
            return FALSE;
        }
        $query = "SELECT * FROM `players` WHERE id=$search_id";
        $result = mysql_query($query);
        return empty($result) ? $result : mysql_fetch_assoc($result);
    }

    public function getTeamPlayers($uuid) {
        $query = "SELECT * FROM `players` WHERE team_uuid='$uuid'";
        $result = mysql_query($query);
        if ($result == FALSE) {
            return FALSE;
        }
        while ($row = mysql_fetch_assoc($result)) {
            $players[$row['uuid']] = $row;
        }
        return isset($players) ? $players : FALSE;
    }

    public function addResource($resource_data) {
        $columns = array('id', 'uuid', 'title', 'location');
        $values = '';
        $count = 1;
        $max_count = count($columns);
        if (!empty($resource_data['location']) && is_array($resource_data['location'])) {
            $resource_data['location'] = serialize($resource_data['location']);
        }
        foreach ($columns as $col) {
            $values .= is_null($resource_data[$col]) ? 'NULL' : "'" . $resource_data[$col] . "'";
            if ($count < $max_count) {
                $values .= ',';
            }
            $count++;
        }
        $query = "INSERT INTO `resources` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function getResource($id) {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('resources', $id) : $id;
        $query = "SELECT * FROM `resources` WHERE id=$search_id";
        $result = mysql_query($query);
        $resource = empty($result) ? $result : mysql_fetch_assoc($result);
        if (!empty($resource['location'])) {
            $resource['location'] = unserialize($resource['location']);
        }
        return $resource;
    }

    public function updateResource($id, $new_resource_data) {
        $original_resource = $this->getResource($id);
        $query = "UPDATE `resources` SET ";
        $count = 1;
        $max_count = count($original_resource);
        $updated_resource = array_merge($original_resource, $new_resource_data);
        if (!empty($updated_resource['location']) && is_array($updated_resource['location'])) {
            $updated_resource['location'] = serialize($updated_resource['location']);
        }
        foreach ($updated_resource as $col => $new_value) {
          $insert_value = is_null($new_value) ? 'NULL' : "'$new_value'";
          $query .= $col . "=" . $insert_value;
          if ($count < $max_count) {
            $query .= ",";
          }
          $count++;
        }
        $query .= " WHERE id='{$original_resource['id']}'";
        $result = mysql_query($query);
        return $result;
    }

    /**
     * Verify the validity of a uuid.
     * @param string $uuid
     *  UUID to verify.
     */
    public static function uuidIsValid($uuid) {
        return (boolean) preg_match('/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/', $uuid);
    }

    public function showColumns($table_name) {
        $columns = array();
        $query = "SHOW COLUMNS FROM $table_name";
        $result = mysql_query($query);
        while ($row = mysql_fetch_assoc($result)) {
          $columns[] = $row['Field'];
        }
        return $columns;
    }

}
