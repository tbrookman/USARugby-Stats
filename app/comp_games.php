<?php
include_once './include_mini.php';

$base_url = $request->getSchemeAndHttpHost();

if (!isset($comp_id) || !$comp_id) {$comp_id=$_GET['id'];}

$query = "SELECT * FROM `games` WHERE comp_id = $comp_id ORDER BY kickoff";
$result = mysql_query($query);
$game_rows = array(); 
while ($row=mysql_fetch_assoc($result)) {
    // Get infomation for each game
    $game = array();
    $game['canedit'] = false;
    $game['kickoff'] = date('n/j g:ia', strtotime($row['kickoff']));
    $resource = $db->getResource($row['field_num']);
    
    if (editCheck(1)) {
        $game['canedit'] = true;
        $game['id'] = $row['id'];
        $game['comp_id'] = $comp_id;
        // Modals:
        if (empty($twig)) {
            $loader = new Twig_Loader_Filesystem(__DIR__.'/views');
            $twig = new Twig_Environment($loader, array());
        }

        $rosteriframe = array(
            'entity' => 'roster',
            'eid' => $row['id'],
            'title' => 'Roster', // TODO: What is this roster's name?
            'iframe_url' => "$base_url/game.php?iframe=1&id={$row['id']}&ops[0]=game_rosters",
        );
        $game['rosteriframe'] = $twig->render('modal-template-iframe.twig', array('modal' => $rosteriframe));

        $gameiframe = array(
            'entity' => 'game',
            'eid' => $row['id'],
            'title' => 'Game info',
            'iframe_url' => "$base_url/game.php?iframe=1&id={$row['id']}&ops[0]=game_info&ops[1]=game_score&ops[2]=game_rosters&ops[3]=game_score_events&ops[4]=game_sub_events&ops[5]=game_card_events",
        );
        $game['gameiframe'] = $twig->render('modal-template-iframe.twig', array('modal' => $gameiframe));
    }

    $game['comp_game_id'] = $row['comp_game_id'];
    $game['home_id'] = teamName($row['home_id']);
    $game['score'] = "<a href='game.php?id={$row['id']}'>{$row['home_score']} - {$row['away_score']}</a>";
    $game['away_id'] = teamName($row['away_id']);
    $game['field'] = $resource['title'];
    $game_rows[] = $game;
}

if (empty($twig)) {
    $loader = new Twig_Loader_Filesystem(__DIR__.'/views');
    $twig = new Twig_Environment($loader, array());
}

echo $twig->render('comp-games.twig', array('gamerows' => $game_rows));
        
