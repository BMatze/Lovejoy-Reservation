<!DOCTYPE HTML>
<html>
<head>
<meta charset = "UTF-8">
<title>Special Hours</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel = "stylesheet" href = "../css/specialHours.css">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/managementHome.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="../img/siueFavicon.png" type="image/x-icon">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="../js/newConfigs.js"></script>
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
	//All data that needs to be inserted into database(specialHours Table)
	if (isset($_POST['submitButton'])){
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
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
		
		//echo $startTimeInt."<br>";
		//echo $endTimeInt."<br>";
		
		/* $sql = $con->query("INSERT INTO specialhours(start_date,end_date,start_time,end_time)
				VALUES('".$startDate."','".$endDate."','".$startTime."','".$endTime."')");
		if (mysqli_query($con, $sql)) {
			echo "Record updated successfully";
		} else {
			echo "Error updating record: " . mysqli_error($con);
		} */
		//Inserts the dates into a table of special hours
		/* $sql = $con->query("INSERT INTO specialhours(start_date,end_date,start_time,end_time)
				VALUES('".$startDate."','".$endDate."','".$startTime."','".$endTime."')"); */
		
		
		if($endTimeInt >= $startTimeInt){
			$specialHours = $con->query("SELECT * FROM specialhours ORDER BY ID");
			//While there are special hours in the table
			while($row = $specialHours->fetch_assoc()) {
				
				$getStartDate = date("Y-m-d",strtotime($row["start_date"]));
				$getEndDate = date("Y-m-d",strtotime($row["end_date"]));
				$getStartTime = $row["start_time"];
				$getEndTime = $row["end_time"];
				$currDate = date("Y-m-d");
				/* $currDate = "2017-11-19";
				$currDay = date("l",strtotime($currDate));
				$currTimes = $con->query("SELECT start_time,end_time FROM days WHERE day_name = '".$currDay."' ORDER BY id");
				$result = mysqli_fetch_assoc($currTimes);
				$st = $result["start_time"];
				$et=$result["end_time"]; */
				
				/* echo $getStartDate."<br>";
				echo $getEndDate."<br>";
				echo $getStartTime."<br>";
				echo $getEndTime."<br>"; */
				// Testing to see if the hours are set correctly before date range
				//echo "Current Date: ".$currDate."  Curr Start Time: ".$st."  Curr End Time: ".$et."<br>";
				if($currDate == $getStartDate){
					while (strtotime($getStartDate) <= strtotime($getEndDate)) {
						//echo $startDate."<br>";
						$day = date("l",strtotime($getStartDate));
						// Testing to see if are are set within a certain date range
						//echo "Current date: ".$getStartDate."  Start time: ".$getStartTime."  End time: ".$getEndTime."<br>";
						$getStartDate = date ("Y-m-d", strtotime("+1 day", strtotime($getStartDate)));
						//$setTime = $con->query ("UPDATE days SET start_time = '".$getStartTime."', end_time = '".$getEndTime."' WHERE day_name = '".$day."'");
					}
				}
				//Set back to regular times
				$resetToDefaults = $con->query("SELECT * FROM days ORDER BY id");
				while($row = $resetToDefaults->fetch_assoc()){
					$day = $row["day_name"];
					$defaultStartTime = $row["default_start_time"];
					$defaultEndTime = $row["default_end_time"];
					//echo "DAY: ".$day."  Start Time: ".$defaultStartTime."  End Time: ".$defaultEndTime."<br>";
					//$setTime = $con->query ("UPDATE days SET start_time = '".$defaultStartTime."', end_time = '".$defaultEndTime."' WHERE day_name = '".$day."'");
				}
				//Test if hours are reset back to regular hours
				//echo "Current Date: ".$currDate."  Curr Start Time: ".$st."  Curr End Time: ".$et."<br>";
			}
			$success = "Successfuly added special hours";
			echo "<script type='text/javascript'>
			alert('$success');
			</script>";
		}else{
			$error = "Time(s) selected invalid.";
			echo "<script type='text/javascript'>
			alert('$error');
			</script>";
		}
		
		/* //While within the date range
		while (strtotime($startDate) <= strtotime($endDate)) {
			echo $startDate."<br>";
			$day = date("l",strtotime($startDate));
			echo $day."<br>";
			$startDate = date ("Y-m-d", strtotime("+1 day", strtotime($startDate)));
			$setTime = $con->query ("UPDATE days SET start_time = '".$startTime."', end_time = '".$endTime."' WHERE day_name = '".$day."'");
		} */
		//Current Day
		/* $currDay = date("Y-m-d");
		echo $currDay; */
	}
	/* $sql = $con->query("SELECT day_name FROM days where id = 1 ORDER BY id");
	$result = mysqli_fetch_assoc($sql);
	$a = $result["day_name"];
	echo $a; */
?>
<div class ="container1">
	<form id = "postForm" method = "post">
		<h1>Welcome</h1>
		<p>Select start date: <input type = "text" id = "startDate" name = "startDate"></p>
		<p>Select end date: <input type = "text" id = "endDate" name = "endDate"></p>
		<!-- <p id = "currentHours">Current Hours: </p> -->
		<p>Select start time: 
			<select id = "startHours" name = "startHours"></select>
			:
			<select id = "startMinutes" name = "startMinutes"></select>
			<select id = "startAmpm" name = "startAmpm">
			<option>AM</option>
			<option>PM</option>
			</select>
		</p>
		<p>Select end time: 
			<select id = "endHours" name = "endHours"></select>
			:
			<select id = "endMinutes" name = "endMinutes"></select>
			<select id = "endAmpm" name = "endAmpm">
			<option>AM</option>
			<option>PM</option>
			</select>
		</p>
		<button type = "Submit" id = "submitButton" name = "submitButton">Insert</button>
		<div id = "result"></div>
	</form>
	
	<a href = "../facultyhome"><button id = "homeButton">Return To Home Page</button></a>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>

</html>

