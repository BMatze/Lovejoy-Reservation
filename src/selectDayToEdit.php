<!DOCTYPE html>
<html>
<head>
	<meta charset = "UTF-8">
	<title>Select Day To Edit</title>
	<link rel="stylesheet" href = "../css/selectDayToEdit.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="../css/managementHome.css" rel="stylesheet" media="screen">
	<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="shortcut icon" href="../img/siueFavicon.png" type="image/x-icon">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
	$q = $con->query("SELECT * FROM days ORDER BY id");
	while($array[] = $q->fetch_object());
	array_pop($array);
?>
<div class = "container1">
	<form action="http://localhost/Final/html/reserve/facultyconfigs/editTime.php" method = "post">
	
		<p>Edit regular hours for: 
			<select name = "dayNames">
				<?php foreach($array as $option):?>
					<option value = "<?php echo $option->day_name; ?>"><?php echo $option->day_name;?></option>
				<?php endforeach;?>
			</select>
		</p>
		<input name = "editButton" type="submit" value="Edit" onclick="window.location.href='http://localhost/Final/html/reserve/facultyconfigs/editTime.php'" />
	
	</form>
	<a href = "../facultyhome"><button>Return To Home Page</button></a>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>

</html>
