<?php
include_once './include_mini.php';
use Source\APSource;
$comp_id = $request->get('comp_id');
if (empty($comp_id)) {
    $team_uuid = $request->get('team_uuid');
    $team = $db->getTeam($team_uuid);
    $query = "SELECT * FROM `comps`";
    $result = mysql_query($query);
    while ($row = mysql_fetch_assoc($result)) {
        if (in_array((string) $team['id'], explode(',', $row['top_groups']))) {
            $comp_id = $row['id'];
        }
    }
}

$doc = new DomDocument('1.0');

$root = $doc->appendChild($doc->createElement('sports-content'));
$root->setAttribute('xmlns', "http://iptc.org/std/SportsML/2008-04-01/");
$root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");

$sports_metadata = $root->appendChild($doc->createElement('sports-metadata'));
$sports_title = $doc->createElement('sports-title');
$sports_title->appendChild($doc->createTextNode("USA Rugby Standings"));
$sports_metadata->appendChild($sports_title);

$standing = $root->appendChild($doc->createElement('standing'));

$teams = $db->getCompetitionTeams($comp_id);
foreach ($teams as $uuid => $team) {
    $record = $db->getTeamRecordInCompetition($team['id'], $comp_id);
    $team_records[$uuid] = $record;
    $points[$uuid] = $record['points'];
    $games_played[$uuid] = $record['total_games'];
}

// Sort by ranking.
array_multisort($points, SORT_DESC, $games_played, SORT_ASC, $teams);
$rank = 1;
foreach ($teams as $uuid => $team) {
    $record = $team_records[$uuid];
    $team_node = $standing->appendChild($doc->createElement('team'));

    $team_metadata = $team_node->appendChild($doc->createElement('team-metadata'));
    $name = $team_metadata->appendChild($doc->createElement('name'));
    $name->setAttribute('full', $team['name']);

    $team_stats = $team_node->appendChild($doc->createElement('team-stats'));
    $team_stats->setAttribute('events-played', $record['total_games']);
    $team_stats->setAttribute('standing-points', $record['points']);
    $ranking = $team_stats->appendChild($doc->createElement('rank'));
    $ranking->setAttribute('value', (string) $rank);
    $rank++;

    $totals = $team_stats->appendChild($doc->createElement('outcome-totals'));
    $totals->setAttribute('wins', $record['total_wins']);
    $totals->setAttribute('losses', $record['total_losses']);
    $totals->setAttribute('ties', $record['total_ties']);
    $totals->setAttribute('winning-percentage', $record['percent']);
    $totals->setAttribute('points-scored-for', $record['favor']);
    $totals->setAttribute('points-scored-against', $record['against']);

    $totals = $team_stats->appendChild($doc->createElement('outcome-totals'));
    $totals->setAttribute('alignment-scope', 'events-home');
    $totals->setAttribute('wins', $record['home_wins']);
    $totals->setAttribute('losses', $record['home_losses']);
    $totals->setAttribute('ties', $record['home_ties']);

    $totals = $team_stats->appendChild($doc->createElement('outcome-totals'));
    $totals->setAttribute('alignment-scope', 'events-away');
    $totals->setAttribute('wins', $record['away_wins']);
    $totals->setAttribute('losses', $record['away_losses']);
    $totals->setAttribute('ties', $record['away_ties']);
}

$doc->saveXML();
$xslDoc = new DOMDocument();
$xslDoc->load("views/sportsml2html.xsl");
$proc = new XSLTProcessor();
$proc->importStylesheet($xslDoc);
echo $proc->transformToXML($doc);

