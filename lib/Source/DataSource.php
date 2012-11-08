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
        return isset($teams) ? $teams : FALSE;
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

    public function addTeam($team_info) {
        $columns = array('id', 'hidden', 'user_create', 'uuid', 'name', 'short', 'resources', 'logo_url', 'description');
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
        $query = "INSERT INTO `teams` (" . implode(',', $columns) . ") VALUES ($values)";
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
        $query = "SELECT * FROM `games` WHERE home_id = $team_id OR away_id = $team_id ORDER BY kickoff";
        $result = mysql_query($query);
        $team_games = array();
        if (!empty($result)) {
            while($team_game = mysql_fetch_assoc($result)) {
                $team_games[] = $team_game;
            }
        }
        return empty($team_games) ? FALSE : $team_games;
    }

    public function getTeamRecordInCompetition($team_id, $comp_id) {
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
            'against' => 0
            );
        $query = "SELECT * FROM `games` WHERE home_id = $team_id OR away_id = $team_id AND comp_id = $comp_id";
        $result = mysql_query($query);
        if (!empty($result)) {
            while($team_game = mysql_fetch_assoc($result)) {
                $record['total_games']++;
                // Home games record.
                if ($team_game['home_id'] == $team_id) {
                    $record['favor'] += $team_game['home_score'];
                    $record['against']+= $team_game['away_score'];
                    if ($team_game['home_score'] > $team_game['away_score']) {
                        $record['home_wins']++;
                        $record['points'] += 4;
                    } elseif ($team_game['home_score'] < $team_game['away_score']) {
                        $record['home_losses']++;
                        if ($team_game['home_score'] + 7 >= $team_game['away_score']) {
                            $record['points'] += 1;
                        }
                    } elseif ($team_game['home_score'] == $team_game['away_score']) {
                        $record['home_ties']++;
                        $record['points'] +=2;
                    }
                }
                // Away record.
                else if ($team_game['away_id'] == $team_id) {
                    $record['favor']+= $team_game['away_score'];
                    $record['against']+= $team_game['home_score'];
                    if ($team_game['away_score'] > $team_game['home_score']) {
                        $record['away_wins']++;
                        $record['points'] += 4;
                    } elseif ($team_game['away_score'] < $team_game['home_score']) {
                        $record['away_losses']++;
                        if ($team_game['away_score'] + 7 >= $team_game['home_score']) {
                            $record['points'] += 1;
                        }
                    } elseif ($team_game['away_score'] == $team_game['home_score']) {
                        $record['away_ties']++;
                        $record['points'] += 2;
                    }
                }

                // Calculate Bonus Points.
                $tries_query = "SELECT COUNT(*) FROM game_events g, event_types t WHERE  t.id = g.type AND g.game_id = {$team_game['id']} AND t.name = 'Try' AND g.team_id = $team_id";
                $tries_result = mysql_fetch_row(mysql_query($tries_query));
                $record['tries'] = (int) $tries_result[0];
                if ($record['tries'] >= 4) {
                    $record['points'] +=1;
                }
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
        $query = "SELECT uuid FROM `$table_name` WHERE id='$serial_id'";
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
        $columns = array('id', 'user_create', 'name', 'start_date', 'end_date', 'type', 'max_event', 'max_game', 'hidden', 'top_groups');
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
        $query = "INSERT INTO `comps` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function getCompetitionTeams($comp_id) {
        $query = "SELECT t.* FROM teams t, ct_pairs c WHERE c.team_id = t.id AND c.comp_id = $comp_id";
        $result = mysql_query($query);
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

    public function addPlayer($player_info) {
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
        $query = "INSERT INTO `players` (" . implode(',', $columns) . ") VALUES ($values)";
        $result = mysql_query($query);
        return $result;
    }

    public function updatePlayer($id, $player_info) {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('players', $id) : $id;
        $now = date('Y-m-d H:i:s');
        $team_uuid = $user_info['team_uuid'];
        $player_uuid = $user_info['player_uuid'];
        $first_name = $user_info['first_name'];
        $last_name = $user_info['last_name'];
        $user_create = $_SESSION['user'];
        $query = "UPDATE `players` SET user_create='$user_create',last_update='$now',team_uuid='$team_uuid',firstname='$first_name',lastname='$last_name' WHERE id='$search_id'";
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