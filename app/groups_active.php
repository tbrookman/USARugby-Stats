<?php
use Source\QueueHelper;

include_once './include.php';
use Source\APSource;

$teams = array();
$client = APSource::SessionSourceFactory();
$teams = $db->getAllTeams();
$checkboxvalue = $_POST['checkbox'];
if (isset($_POST['submit'])) {
    unset($_POST['post']);
    
    echo '<div class="alert alert-success">Show Groups.</div>';
    
    foreach ($teams as $uuid => $team) {
    for ($i=0; $i<sizeof($checkboxvalue); $i++) {
        $query="UPDATE teams SET status = ('".$checkboxvalue[$i]."') WHERE status ='hide' ";
         mysql_query($query) or die(mysql_error());
           }
    }
           echo "record is inserted";       
}
?>
<form name="teams_sync" id="teams_sync" method="POST" action="">
    <label for="check_all">Show All:</label>
    <input type="checkbox" name="check_all" id="active" />
    <br />
    <?php
    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        echo "<input id='checkbox' type=\"checkbox\" name='checkbox[]' value='show' \\>";
        echo "  {$team['name']} (<small>$uuid</small>)";
        echo '</label>';
    }
    ?>
    <input class="button" name="submit" type="submit" value="Show" />
    <input class="button" name="submit" type="submit" value="Hide" />
</form>
