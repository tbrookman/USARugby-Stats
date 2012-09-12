<?php
include_once './include_mini.php';

if (!isset($game_id) || !$game_id) {$game_id=$_GET['id'];}

echo "<h2>Acceptance of Results</h2>";

echo "<form id='signform' name='signform' method='POST' action='' />";
echo "<table class='table'>";

$query = "SELECT ref_sign,4_sign,away_sign,home_sign FROM `games` WHERE id = $game_id";
$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {

    if ($row['ref_sign']==1) {$checked='checked';} else {$checked='';}
    echo "<tr><td>Ref Signature: ".sign($row['ref_sign'])."</td>\r";
    echo "<td><input type='checkbox' id='ref' name='ref' class='signbox' value='1' $checked/></td></tr>";

    if ($row['4_sign']==1) {$checked='checked';} else {$checked='';}
    echo "<tr><td>#4 Signature: ".sign($row['4_sign'])."</td>\r";
    echo "<td><input type='checkbox' id='num4' name='num4' class='signbox' value='1' $checked/></td></tr>";

    if ($row['home_sign']==1) {$checked='checked';} else {$checked='';}
    echo "<tr><td>Home Coach Signature: ".sign($row['home_sign'])."</td>\r";
    echo "<td><input type='checkbox' id='homec' name='homec' class='signbox' value='1' $checked/></td></tr>";

    if ($row['away_sign']==1) {$checked='checked';} else {$checked='';}
    echo "<tr><td>Away Coach Signature: ".sign($row['away_sign'])."</td>\r";
    echo "<td><input type='checkbox' id='awayc' name='awayc' class='signbox' value='1' $checked/></td></tr>";

}

echo "<input type='hidden' id='srefresh' name='srefresh' value='signatures.php?id=$game_id' />";
echo "<input type='hidden' id='game_id' name='game_id' value='$game_id' />";
echo "</table>";
echo "</form>";
