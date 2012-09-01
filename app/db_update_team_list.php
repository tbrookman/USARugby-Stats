<?php
include_once './include_mini.php';

//echo out a list of all clubs so they don't duplicate
$query = "SELECT * FROM `teams` WHERE 1 ORDER BY name";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    echo "{$row['fsi_id']} - {$row['short']} - {$row['name']}<br/>";
}
