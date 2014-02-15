
<?PHP
include 'seekrits.php';
$database = "keezer";
$server = "localhost";

$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {

$SQL = "SELECT * FROM Keg ORDER BY KegID";
$result = mysql_query($SQL);
print "<div class='CSSTableGenerator'>";
print "<table>";
while ( $db_field = mysql_fetch_assoc($result) ) {
	print "<tr><th colspan='2'>Keg #" . $db_field['KegID'] . " (" . $db_field['KegName'] . ")</th></tr>";
	print "<tr><td>Capacity (Liters)</td><td>" . $db_field['Capacity'] . "</td></tr>";
	print "<tr><td>Current Level (Liters)</td><td>" . $db_field['CurrentLevel'] . "</td></tr>";
	print "<tr><td>Sound Normal</td><td><a href='http://" . $hostname . "/keezer/sound/" . $db_field['KegSoundNormal'] . "'>" . $db_field['KegSoundNormal'] . "</a></td></tr>";
	print "<tr><td>Sound Low</td><td><a href='http://" . $hostname . "/keezer/sound/" . $db_field['KegSoundLow'] . "'>" . $db_field['KegSoundLow'] . "</a></td></tr>";
	print "<tr><td>Sound Out</td><td><a href='http://" . $hostname . "/keezer/sound/" . $db_field['KegSoundOut'] . "'>" . $db_field['KegSoundOut'] . "</a></td></tr>";
}
print "</table>";
print "</div>";
mysql_close($db_handle);

}
else {

print "Database NOT Found ";
mysql_close($db_handle);

}

?>