<?php 
require_once 'config.example.php';
require_once $phpcas_path . '/CAS.php';

phpCAS::setDebug();
phpCAS::setVerbose(true);
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setCasServerCACert($cas_server_ca_cert_path);
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}

phpCAS::checkAuthentication();
require_once 'dbConnect.php';
$con = connect('test2');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
    $time = $_POST['t'];
    $date = $_POST['date'];
    $building = $_POST['build'];
    $roomNum = $_POST['rnum'];
    //$time = date("H:i", strtotime($time));
    $date = date('Y-n-j', strtotime($date));

    $array1 = array();
    $avail = array();
    

    $avail_time="SELECT removedend FROM schedule WHERE startdate = '". $date ."' AND Building = '". $building ."' AND RoomNumber = '". $roomNum ."'"; 
    $result_time = mysqli_query($con,$avail_time);
    
    while($row = mysqli_fetch_array($result_time)) {
        $output = $row['removedend'];
        array_push($array1, $output);
    }
    $array1 = implode(",", $array1);
    $array1 = explode(",", $array1);

    if(!in_array(($time + 1 . ":00"), $array1)){
        array_push($avail, "<option value='". ($time + 1) ."'>" . date('g:i a', strtotime($time + 1 . ':00')) . "</option>");
    }
    if(!in_array(($time + 2 . ":00"), $array1)){
        array_push($avail, "<option value='". ($time + 2) ."'>" . date('g:i a', strtotime($time + 2 . ':00')) . "</option>");
    }
    if(!in_array(($time + 3 . ":00"), $array1) && !in_array(($time + 2 . ":00"), $array1)){
        array_push($avail, "<option value='". ($time + 3) ."'>" . date('g:i a', strtotime($time + 3 . ':00')) . "</option>");
    }


    echo json_encode($avail);

    exit();
?>