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
		header( "Location: https://bookworms.isg.siue.edu/reserve/seanTest/facultyhome/" ); die;
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
<title>Student Home</title>
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
      <li><a href="../studentcalendar/">Calendar</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Student
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
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

<!-- Beginning of the error or success message -->
<div id='message' class='' style="visibility: hidden;">
  			<strong id='success'></strong>
</div>
<!-- End of the error or success message -->


<!-- Start main body of page containing links -->
<div class="container">
  <h1>Reservation Management</h1>
  <div class="list-group">
	  <a href="../studentreserve/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>Create Reservation</a>
      <a href="../studentdelete/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>Delete Reservation</a>
  </div>
</div>

<div class="container">
  <h1>Calendar</h1>
  <div class="list-group">
  <a href="../studentcalendar/" class="list-group-item list-group-item-action"><span class="glyphicon glyphicon-stop"></span>View Calendar</a>
  </div>
</div>


<!-- End main body of page containing links -->

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/deleteRoom.js"></script>

</body>
</html>
