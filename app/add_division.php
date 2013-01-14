<?php
include_once './header.php';

$id = $request->get('id');
$title = 'Manage divisions';

$name = $request->get('name');
if (!empty($id) && !empty($name)) {
    $id = mysql_escape_string($id);
    $name = mysql_escape_string($name);
    $query = "INSERT INTO divisions (id, comp_id, name) VALUES ('', $id, '$name')";
    $result = mysql_query($query);
}

$divisionid = $request->get('deldivision');
if (!empty($id) && !empty($divisionid)) {
    $divisionid = mysql_escape_string($divisionid);
    $query = "DELETE FROM divisions WHERE id = $divisionid";
    $result = mysql_query($query);
}

?>

<h1><?php echo $title; ?></h1>
<?php

// $db->getDivisions($compid);
//$query = "SELECT d.* FROM divisions d JOIN ct_pairs ctp ON ctp.division_id=d.id WHERE ctp.comp_id = $id";
$query = "SELECT d.* FROM divisions d WHERE d.comp_id = $id";
$result = mysql_query($query);
if ($result) {
    echo "<table class='table'><tr><td><strong>Division</strong></td><td></td></tr><tr>";
    while ($row=mysql_fetch_assoc($result)) {
        echo "<td>{$row['name']}</td>";
        if (editCheck(1)) {
            echo "<td><form name='deldivision' id='deldivision' method='POST' action='add_division.php?id=$id'>";
            echo "<input id='id' name='id' type='hidden' value='$id' />";
            echo "<input id='deldivision' name='deldivision' type='hidden' value='{$row['id']}' />";
            echo "<input type='submit' name='submit' class='btn btn-danger' value='Delete' />";
            echo "</form></td>\r";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>

<form name='adddivision' id='adddivision' method='POST' action='add_division.php?id=<?php echo $id;?>'>
    <input id='id' name='id' type='hidden' value='<?php echo $id; ?>'>
    <input id='name' name='name' type='text' size='30' placeholder="Division Name" class="required input-large">
    <br />
    <input type='submit' name='submit' class='button btn btn-small btn-primary' id='add_division' value='Add'>
</form>

<?php
include_once './footer.php';
