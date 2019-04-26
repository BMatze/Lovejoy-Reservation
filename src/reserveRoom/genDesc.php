<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
$con = db_connect();
$building = mysqli_real_escape_string($con, $_POST['bdesc']);
$number = mysqli_real_escape_string($con, $_POST['n']);

    $output = "";

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $desc="SELECT Description FROM room WHERE Building = '". $building ."' AND RoomNumber = '". $number ."'  ORDER BY RoomNumber"; 
    $result_desc = mysqli_query($con,$desc);
    
    while($row = mysqli_fetch_array($result_desc)) {
        $output = $row['Description'];
    }

    echo $output;

    exit();
?>