<?PHP 
include 'seekrits.php';

$database = "keezer";
$server = "localhost";

$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {
  if( isset($_POST['calibrate'])) {
	  $cal =  ",Calibrate=1,LastPulses=0"; 
    $url = "http://" . $hostname . "/calibrate.php?kegID=" . $_POST['kegID'];
  }
  else {
    $cal="";
    $url="http://" . $hostname . "/default.php?tab=2";
  }
  
  $kegID = $_POST['kegID'];
  
  $SQL = "UPDATE Keg SET " .
    "KegName='" . str_replace("'","''",$_POST['kegName']) . 
    "', Capacity=" . $_POST['capacityLiters'] . 
    ",CurrentLevel=" . $_POST['currentLevel'] . 
    ",KegSoundNormal='" . str_replace("'","''",$_POST['soundNormal']) . "'" .
    ",KegSoundLow='" . str_replace("'","''",$_POST['soundLow']) . "'" .
    ",KegSoundOut='" . str_replace("'","''",$_POST['soundOut']) . "'" . $cal . " WHERE KegID=" . $kegID;
    
  $result = mysql_query($SQL);
  
  $SQL = "SELECT PID FROM Keg WHERE KegID=" . $kegID;
  $result = mysql_query($SQL);
  $res = mysql_fetch_assoc($result);
  $pid = $res['PID'];
  
  #Send signal to daemon to refresh from DB
$handle = fopen("/var/www/keezerd/pid/" . $pid,'w') or die ('Cannot open file: ' . $pid);

  header( "Location: $url" );
}
?>
