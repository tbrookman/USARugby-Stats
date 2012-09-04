<?php

class DataSource {
  public static function getGame($game_id) {
    $query = "SELECT * FROM `games` WHERE id = $game_id";
    $result = mysql_query($query);
    $game = mysql_fetch_assoc($result);
    return $game;
  }
}