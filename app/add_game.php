<?php
include_once './include_mini.php';

$comp_id = $_GET['id'];
?>

<h4>Add a Game</h4>

<form name='addgame' id='addgame' method='POST' action=''>

<label for="field" id="field_label">Field Number</label>
<input id='field' name='field' type='text' size='1'>
<br/>

<label for="gnum" id="gnum_label">Competition Game Number</label>
<input id='gnum' name='gnum' type='text' size='1'>
<label class="error" for="gnum" id="gnum_error">This field is required.</label>
<br/>

<label for="kdate" id="kdate_label">Game Date</label>
<select name='kdate' id='kdate'>
<option value=''></option>

<?php
//find the start date and list an option for all days from
//start date to end date using date and strtotime
$query = "SELECT * FROM `comps` WHERE id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    $sdate = $row['start_date'];
    $edate = $row['end_date'];
}

$stime = strtotime($sdate);
$etime = strtotime($edate);

while ($stime <= $etime) {
    $output = date('F j, Y', $stime);
    echo "<option value='$stime'>$output</option>";
    $stime = $stime+60*60*24;
}
?>

</select>
<label class="error" for="kdate" id="kdate_error">This field is required.</label>
<label class="error" for="kdate" id="kdate_derror">Incorrect date format.</label>
<br/>

<label for="koh" id="koh_label">Kickoff Hour</label>
<select name='koh' id='koh'>
<option value=''></option>
<option value='07'>7am</option>
<option value='08'>8am</option>
<option value='09'>9am</option>
<option value='10'>10am</option>
<option value='11'>11am</option>
<option value='12'>12pm</option>
<option value='13'>1pm</option>
<option value='14'>2pm</option>
<option value='15'>3pm</option>
<option value='16'>4pm</option>
<option value='17'>5pm</option>
<option value='18'>6pm</option>
<option value='19'>7pm</option>
<option value='20'>8pm</option>
<option value='21'>9pm</option>
<option value='22'>10pm</option>
<option value='23'>11pm</option>
</select>
<label class="error" for="koh" id="koh_error">This field is required.</label>

<label for="kom" id="kom_label">Kickoff Minute</label>
<select name='kom' id='kom'>
<option value=''></option>
<option value='00'>:00</option>
<option value='05'>:05</option>
<option value='10'>:10</option>
<option value='15'>:15</option>
<option value='20'>:20</option>
<option value='25'>:25</option>
<option value='30'>:30</option>
<option value='35'>:35</option>
<option value='40'>:40</option>
<option value='45'>:45</option>
<option value='50'>:50</option>
<option value='55'>:55</option>
</select>
<label class="error" for="kom" id="kom_error">This field is required.</label>
<br/>

<label for="home" id="home_label">Home Team</label>
<select name='home' id='home'>
<option value=''></option>

<?php
$query = "SELECT * FROM `ct_pairs` WHERE comp_id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $query1 = "SELECT * FROM `teams` WHERE id = {$row['team_id']}";
    $result1 = mysql_query($query1);
    while ($row1=mysql_fetch_assoc($result1)) {
        echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
    }
}
?>

</select>
<label class="error" for="home" id="home_error">This field is required.</label>
<br/>

<label for="away" id="away_label">Away Team</label>
<select name='away' id='away'>
<option value=''></option>

<?php
$query = "SELECT * FROM `ct_pairs` WHERE comp_id = $comp_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    $query1 = "SELECT * FROM `teams` WHERE id = {$row['team_id']}";
    $result1 = mysql_query($query1);
    while ($row1=mysql_fetch_assoc($result1)) {
        echo "<option value='{$row1['id']}'>{$row1['name']}</option>";
    }
}
?>

</select>
<label class="error" for="away" id="away_error">This field is required.</label>
<br/>

<input type='hidden' name='grefresh' id='grefresh' value='<?php echo "comp_games.php?id=$comp_id"; ?>'>
<input type='hidden' name='comp_id' id='comp_id' value='<?php echo $comp_id; ?>'>
<input type='submit' name='submit' class='button' id='add_game' value='Add Game'>
</form>

<!--this is to hide the errors after a jquery refresh upon adding a new team to the comp-->
<script type='text/javascript'>$('.error').hide();</script>

<?php
include_once './footer.php';
