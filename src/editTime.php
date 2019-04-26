<!DOCTYPE HTML>
<html>
<head>
<meta charset = "UTF-8">
<title>Config Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/managementHome.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="../img/siueFavicon.png" type="image/x-icon">
<link rel = "stylesheet" href = "../css/editTime.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="../js/editTime.js"></script>
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
	$selectedDay = "";
	
	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	mysqli_select_db($con,"bookworms");
	$q = $con->query("SELECT * FROM days ORDER BY id");
	while($array[] = $q->fetch_object());
	array_pop($array);
	
	$selectedDay = $_POST['dayNames'];
	//echo "You've selected " .$selectedDay."<br>";
	
	$dayName = $con->query("SELECT default_start_time,default_end_time FROM days WHERE day_name = \"".$selectedDay."\"");
	$result = mysqli_fetch_assoc($dayName);
	$currStartTime = $result["default_start_time"];
	$currEndTime = $result["default_end_time"];
	//echo "Current Hours: ".$currStartTime." to ".$currEndTime."<br>";
	if (isset($_POST['submitButton'])){
		$daySelected = $_POST['dayNames'];
		$startTime = $_POST['startHours'].":".$_POST['startMinutes']. " ".$_POST['startAmpm'];
		$endTime = $_POST['endHours'].":".$_POST['endMinutes']. " ".$_POST['endAmpm'];
		
		//Convert times to military and compare for validation
		$startTimeConversion = date("H:i",strtotime($startTime));
		$endTimeConversion = date("H:i",strtotime($endTime));
		
		$startTimeHour = date("H",strtotime($startTimeConversion));
		$startTimeMinutes = date("i",strtotime($startTimeConversion));
		$startTimeInt = intval($startTimeHour.$startTimeMinutes);
		
		$endTimeHour = date("H",strtotime($endTimeConversion));
		$endTimeMinutes = date("i",strtotime($endTimeConversion));
		$endTimeInt = intval($endTimeHour.$endTimeMinutes);
		
		
			
		if($endTimeInt >= $startTimeInt){
			$sql = $con->query("UPDATE days SET default_start_time = '".$startTime."', default_end_time = '".$endTime."' WHERE day_name = '".$selectedDay."'");
			//Alert and redirect
			$success = "Regular hours have been set successfully.";
			echo "<script type='text/javascript'>
			alert('$success');
			window.location.href = 'http://localhost/Final/html/reserve/facultyconfigs/selectDayToEdit.php';
			</script>";
		}else{
			$error = "Please select a valid time range.";
			echo "<script type='text/javascript'>
			alert('$error');
			</script>";
		}
		//header('Location: http://localhost/phpLessons/php/selectDayToEdit.php');
	}
	
	
	
	#Successfully Updates Time, just have to get order right.
	#echo "New Start Time: ".$newStartTime."<br>";
	#echo "New End Time: ".$newEndTime."<br>";
	
?>

<div class = "container1">
	<h1><?php echo $selectedDay?></h1>
	<p id = "currLabel" class = "time"><?php echo "Current Hours: ".$currStartTime." to ".$currEndTime."<br>"?></p>
	<form action="#" method = "post">
		<p style = "display:none">
		<select name = "dayNames">
		<option><?php echo $selectedDay ?>
		</select>
		</p>
		
	<p class = "time">Select a start time: 
		<select id = "startHours" name = "startHours"></select>
		:
		<select id = "startMinutes" name = "startMinutes"></select>
		<select id = "startAmpm" name = "startAmpm">
		<option>AM</option>
		<option>PM</option>
		</select>
	</p>
	<p class = "time">Select a end time: 
		<select id = "endHours" name = "endHours"></select>
		:
		<select id = "endMinutes" name = "endMinutes"></select>
		<select id = "endAmpm" name = "endAmpm">
		<option>AM</option>
		<option>PM</option>
		</select>
	</p>
		
		<button type = "Submit" name = "submitButton" onclick = "submit">Submit</button>
		<!--  <input type = "submit" name = "submitButton" value = "Submit" onclick = "window.location.href = 'http://localhost/phpLessons/php/selectDayToEdit.php'"> -->
		<!--  <button name = "saveButton">Save</button>-->
	</form>
	<a id = "return" href = "../facultyconfigs/selectDayToEdit.php"><button>Cancel</button></a>
</div>


<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
