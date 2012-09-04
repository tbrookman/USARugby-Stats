<?php
include_once './include_mini.php';

echo "<table><tr>";
$query = "SELECT * FROM `comps` WHERE hidden=0";

$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    echo "<td><a href='comp.php?id={$row['id']}'>{$row['name']}</a></td>";

    if (editCheck(1)) {
        echo "<td><form style='margin: 0; padding: 0' name='hForm{$row['id']}' id='hForm{$row['id']}'>";
        echo "<input name='hidec{$row['id']}' class='hidec' id='hidec{$row['id']}' type='button' value='Hide' />";
        echo "<input type='hidden' class='hId' name='comp_id' id='comp_id' value='{$row['id']}' />";
        echo "<input type='hidden' name='comprefresh' id='comprefresh' value='comp_list.php' />";

        echo "</form></td>\r";
    }
    echo "</tr>";
}
