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
	if(phpCAS::getUser() != "sewalte"){
		header( "Location: https://bookworms.isg.siue.edu/reserve/seanTest/studenthome/" ); die;
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
<title>Delete Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">	
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">  
    <link href="../css/managementHome.css" rel="stylesheet" media="screen">
    <link rel="shortcut icon" href="../img/siueFavicon.png" type="image/x-icon">
    <link href="../css/addRoom.css" rel="stylesheet" media="screen">  
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
		<li><a href="../calendar">Calendar</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Management
				<span class="caret"></span></a>
				<ul class="dropdown-menu">
				<li><a href="../facultyhome">Management Home</a></li>
				<li><a href="../addroom/">Add Room</a></li>
				<li><a href="../modroom/">Modify Room</a></li>
				<li><a href="../daily/">Daily Schedule</a></li>
				<li><a href="../usage/">Download Room Usage</a></li>
				<li role="separator" class="divider"></li>
				<li><a href="../facultyreserve/">Add Student Reservation</a></li>
				</ul>
			</li>
		</ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="http://www.siue.edu/lovejoylibrary/"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
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

<div id="mes">

</div>

<form  method="post" id="delteroomFrom">
	   <div class="form-group col-lg-4">
		  <h1>Choose Room To Delete</h1>
	  </div>
	
	  <div class="form-group col-lg-4">
		  <label for="room_building">Building:</label>
		  <select class="form-control" id="room_building" name="room_building" required>
		    <option value="" disabled selected>Select Building</option>
		    <option value="Lovejoy">Lovejoy Library</option>
		    <option value="Engineering">Engineering Building</option>
		  </select>
	  </div>
	  
	  <div class="form-group col-lg-4">
		  <label for="room_number">Room Number:</label>
		  <select class="form-control" id="room_number" name="room_number" required>
		    <option value="" disabled selected>Select Room Number</option>
		  </select>
	  </div>
	  
	  <div class="form-group col-lg-4"> 
	    <div class="">
	      <button type="submit" class="btn btn-default">Delete</button>
	    </div>
  	  </div>
	  
</form>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/facdelete.js"></script>


</body>
</html>