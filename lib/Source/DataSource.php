<?php

namespace Source;

class DataSource {

    /**
     * Initialize database connection.
     */
    function __construct() {
        include './config.php';
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];
        $server = $config['server'] ? $config['server'] : 'localhost';

        mysql_connect($server, $username, $password);
        @mysql_select_db($database) or die("Unable to select database");
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
    public function getTeam($uuid, $params = "") {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('teams', $id) : $id;
        $query = "SELECT * from `teams` WHERE id=$search_id" . $params;
        $result = mysql_query($query);
        $team = mysql_fetch_assoc($result);
        return $team;
    }

    public function addTeam($team_info) {
        $query = "INSERT INTO `teams` VALUES ('', '" . implode("', '", $team_info) . "')";
        $result = mysql_query($query);
        return $result;
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
        $serial_id = mysql_fetch_assoc($result);
        return empty($serial_id['id']) ? FALSE : $serial_id['id'];
    }

    /**
     * Retrieve a uuid by serial id.
     * @param string $table_name
     * @param string $serial_id
     * @return string $uuid.
     */
    public function getUUIDBySerialID($table_name, $serial_id) {
        $query = "SELECT id FROM `$table_name` WHERE id='$serial_id'";
        $result = mysql_query($query);
        $uuid = mysql_fetch_assoc($result);
        return empty($uuid['uuid']) ? FALSE : $uuid['uuid'];
    }

    public function getRoster($game_id, $team_id) {
        $query = "SELECT * FROM `game_rosters` WHERE game_id = $game_id AND team_id = $team_id";
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
            $query = "SELECT * FROM `users` WHERE login=$email";
        } else {
            return FALSE;
        }
        $result = mysql_query($query);
        return empty($result) ? $result : mysql_fetch_assoc($result);
    }

    public function addUser($user_info) {
        $user_info['email'] = mysql_real_escape_string($user_info['email']);
        $query = "INSERT INTO `users` VALUES ('', '" . implode("', '", $user_info) . "', NULL, NULL)";
        $result = mysql_query($query);
        return $result;
    }

    public function updateUser($id, $user_info) {
        $search_id = DataSource::uuidIsValid($id) ? $this->getSerialIDByUUID('users', $id) : $id;
        $email = $user_info['email'];
        $team = $user_info['team'];
        $access = $user_info['access'];
        $query = "UPDATE `users` SET login='$email', team='$team', access='$access' WHERE id='$search_id'";
        $result = mysql_query($query);
        return $result;
    }

    public function addPlayer($player_info) {
        $query = "INSERT INTO `players` VALUES ('', '" . implode("', '", $player_info) . "')";
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

    /**
     * Verify the validity of a uuid.
     * @param string $uuid
     *  UUID to verify.
     */
    public static function uuidIsValid($uuid) {
        return (boolean) preg_match('/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/', $uuid);
    }

}