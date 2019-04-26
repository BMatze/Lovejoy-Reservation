<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Reserve Room</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/monthly.css">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/managementHome.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="../img/siueFavicon.png"
	type="image/x-icon">
<link href="../css/addRoom.css" rel="stylesheet" media="screen">
<link href="../css/jquery-ui.min.css" rel="stylesheet" media="screen">
</head>

<body>

	<!-- Beginning of the navigation bar -->
	<nav class="navbar navbar-inverse navbar-static-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#myNavbar">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="http://www.siue.edu/"> <img
					class="siuelogo"
					alt="Southern Illinois University Edwardsville Logo"
					src="../img/logo-siue.png">
				</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a href="../calendar">Calendar</a></li>
					<li class="dropdown"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#">Management <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="../facultyhome">Management Home</a></li>
							<li><a href="../modroom/">Modify Room</a></li>
							<li><a href="../deleteroom/">Delete Room</a></li>
							<li><a href="../daily/">Daily Schedule</a></li>
							<li><a href="../usage/">Download Room Usage</a></li>
						</ul></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="?logout"><span class="glyphicon glyphicon-log-in"></span>
							Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- End navigation bar -->


	<!-- Start of image header, only shows on desktop -->
	<div class="TopGraBG hidden-xs hidden-sm"
		style="background-image: . ./img/library_bckgd.jpg">
		<img class="libimg" alt="Institutional Header" height="135"
			src="../img/Library-Masthead.jpg">
	</div>
	<!-- End of image header, only shows on desktop -->

	<div id='mes'></div>


	<form method=post>
		<div class="form-group col-lg-4">
			<h1>Reservation Details</h1>
		</div>

		<div class="form-group col-lg-4">
			<label for="res_building">Building:</label> <select
				class="form-control" id="res_building" name="res_building" required>
				<option value="" disabled selected>Select Building</option>
<?php
        include_once $_SERVER['DOCUMENT_ROOT']."/db/database.php";
        
        $buildings = db_getBuildings();
        foreach ($buildings as $k => $v) {
            echo '<option value="'.$v.'">'.$v.'</option>
                  ';
        }
?>
        </select>
		</div>

		<div class="form-group col-lg-4">
			<label for="res_num">Room Number:</label> <select
				class="form-control" id="res_num" name="res_num">
				<option value="" disabled selected>Select Room Number</option>
			</select>
		</div>

		<div class="form-group col-lg-4">
			<label for="res_date">Select Date:</label>
			<div id="dateempty" style="width: 250px;">
				<input type="text" id="res_date" class="form-control"
					readonly='true' value="Select Date">
				<div class="monthly" id="mycalendar2"></div>
			</div>
		</div>

		<div class="form-group col-lg-4">
			<label for="res_start">Select Start Time:</label> <select
				class="form-control" id="res_start" name="res_start" required>

			</select>
		</div>

		<div class="form-group col-lg-4">
			<label for="res_end">Select End Time:</label> <select
				class="form-control" id="res_end" name="res_end" required>

			</select>
		</div>
    <?php
    include_once $_SERVER['DOCUMENT_ROOT']."/db/database.php";
    $user = 'bmatzen';
    $facID = db_getFacultyID($user);
    echo '<div class="form-group col-lg-4">
        <label for="res_id">Enter e-ID:</label>
        <input type="text"  id="res_id" class="form-control"' . (($facID == -1) ? " readonly value='$user'" : " placeholder='Enter e-id'") . '>
    </div>';
    ?>
    <div class="form-group col-lg-4">
			<label for="res_desc">Room Description (Read Only):</label>
			<textarea id="res_desc" placeholder="Room Description"
				class="form-control " rows="3" name="res_desc" readonly='true'></textarea>
		</div>


		<div class="form-group col-lg-4">
			<div class="">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</div>

	</form>

	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/monthly.js"></script>
	<script type="text/javascript" src="../js/availTime.js"></script>


	<script>
    //script for date picker
    $( function() {
      $( "#res_date" ).datepicker({ minDate: 0});
    });
    </script>



</body>
</html>

