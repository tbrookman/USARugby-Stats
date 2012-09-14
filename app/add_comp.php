<?php
include_once './header.php';
?>

<h1>Create a Competition</h1>

<form name='addcomp' id='addcomp' method='POST' action='add_comp_process.php' class="">
<div class="alert error alert-error" id="form-validation-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <div class="error-message"></div>
</div>
<label for="name" id="name_label" >Name</label>
<input id='name' name='name' type='text' size='30' placeholder="Competition Name" class="required input-large">
<!--<label class="error" for="name" id="name_error">This field is required.</label>-->

<label for="type" id="type_label">Type</label>
<select name='type' id='type' class="required">
<option value=''></option>
<option value='1'>15s</option>
<option value='2'>7s</option>
</select>
<!--<label class="error" for="type" id="type_error">This field is required.</label>-->

<label id="date_time" class="control-label">Date And Time</label>
<input id='start_date' name='start_date' type='text' size='10' class="date_select required input-small" placeholder="Start Date">
<!--<label class="error" for="start_date" id="start_date_error">This field is required.</label>-->
<input id='end_date' name='end_date' type='text' size='10' class="date_select required input-small" placeholder="End Date">
<!--<label class="error" for="end_date" id="end_date_error">This field is required.</label>-->

<label for="max_event" id="max_event_label">Maximum players on event roster</label>
<select name='max_event' id='max_event'>
	<option value=''></option>
	<?php
	for ($i = 10; $i <= 35; $i++) {
		echo '<option value="' . $i . '">' . $i . '</option>';
	}
	?>
<option value='99'>Unlimited</option>
</select>
<!--<label class="error" for="max_event" id="max_event_error">This field is required.</label>-->

<label for="max_event" id="max_event_label">Maximum players on match roster</label>
<select name='max_match' id='max_match'>
<option value=''></option>
	<?php
	for ($i = 7; $i <= 25; $i++) {
		echo '<option value="' . $i . '">' . $i . '</option>';
	}
	?>
<option value='99'>Unlimited</option>
</select>
<!--<label class="error" for="max_match" id="max_match_error">This field is required.</label>-->
<br/>

<input type='submit' name='submit' class='button' id='add_comp' value='Create Competition'>
</form>

<?php
include_once './footer.php';
