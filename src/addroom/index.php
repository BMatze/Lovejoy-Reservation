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
<title>Add Room</title>
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

<div id='message' class='' style="visibility: hidden;">
  			<strong id='success'></strong>
</div>

<form method=post  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" >
	   <div class="form-group col-lg-4">
		  <h1>Room Details</h1>
	  </div>
	
	  <div class="form-group col-lg-4">
		  <label for="room_building">Building:</label>
		  <select class="form-control" id="room_building" name="room_building" required>
		    <option value="" disabled selected>Select Building</option>
		    <option>Lovejoy</option>
		    <option>Engineering</option>
		  </select>
	  </div>
    
      <div class="form-group col-lg-4">
  		<label for="room_number">Room Number:</label>
  		<input placeholder="Room Number" type="text" class="form-control" name="room_number" id="room_number" required>
	  </div>
    
      <div class="form-group col-lg-4">
		  <label for="room_number">Floor Number:</label>
		  <select class="form-control" id="room_number" name="floor_number" required>
		  	<option value="" disabled selected>Select Floor Number</option>
		    <option>0</option>
		    <option>1</option>
		    <option>2</option>
		    <option>3</option>
		  </select>
	  </div>
	  
	  <div class="form-group col-lg-4">
  		<label for="room_descriptio">Room Description:</label>
  		<textarea placeholder="Room Description" class="form-control " rows="5" id="room_description" name="room_description" required></textarea>
	  </div>
	  
	  <div class="form-group col-lg-4"> 
	    <div class="">
	      <button type="submit" class="btn btn-default">Submit</button>
	    </div>
  	  </div>
	  
</form>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/addRoom.js"></script>

</body>
</html>

<?php 
//Ensures that the room_building variable is not empty before doing anything
if(!empty($_POST["room_building"])){

//Makes sure that the method of sending data is POST	
if ($_POST){ 

//Takes the data from the form and saves it to the various 	
$building = $_POST['room_building'];
$number = $_POST['room_number'];
$floor = $_POST['floor_number'];
$description = $_POST['room_description'];

//DB connection
$conn = mysqli_connect('localhost','s002681','her3ved8', 'test');
if (!$conn) {
	die('Could not connect: ' . mysqli_error($conn));
}

//Connecting to DB bookworsms
mysqli_select_db($conn,"test");

//Queries DB to see if the room is already in the DB, if it is error message is sent
$query = mysqli_query($conn, "SELECT RoomNumber, Building FROM room WHERE Building='".$building."' AND RoomNumber= '".$number."'");

if(mysqli_num_rows($query) > 0){
	echo '<script type="text/javascript">',
		 'messageError();',
	     '</script>'
	;
}

//If the room is not already in the DB then it is inserted in 
//Success message is displayed
else{
    $sql = "INSERT INTO room(RoomNumber, Building, Floor, Description)
		VALUES ('$number', '$building', '$floor', '$description')";
		
		if (mysqli_query($conn, $sql)) {
			echo '<script type="text/javascript">',
			'messageSuccess();',
			'</script>'
      		;
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
		//Close DB connnection
		mysqli_close($conn);		
}
}
}
?>
