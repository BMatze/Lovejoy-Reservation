<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>View Special Hours</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "../css/viewSpecialHours.css">
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
          <li><a href="../reserveroom/">Add Student Reservation</a></li>

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

 <table>
  <tr>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Start Time</th>
  	<th>End Time</th>
  </tr>
  <?php
	include_once $_SERVER['DOCUMENT_ROOT']."Final/html/reserve/php/db/database.php";
	date_default_timezone_set('America/Chicago');
	//$con = mysqli_connect("localhost","root", "iceman45");
	$con = db_connect();
	
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	mysqli_select_db($con,"bookworms");
	
	$specialHours = $con->query("SELECT * FROM specialhours ORDER BY ID");
	while ($row = $specialHours->fetch_assoc()){
		$startDate = $row["start_date"];
		$startDateFormat = date("m-d-Y",strtotime($startDate));
		$endDate = $row["end_date"];
		$endDateFormat = date("m-d-Y",strtotime($endDate));
		$startTime = $row["start_time"];
		$endTime = $row["end_time"];
		echo "<tr><td>".$startDateFormat."</td><td>".$endDateFormat."</td><td>".$startTime."</td><td>".$endTime."</td></tr>";
	}
	
  ?>
</table> 
<div id = "container">
	<a href = "../facultyhome"><button id = "return">Return To Home Page</button></a>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>