<?php
include_once './include_mini.php';

echo "<table class='table table-hover'><tr>";
$query = "SELECT * FROM `comps` WHERE hidden=0";

$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    echo "<td><a href='comp.php?id={$row['id']}'>{$row['name']}</a></td>";

    if (editCheck(1)) {
       echo "<td>";
?>
<div style="float: right;" class="btn-group">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    <i class="icon-cog"></i>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
    <!-- dropdown menu links -->
    <li><a href="comp.php?id=<?php echo $row['id']; ?>"><i class="icon-pencil"></i> Edit</a></li>
    <li><a href="#"><i class="icon-remove"></i> Hide</a></li>
    <li class="divider"></li>
    <li class="nav-header">iframes</li>
    <li><a href="#standingsModal" data-toggle="modal" data-comp-id="<?php echo $row['id']; ?>">Standings</a></li>
    <li><a href="#">Games</a></li>
<?php
//         echo "<form name='hForm{$row['id']}' id='hForm{$row['id']}'>";
//         echo "<input name='hidec{$row['id']}' class='hidec' id='hidec{$row['id']}' type='button' value='Hidesadfaf' />";
//         echo "<input type='hidden' class='hId' name='comp_id' id='comp_id' value='{$row['id']}' />";
//         echo "<input type='hidden' name='comprefresh' id='comprefresh' value='comp_list.php' />";
//         echo "</form>";
?>
  </ul>
</div>
<?php
        echo "</td>\r";
    }
    echo "</tr>";
}

?>

<!-- Modal -->
<div id="standingsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="standingsModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="standingsModalLabel">Modal header</h3>
  </div>
  <div class="modal-body">
    <p>POPULATE MODAL TAG FROM CLICK REF…</p>
    <a href="standings?comp_id=1">Stangings</a>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

