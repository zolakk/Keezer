<html>
  <head>
	<?php 
		$agent = $_SERVER['HTTP_USER_AGENT'];
    
		if (ereg("(iPhone|BlackBerry|PalmSource)", $agent) != false) {
			print"<meta name=\"viewport\" content=\"width = device-width\">";
		}        
		else {
		   print "<!-- not mobile -->";
		}
	?>  
    <title></title>
    <link rel="stylesheet" href="main.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="easyui/themes/metro/easyui.css"/>
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css"/>
    <script type="text/javascript" src="easyui/jquery.min.js"></script>
    <script type="text/javascript" src="easyui/jquery.easyui.min.js"></script>
	<script type="text/javascript"> 
		function selectTab(){
          $('#tt').tabs('select',<?PHP
			if( isset($_GET['tab'])) {
				print $_GET['tab'];
			}
			else 
			{
				print "0";
			}
		   ?>);
	  }
	</script>
  </head>
  <body OnLoad="selectTab()">
   <?PHP
include 'pidTools.php';
?>
<div id="tt" class="easyui-tabs" style="height:640px;width:400px">
    <div title="Summary" style="padding:20px;">
      <?php
      include 'kegSummary.php';
      ?>
    </div>
    <div title="Details" style="padding:20px;">
      <?php
      include 'kegDetails.php';
      ?>
    </div>
    <div title="Admin" style="padding:20px;">
         <?php
      include 'kegAdmin.php';
      ?>
    </div>
</div>
</body>
</html>
