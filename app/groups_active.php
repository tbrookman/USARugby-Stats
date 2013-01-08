<?php
use Source\QueueHelper;

include_once './include.php';
use Source\APSource;

$teams = array();
$client = APSource::SessionSourceFactory();
$teams = $db->getAllTeams();

if (isset($_POST['submit'])) {
    unset($_POST['']);
    //Capture values to put in database
    $sgroups = mysql_real_escape_string(implode(",", $_POST['sgroups']));
    $query("INSERT INTO teams WHERE status VALUES {$_POST['sgroups']}");
    $mysql_query($query, $link);
    $qh = new QueueHelper();
    echo '<div class="alert alert-success">Groups have been updated.</div>';
}
?>
<form name="teams_sync" id="teams_sync" method="POST" action="">
    <input type='hidden' name='grouprefresh' id='grouprefresh' value='hide_group.php' />
    <label for="active">Select the group that you would like to hide</label><br>
    <input id="buttonshow" class="btn btn-warning" name="submit" type="submit" value="Submit" />&nbsp;
    <input id="buttonshow" class="btn btn-danger" name="submit" type="submit" value="Refresh" /><br>
    <input class="sgroup" type="checkbox" name="active" id="active" /> Select All
    <br />
    <?php
    
    //$row['status] is a database field.
    $aSgroups = array("show", "hide");
    //converting comma separated into array using explode function
    $dbsgroups = explode(',',$team['status']);

    foreach ($teams as $uuid => $team) {
        echo '<label class=\"checkbox\">';
        echo "<ul class='sgroups'><li><div class='hideg showg' id='groups'>";
        echo "<input id='sgroup[]' value='{$showhide}' type=\"checkbox\" name=\"team_$uuid\" CHECKED \\>";
        echo "{$team['name']} (<small>$uuid</small>) {$team['status']}";
        echo '</label>';
        echo '</div></li></ul>';
        //Show hide values checkboxes
        foreach ($aSgroups as $showhide) {
            if(in_array($showhide, $dbsgroups)) {
                echo "<input type=\"checkbox\" value=\"$showhide\" CHECKED> $facil ";
            } 
            else {
                echo "<input type=\"checkbox\" value=\"$showhide\"> $showhide";
            }
        }
        
    }
    ?>
    <br >
    <!-- need to create hide display and show all display need to create value 'groups_file.php' -->
</form>
