<?php
include_once './include.php';

echo "<h1>User Management</h1>\n";


echo "<h2>Current Users</h2>";
echo "<div id='users'>";
include_once './users_list.php';
echo "</div>";

echo "<h1>Add a User</h1>\n";
echo "<div id='useradd'>";
include_once './add_user.php';
echo "</div>";

echo "<h2>Update Users</h2>";
echo "<div id='users_update'>";
?>
<form action="db_update_users_process.php" method="post" enctype="multipart/form-data">
<input type="submit" name="submit" value="Sync Users" />
</form>
<?php
echo "</div>";

include_once './footer.php';
