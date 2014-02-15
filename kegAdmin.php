
<?PHP
include 'seekrits.php';

function find_all_files($dir) 
{ 
    $root = scandir($dir); 
    foreach($root as $value) 
    { 
        if($value === '.' || $value === '..') {continue;} 
        if(is_file("$dir/$value")) {$result[]="$dir/$value";continue;} 
        foreach(find_all_files("$dir/$value") as $value) 
        { 
            $result[]=str_replace("$dir/","",$value); 
        } 
    } 
    return $result; 
} 

$database = "keezer";
$server = "localhost";

$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {

$files = find_all_files('/var/www/sound');

$SQL = "SELECT * FROM Keg ORDER BY KegID";
$result = mysql_query($SQL);
print "<div class='CSSTableGenerator'>";
print "<table>";
while ( $db_field = mysql_fetch_assoc($result) ) {
    print "<form action='action.php' method='post'>";
    print "<tr><th colspan='2'>Keg #" . $db_field['KegID'] . "<input type='hidden' name='kegID' value='" . $db_field['KegID'] . "'/> (<input type='text' name='kegName' value='" . $db_field['KegName'] . "'/>)</th></tr>";
    print "<tr><td>Capacity (Liters)</td><td><input type='text' name='capacityLiters' value='" . $db_field['Capacity'] . "'/></td></tr>";
    print "<tr><td>Current Level (Liters)</td><td><input type='text' name='currentLevel' value='" . $db_field['CurrentLevel'] . "'/></td></tr>";
  
    print "<tr><td>Sound Normal</td><td>";
    print "<select name='soundNormal'>";
    foreach ($files as $value) {
	if ($db_field['KegSoundNormal'] == $value)
	{
	    print "<option value='" . $value . "' selected>". $value . "</option>";
	}
	else
        {
	   	print "<option value='" . $value . "'>". $value . "</option>";
        }
    }
    print "</select>";
    print "</td></tr>";
    print "<tr><td>Sound Low</td><td>";
  
    print "<select name='soundLow'>";
    foreach ($files as $value) {
	if ($db_field['KegSoundLow'] == $value)
	{
	    print "<option value='" . $value . "' selected>". $value . "</option>";
	}
	else
	{
	    print "<option value='" . $value . "'>". $value . "</option>";
	}
    }
    print "</select>";
  
    print "</td></tr>";
    print "<tr><td>Sound Out</td><td>";
  
    print "<select name='soundOut'>";
    foreach ($files as $value) {
	if ($db_field['KegSoundOut'] == $value)
	{
	    print "<option value='" . $value . "' selected>". $value . "</option>";
	}
	else
	{
	    print "<option value='" . $value . "'>". $value . "</option>";
	}
    }
    print "</select>";
  
    print "</td></tr>";
    print "<tr><td colspan='2'><input type='submit' /></td>";
    print "<tr><td colspan='2'><a href='http://" . $hostname . "/keezerd/log/keezer" . $db_field['KegID'] . ".log'>Log file</a></td></tr>";
    print "<tr><td colspan='2'>Status: ";
    if (isPidRunning($db_field['PID']))
{
	print "<b>RUNNING</b>";
}
	else
{
	print "<b>NOT RUNNING</b>";
}
    print "</td></tr>";
    print "</form>";  
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