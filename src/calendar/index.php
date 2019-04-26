<?php
// needed to allow php cas for remove event
// Load the settings
// from the central config file
require_once $_SERVER['DOCUMENT_ROOT'] . '/reserve/cas/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/reserve/cas/' . $phpcas_path . '/CAS.php';
phpCAS::setDebug();
phpCAS::setVerbose(true);
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setCasServerCACert($cas_server_ca_cert_path);
phpCAS::forceAuthentication();
$_SESSION['username'] = phpCAS::getUser();
?><!doctype html>

<html lang="en">
<meta name="viewport"
	content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta charset='utf-8'>
<head>
<title>Event Calendar</title>
<link rel="stylesheet" href="../css/monthly.css">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/mngCal.css" rel="stylesheet" media="screen">
<link href="../css/managementHome.css" rel="stylesheet" media="screen">
<link rel="shortcut icon" href="../img/siueFavicon.png"
	type="image/x-icon">
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
					<li class="dropdown"><a class="dropdown-toggle"
						data-toggle="dropdown" href="#">Management <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="../facultyhome">Management Home</a></li>
							<li><a href="../addroom/">Add Room</a></li>
							<li><a href="../modroom/">Modify Room</a></li>
							<li><a href="../deleteroom/">Delete Room</a></li>
							<li><a href="../daily/">Daily Schedule</a></li>
							<li><a href="../usage/">Download Room Usage</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="../facultyreserve/">Add Student Reservation</a></li>
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
	<!-- Modal for Confirm deletion -->
	<div id="confirm-modal">
		<label>Location:</label><span id='name'></span><br /> <label>Date:</label><span
			id='start-date'></span><br /> <label>Time:</label><span
			id='start-time'></span> - <span id='end-time'></span> <br />
		<p>Are you sure you wish to cancel this reservation&#63;</p>
		<Button id='confirmRemoveBtn'>Yes</Button>
		<Button id='cancelRemoveBtn'>No</Button>
	</div>
	<!--  End of Confirm deletion modal -->
	<div class="monthly" id="mngCal"></div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
$con = db_connect();
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
$events = "SELECT id, user,building,roomnumber, startdate, enddate, starttime, endtime, color, url FROM schedule ORDER BY MONTH(startdate) ASC, DAYOFMONTH(startdate) ASC, HOUR(starttime) ASC";
session_start();
$user = $_SESSION['username'];
$faculty = db_getFacultyID($user) != - 1;
$result_events = mysqli_query($con, $events);
$responses = array();
while ($row = mysqli_fetch_array($result_events)) {
    
    $name = ($faculty ? "(" . $row['user'] . ") " : "") . $row['roomnumber'] . " " . $row['building'];
    $responses[] = array(
        'id' => $row['id'],
        'name' => $name,
        'startdate' => $row['startdate'],
        'enddate' => $row['enddate'],
        'starttime' => $row['starttime'],
        'endtime' => $row['endtime'],
        'color' => $row['color'],
        'url' => $row['url']
    );
}
// echo '{"monthly": ' . json_encode($responses) . '}';
mysqli_close($con);
?>


<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/monthly.js"></script>
	<script type="text/javascript">
var listofevents = <?php echo '{"monthly": ' . json_encode($responses) . '}'; ?>;
	$(window).on('load', function(){
		$('#mngCal').monthly({
			mode: 'event',
			dataType: 'json',
			events: listofevents
		});
	});
	session_start();
	var faculty = <?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
$name = $_SESSION['username'];
$facID = db_getFacultyID($name);
echo ($facID != - 1) ? "true" : "false";
?>;
</script>
	<script type="text/javascript" src="../js/roomControl.js"></script>
</body>
</html>