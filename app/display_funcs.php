<?php

use Source\DataSource;
/**
 *
 *
 * @param unknown $id
 * @return unknown
 */

function teamName($id, $link = TRUE)
{
    $query = "SELECT id, short FROM `teams` WHERE id = $id";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        if (!empty($link)) {
          $output = "<a href='team.php?id={$row['id']}'>{$row['short']}</a>";
        }
        else {
          $output = $row['short'];
        }
    }

    return (isset($output) && $output) ? $output : '';
}

function getFullImageUrl($partial_image_url) {
    include './config.php';
    $image_url = $config['cdn'] . $partial_image_url;
    return $image_url;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function teamNameF($id)
{
    $query = "SELECT id, name FROM `teams` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "<a href='team.php?id={$row['id']}'>{$row['name']}</a>";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function teamNameNL($id)
{
    $query = "SELECT id, name FROM `teams` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['name']}";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function compName($id, $link = TRUE)
{
    $query = "SELECT id, name FROM `comps` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {
      if ($link) {
        $output = "<a href='comp.php?id={$row['id']}'>{$row['name']}</a>";
      }
      else {
        $output = $row['name'];
      }
    }

    return (isset($output) && $output) ? $output : '';
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function playerName($id, $game_id = NULL)
{
    include_once './player.php';
    if (empty($id)) {
        return '';
    }
    if (empty($db)) {
      $db = new DataSource();
    }
    $player = $db->getPlayer($id);
    $player_id = 'player-' . $id;
    $output = '';
    $popover_template = '';
    $popover_template .= "<div class='popover' id='$player_id'>";
    $popover_template .= "<div class='arrow'></div><div class='popover-inner'><h3 class='popover-title'></h3><div class='popover-content'>";
    $popover_template .= "<iframe class='player-popover-iframe' id='$player_id' seamless scrolling='no' src='http://www.stats.dev/player?player_id=$id&iframe=1' onLoad='iframeLoaded(this)'></iframe>";
    $popover_template .= "</div></div></div>";
    $picture_url = getFullImageUrl($player['picture_url']);
    $full_name = $player['firstname'] . ' ' .$player['lastname'];
    $popover_title = htmlspecialchars("$full_name<button type='button' class='close' id='$player_id' onClick='closePopover(this);'>×</button>", ENT_QUOTES);
    $output .= "<div class='player-popover'> <a href='#' data-player-id='$id' id='$player_id' data-title='$popover_title'";
    $output .= " data-template='" . htmlspecialchars($popover_template, ENT_QUOTES) ."'>";
    $output .= "<img src='$picture_url' class='img-polaroid player-picture player-picture-mini' alt='$full_name' onerror='imgError(this);'/>";
    $output .= $full_name;
    $output .= "<div class='player-popover-container'></div></a></div>";


    return $output;
}

function getPopoverContentForPlayer($player_data = array(), $player_id = NULL, $game_id = NULL) {
    if (empty($db)) {
      $db = new DataSource();
    }
    if (empty($player_data)) {
        $player_data = $db->getPlayer($id);
    }
    $popover_content = '';
    $picture_url = getFullImageUrl($player_data['picture_url']);
    $full_name = $player_data['firstname'] . ' ' .$player_data['lastname'];
    // Construct Popover Content.
    $popover_content = "<div class='row player-popover-content'>";
    /*$popover_content .= "<div class='left-col span1'>";
    $popover_content .= "<img src='$picture_url' class='img-polaroid player-picture player-picture-medium' alt='$full_name' onerror='imgError(this);'/>";
    $popover_content .= "</div>";
    $popover_content .= "<div class='span3 right-col'>";
    $player_team = $db->getTeam($player_data['team_uuid']);
    if (!empty($player_team)) {
      $popover_content .= "<div class='row'><strong>Club: </strong>{$player_team['short']}</div>";
    }
    $popover_content .= "</div>";*/
    $popover_content .= "</div>";
    $popover_content = htmlspecialchars($popover_content, ENT_QUOTES);
    return $popover_content;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function rplayerName($id)
{
    $query = "SELECT id,firstname,lastname FROM `players` WHERE id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['lastname']}, {$row['firstname']}";
    }

    return $output;
}

/**
 *
 *
 * @param unknown $id
 * @return unknown
 */
function eType($id)
{
    $query = "SELECT name FROM `event_types` WHERE event_id = $id";
    $result = mysql_query($query);
    while ($row=mysql_fetch_assoc($result)) {

        $output = "{$row['name']}";
    }

    return isset($output) ? $output : '';
}

/**
 *
 *
 * @param unknown $switch
 * @return unknown
 */
function sign($switch)
{
    if ($switch)
        return "Signed";
    else
        return "Not Signed";
}

/**
 *
 *
 * @param unknown $access
 * @return unknown
 */
function accessName($access)
{
    if ($access == 1) {
        $output = 'Administrator';
    } elseif ($access==2) {
        $output = 'Referee';
    } elseif ($access==3) {
        $output = 'Team Specific';
    } else {
        $output = 'View Only';
    }

    return $output;
}

/**
 *
 *
 * @param unknown $pagelvl (optional)
 * @param unknown $team_id (optional)
 * @return unknown
 */
function editCheck($pagelvl = 2, $team_id = -2)
{
    if ((isset($_SESSION['access']) && $_SESSION['access']<=$pagelvl) || (isset($_SESSION['teamid']) && $_SESSION['teamid']==$team_id)) {
        return true;
    } else {
        return false;
    }
}


function get_header_string($op) {
  switch ($op) {
    case 'game_events':
      $headers = array(
        'minute',
        'type',
        'team',
        'player'
      );
  }
  $header_string = '<tr>';
  foreach ($headers as $header) {
    $header_string .= '<th>' . ucfirst($header) . '</th>';
  }
  $header_string .= '</tr>';
  return $header_string;
}
