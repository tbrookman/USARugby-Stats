<?php
include_once './header.php';
?>

<h1>Create a Competition</h1>

<form name='addcomp' id='addcomp' method='POST' action='add_comp_process.php'>
    <div class="alert error alert-error" id="form-validation-error">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <div class="error-message"></div>
    </div>

    <label for="name" id="name_label" >Name</label>
    <input id='name' name='name' type='text' size='30' placeholder="Competition Name" class="required input-large">

    <label for="type" id="type_label">Type</label>
    <select name='type' id='type' data-placeholder="Type" class="required chzn-select">
        <option value=''></option>
        <option value='1'>15s</option>
        <option value='2'>7s</option>
    </select>

    <label for="league_type" id="league_label">League Type</label>
    <select name='league_type' id='league-type' data-placeholder="League Type" class="required chzn-select">
        <option value=''></option>
        <option value='League'>League</option>
        <option value='Friendly'>Friendly</option>
        <option value='Playoffs'>Playoffs</option>
    </select>

    <label for="top_groups" id="top_groups_label" class="control-label">League or Division</label>
    <select data-placeholder='League or Division' name='top_groups[]' id='top_groups' class="input-medium chzn-select" multiple="multiple">
        <option value=''></option>
        <?php
        // Give a list of every team to choose from.
        $teams = $db->getAllTeams();
        foreach ($teams as $uuid => $team) {
            echo "<option value='{$team['id']}'>{$team['name']}</option>";
        }
        ?>
    </select>

    <label id="date_time" class="control-label">Date And Time</label>
    <input id='start_date' name='start_date' type='text' size='10' class="date_select required input-small" placeholder="Start Date">
    <input id='end_date' name='end_date' type='text' size='10' class="date_select required input-small" placeholder="End Date">

    <label for="max_event" id="max_event_label">Maximum players on event roster</label>

    <select name='max_event' id='max_event' data-placeholder="Max Players on Event Roster" class="input-large chzn-select required">
        <option value=''></option>
            <?php
            for ($i = 10; $i <= 35; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
        ?>
    <option value='99'>Unlimited</option>
    </select>

    <label for="max_event" id="max_event_label">Maximum players on match roster</label>
    <select name='max_match' id='max_match' data-placeholder="Max Players on Match Roster" class="input-large chzn-select required">
        <option value=''></option>
            <?php
            for ($i = 7; $i <= 25; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
        <option value='99'>Unlimited</option>
    </select>

    <br/>
    <br/>

    <input type='submit' name='submit' class='button btn btn-primary' id='add_comp' value='Create Competition'>
</form>

<?php
include_once './footer.php';
