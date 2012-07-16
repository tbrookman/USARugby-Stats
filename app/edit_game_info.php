<?php
include_once ('./include_mini.php');

if(!$game_id){$game_id=$_GET['id'];}

//get info for the game with id in url
$query = "SELECT * FROM `games` WHERE id = $game_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)){
$ko = date('F j, Y',strtotime($row['kickoff']));

echo compName($row['comp_id'])."<br/>";

echo "<label for='gnum' id='gnum_label'>Competition Game Number</label>";
echo "<input id='gnum' name='gnum' type='text' size='1' value='{$row['comp_game_id']}'>";
echo "<label class='error' for='gnum' id='gnum_error'>This field is required.</label><br/>";


echo teamName($row['away_id'])." @ ".teamName($row['home_id'])."<br/>";

echo "<label for='kdate' id='kdate_label'>Game Date</label>";
echo "<select name='kdate' id='kdate'>";
echo "<option value=''></option>";

//find the start date and list an option for all days from
//start date to end date using date and strtotime
$query2 = "SELECT * FROM `comps` WHERE id = {$row['comp_id']}";
$result2 = mysql_query($query2);
while ($row2=mysql_fetch_assoc($result2)){
$sdate = $row2['start_date'];
$edate = $row2['end_date'];
}

$stime = strtotime($sdate);
$etime = strtotime($edate);

while ($stime <= $etime){
$output = date('F j, Y', $stime);
if ($output==$ko){
$selected = 'selected';
}
else
{
$selected = '';
}

echo "<option value='$stime' $selected>$output</option>";
$stime = $stime+60*60*24;
}

echo "</select>";
echo "<label class='error' for='kdate' id='kdate_error'>This field is required.</label>";
echo "<label class='error' for='kdate' id='kdate_derror'>Incorrect date format.</label>";
echo "<br/>";

//get our current kickoff hour and minute to auto select in drop down later
$koh = date('G',strtotime($row['kickoff']));
$kom = date('i',strtotime($row['kickoff']));

?>

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

<?

echo "Field: <input id='field' name='field' type='text' size='1' value='{$row['field_num']}'>";
echo "<br/>";
}

if (editCheck()){
echo "<input type='button' class='edit' id='eGame' name='eGame' value='Submit Edits' />";
echo "<input type='hidden' id='game_id' value='$game_id' />";
}



echo "<script type='text/javascript'>";
//to hide errors on load
echo "$('.error').hide();";
//to select our hour and minute in kickoff drop downs
echo "$('#koh option[value=\"$koh\"]').attr('selected', 'selected');";
echo "$('#kom option[value=\"$kom\"]').attr('selected', 'selected');";
echo "</script>";

?>