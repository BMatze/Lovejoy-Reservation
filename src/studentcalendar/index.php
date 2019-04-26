<?php
/*
// Load the settings from the central config file
require_once '../config.php';
require_once  '../' . $phpcas_path . '/CAS.php';
phpCAS::setDebug();
phpCAS::setVerbose(true);
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setCasServerCACert($cas_server_ca_cert_path);
if (isset($_REQUEST['logout'])) {	
  phpCAS::logoutWithRedirectServiceAndUrl('https://bookworms.isg.siue.edu/reserve/seanTest/', '');
}
 
if (phpCAS::isAuthenticated())
{
	if(phpCAS::getUser() == "test"){
		header( "Location: https://bookworms.isg.siue.edu/reserve/seanTest/calendar/" ); die;
	}
}else{
		phpCAS::forceAuthentication();
}
*/
?>
<!doctype html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset='utf-8'>
<head>
    <title>Student Calendar</title>
    <link rel="stylesheet" href="../css/monthly.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/mngCal.css" rel="stylesheet" media="screen">
    <link href="../css/managementHome.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="../img/siueFavicon.png" type="image/x-icon">
</head>
<body>

<!-- Beginning of the navigation bar -->
<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
     <a class="navbar-brand" href="http://www.siue.edu/">
      <img class="siuelogo" alt="Southern Illinois University Edwardsville Logo" src="../img/logo-siue.png" >
     </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Student
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="../studenthome">Student Home</a></li>
          <li><a href="../studentreserve/">Create Reservation</a></li>
          <li><a href="../studentdelete/">Delete Reservation</a></li>
          </ul>
        </li>
      </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="?logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>   
    </div>
  </div>
</nav>
<!-- End navigation bar -->


<!-- Start of image header, only shows on desktop -->
<div class="TopGraBG hidden-xs hidden-sm" style="background-image:../img/library_bckgd.jpg">
	<img class= "libimg" alt="Institutional Header" height="135" src="../img/Library-Masthead.jpg" >
</div>
<!-- End of image header, only shows on desktop -->

<div class="monthly" id="mngCal"></div>

<?php
   
   $con = mysqli_connect('localhost','s002681','her3ved8', 'test');
   if (!$con) {
     die('Could not connect: ' . mysqli_error($con));
   }

   mysqli_select_db($con,"test");
   //replace sewalte with phpCAS getuser()
   $events="SELECT id, name, startdate, enddate, starttime, endtime, color, url FROM schedule WHERE user='".phpCAS::getUser()."' ORDER BY MONTH(startdate) ASC, DAYOFMONTH(startdate) ASC, HOUR(starttime) ASC";
   
   $result_events = mysqli_query($con,$events);
   $responses = array();
   while($row = mysqli_fetch_array($result_events)) {
     $responses[] = array(  
      'id' => $row['id'],  
      'name' => $row['name'],
      'startdate' => $row['startdate'],  
      'enddate' => $row['enddate'],
      'starttime' => $row['starttime'],  
      'endtime' => $row['endtime'],
      'color' => $row['color'],  
      'url' => $row['url']
     );  
   }
   //echo '{"monthly": ' . json_encode($responses) . '}';
   mysqli_close($con);
?>


<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/monthly.js"></script>
<script type="text/javascript">
var listofevents = <?php echo '{"monthly": ' . json_encode($responses) . '}'; ?>;
	$(window).on('load', function(){
		$('#mngCal').monthly({
			mode: 'event',
			dataType: 'json',
			events: listofevents
		});
	});
</script>
</body></html>