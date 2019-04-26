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
		header( "Location: https://bookworms.isg.siue.edu/reserve/seanTest/deleteroom/" ); die;
	}
}else{
		phpCAS::forceAuthentication();
}
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Delete Reservation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet">  
    <link href="../css/managementHome.css" rel="stylesheet">
    <link rel="shortcut icon" href="../img/siueFavicon.png" type="image/x-icon">  
    <link href="../css/dailySchedule.css" rel="stylesheet">   
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
		<li><a href="../studentcalendar">Calendar</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Student
				<span class="caret"></span></a>
				<ul class="dropdown-menu">
                <li><a href="../studenthome">Student Home</a></li>
				<li><a href="../studentreserve/">Create Reservation</a></li>
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

<!-- Beginning of the table for the students reservations -->
<div class="container">
  <h1>Delete Reservation</h1>     

    <!-- <div class="form-group">
    <label for="months">Select Month:</label>
    <select class="form-control" id="months">
        <option selected disabled>Select Month</option>  
        <option>January</option>
        <option>February</option>
        <option>March</option>
        <option>April</option>
        <option>May</option>
        <option>June</option>
        <option>July</option>
        <option>August</option>
        <option>September</option>
        <option>October</option>
        <option>November</option>
        <option>December</option>
    </select>
    </div> -->
  <h2 id="Month"></h2>
  <table id="reservations" class="table table-bordered">
    <thead>
      <tr>
        <th class="tableLabel">Building</th>
        <th class="tableLabel">Room</th>
        <th class="tableLabel">Start</th>
        <th class="tableLabel">End</th>
        <th class="tableLabel">Date</th>
        <th class="tableLabel">Remove</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>
<!-- End table for students schedule -->

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/month.js"></script>
<script>
    $.ajax({
      method: "POST",
      url: "getReservations.php",
      success: function(response) {
        response = JSON.parse(response)
        if(response != ''){
          for (i = 0; i < response.length; i++) { 
            console.log(response[i])
            $("#reservations").append(response[i])
          }
        }
        else {
          $("#reservations").append("<tr><td>Nothing</td><td>Scheduled</td><td>Today</td><td>N/A</td><td>N/A</tr>")
        }
      }
    })

</script>

</body>
</html>