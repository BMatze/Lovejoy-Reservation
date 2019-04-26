<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
$con = db_connect();
$time = mysqli_real_escape_string($con, $_POST['t']);
$date = mysqli_real_escape_string($con, $_POST['d']);
$building = mysqli_real_escape_string($con, $_POST['b']);
$num = mysqli_real_escape_string($con, $_POST['n']);
$eid = mysqli_real_escape_string($con, $_POST['e']);

    $output = "";

    $con = mysqli_connect('localhost','s002681','her3ved8', 'test');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    mysqli_select_db($con,"test"); 

    $desc="SELECT Description FROM room WHERE Building = '". $building ."' AND RoomNumber = '". $number ."'  ORDER BY RoomNumber"; 
    $result_desc = mysqli_query($con,$desc);
    
    while($row = mysqli_fetch_array($result_desc)) {
        $output = $row['Description'];
    }

    echo $output;

    exit();
?>