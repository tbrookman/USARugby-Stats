<?php
include_once './include_mini.php';

$base_url = $request->getSchemeAndHttpHost();

echo "<table class='table table-hover'><tr>";
$query = "SELECT * FROM `comps` WHERE hidden=0";

$result = mysql_query($query);
while ($row=mysql_fetch_assoc($result)) {
    echo "<td><a href='comp.php?id={$row['id']}'>{$row['name']}</a></td>";

    if (editCheck(1)) {
       echo "<td>";
?>
<div class="btn-group pull-right">
  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
    <i class="icon-cog"></i>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
    <!-- dropdown menu links -->
    <li><a href="comp.php?id=<?php echo $row['id']; ?>"><i class="icon-pencil"></i> Edit</a></li>
    <li><a href='#' class='hidec' id='hComp<?php echo $row['id'];?>' data-hide-comp-id='<?php echo $row['id'];?>'> <i class='icon-remove'></i> Hide</a></li>
    <li class="divider"></li>
    <li class="nav-header">iframes</li>
    <li><a href="#standings-<?php echo $row['id']; ?>-modal" data-toggle="modal" data-comp-id="<?php echo $row['id']; ?>">Standings</a></li>
  </ul>
<?php
        echo "<form style='margin: 0px; padding: 0px;' name='hForm{$row['id']}' id='hForm{$row['id']}'>";
        echo "<input type='hidden' class='hId' name='comp_id' id='comp_id' value='{$row['id']}' />";
        echo "<input type='hidden' name='comprefresh' id='comprefresh' value='comp_list.php' />";
        echo "</form>";
?>
</div>
<?php
        echo "</td>\r";
    }
    echo "</tr>";

    // Modals:
    if (empty($twig)) {
        $loader = new Twig_Loader_Filesystem(__DIR__.'/views');
        $twig = new Twig_Environment($loader, array());
    }

    $standingsiframe = array(
        'entity' => 'standings',
        'eid' => $row['id'],
        'title' => $row['name'] . ' Standings',
        'iframe_url' => $base_url . '/standings?comp_id=' . $row['id'],
    );
    echo $twig->render('modal-template-iframe.twig', array('modal' => $standingsiframe));
}
