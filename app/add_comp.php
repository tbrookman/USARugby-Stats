<?php
include_once ('./header.php');
?>

<h1>Create a Competition</h1>

<form name='addcomp' id='addcomp' method='POST' action='add_comp_process.php'>

<label for="name" id="name_label">Name</label>
<input id='name' name='name' type='text' size='30'>
<label class="error" for="name" id="name_error">This field is required.</label>
<br/>

<label for="type" id="type_label">Type</label>
<select name='type' id='type'>
<option value=''></option>
<option value='1'>15s</option>
<option value='2'>7s</option>
</select>
<label class="error" for="type" id="type_error">This field is required.</label>
<br/>

<label for="start_date" id="start_date_label">Start Date (YYYY-MM-DD)</label>
<input id='start_date' name='start_date' type='text' size='10'>
<label class="error" for="start_date" id="start_date_error">This field is required.</label>
<br/>

<label for="end_date" id="end_date_label">End Date (YYYY-MM-DD)</label>
<input id='end_date' name='end_date' type='text' size='10'>
<label class="error" for="end_date" id="end_date_error">This field is required.</label>
<br/>

<label for="max_event" id="max_event_label">Maximum players on event roster</label>
<select name='max_event' id='max_event'>
<option value=''></option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='26'>26</option>
<option value='27'>27</option>
<option value='28'>28</option>
<option value='29'>29</option>
<option value='30'>30</option>
<option value='31'>31</option>
<option value='32'>32</option>
<option value='33'>33</option>
<option value='34'>34</option>
<option value='35'>35</option>
<option value='99'>Unlimited</option>
</select>
<label class="error" for="max_event" id="max_event_error">This field is required.</label>
<br/>

<label for="max_event" id="max_event_label">Maximum players on match roster</label>
<select name='max_match' id='max_match'>
<option value=''></option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='23'>23</option>
<option value='24'>24</option>
<option value='25'>25</option>
<option value='99'>Unlimited</option>
</select>
<label class="error" for="max_match" id="max_match_error">This field is required.</label>
<br/>

<input type='submit' name='submit' class='button' id='add_comp' value='Create Competition'>
</form>

<?php
include_once ('./footer.php');
?>
