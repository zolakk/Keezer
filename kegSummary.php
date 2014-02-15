<?PHP
include 'seekrits.php';

$database = "keezer";
$server = "localhost";

$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {

$SQL = "SELECT KegID, KegName, Enabled, CurrentLevel, Capacity, PID FROM Keg ORDER BY KegID";
$result = mysql_query($SQL);
?>
<div class="CSSTableGenerator">
<table>
<tr>
<td>Keg #</td>
<td>Keg Name</td>
<td>Capacity</td>
</tr>
 <?php
while ( $db_field = mysql_fetch_assoc($result) ) {
	print "<tr>";
  print "<td>" . $db_field['KegID'] . "</td>";
 if (isPidRunning($db_field['PID']))
{
	print "<td>" . $db_field['KegName'] . "</td>";
}
else
{
	print "<td><font color='red'>" . $db_field['KegName'] . "</font></td>";
}
  print "<td><div id='p' class='easyui-progressbar' data-options='value:" . round(($db_field['CurrentLevel'] / $db_field['Capacity']) * 100) . "' style='width:200px;'></div></td>";
	print "</tr>";
}
?>
</table>
</div>
<?php
mysql_close($db_handle);

}
else {

print "Database NOT Found ";
mysql_close($db_handle);

}

?>