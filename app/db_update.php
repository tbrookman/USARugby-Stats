<?php
include_once ('./header.php');

//verify we can edit.  1 is usarugby only.  Redirect if not?
if(editCheck(1)){

echo "<h1>Update Player Database</h1>";

echo "<p>Please make sure all clubs in the competition are in the database first.</p>";

echo "<p>Choose a CSV file with active players for a competition's clubs to upload. ";
echo "This file can be obtained from multiple advanced searches in CRM.</p>";

echo "The first row in the file will be skipped (column headers).<br/>";
echo "There should be 4 columns in the file.<br/>";
echo "The first column is the player's FSI/USA Rugby member id number.<br/>";
echo "The second column is the player's club's FSI/USA Rugby id number.<br/>";
echo "The third column is the player's first name.<br/>";
echo "The fourth column is the player's last name.<br/><br/>";



?>


<form action="db_update_process.php" method="post" enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submit" value="Update Database" />
</form>

<?php
}
include_once ('./footer.php');
mysql_close();
?>