<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
$con = db_connect();
date_default_timezone_set('America/Chicago');
$date = mysqli_real_escape_string($con, $_POST['date']);
$building = mysqli_real_escape_string($con, $_POST['build']);
$roomNum = mysqli_real_escape_string($con, $_POST['rnum']);
    $date = date('Y-n-j', strtotime($date));
    $startHour = 0;
    $testdate = date('Y-n-j');
    $currdate = date('Y-n-j', strtotime($testdate));
    if ($currdate == $date){
        $startHour = date('G',strtotime('+1 hour'));
    }
    else {
        $startHour = 8;
    }

    $array1 = array();
    $avail = array();
    
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $avail_time="SELECT removedstart FROM schedule WHERE startdate = '". $date ."' AND Building = '". $building ."' AND RoomNumber = '". $roomNum ."'"; 
    $result_time = mysqli_query($con,$avail_time);
    
    while($row = mysqli_fetch_array($result_time)) {
        $output = $row['removedstart'];
        array_push($array1, $output);
    }
    $array1 = implode(",", $array1);
    $array1 = explode(",", $array1);
    for($i = $startHour; $i < 23; $i++){
        if(!in_array(($i . ":00"), $array1)){
            array_push($avail, "<option value='". $i ."'>" . date('g:i a', strtotime($i . ':00')) . "</option>");
        }
    }

    echo json_encode($avail);
    //echo date('Y-n-j', strtotime($testdate));
    //echo $startHour;

    exit();
?>