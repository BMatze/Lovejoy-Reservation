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
	if(phpCAS::getUser() != "test"){
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
<title>Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	  <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
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
      <li><a href="../calendar/">Calendar</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Management
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="../addroom/">Add Room</a></li>
          <li><a href="../modroom/">Modify Room</a></li>
          <li><a href="../deleteroom/">Delete Room</a></li>
          <li><a href="../daily/">Daily Schedule</a></li>
          <li><a href="../usage/">Download Room Usage</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="../facultyreserve/">Add Student Reservation</a></li>

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

<!-- Beginning of the error or success message -->
<div id='message' class='' style="visibility: hidden;">
  			<strong id='success'></strong>
</div>
<!-- End of the error or success message -->


<!-- Start main body of page containing links -->
<div class="container">
  <h1>Room Management</h1>
  
  <div class="list-group">
	  <a href="../addroom/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>  Add a Room to the System</a>
	  <a href="../modroom/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>  Modify a Room</a>
	  <a href="../deleteroom/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>  Delete a Room</a>
	  <a href="../daily/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span> Daily Schedule</a>
	  <a id="usage" href="../usage/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>  Download Room Usage Information</a>
    
  </div>
  
  
</div>

<div class="container">
  <h1>Reservation Management</h1>
  
  <div class="list-group">
	  <a href="../facultyreserve/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>  Add a Student Reservation</a>
  </div>
  
  
</div>
<!-- End main body of page containing links -->

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/deleteRoom.js"></script>

</body>
</html>
