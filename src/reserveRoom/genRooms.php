<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
    $con = db_connect();
    $building = mysqli_real_escape_string($con, $_POST['b']);
    
    $array1 = array();
    $avail = array();

    if (! $con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    
    $avail_time = "SELECT RoomNumber FROM room WHERE Building = '" . $building . "' ORDER BY RoomNumber";
    $result_time = mysqli_query($con, $avail_time);
    
    while ($row = mysqli_fetch_array($result_time)) {
        $output = mysqli_real_escape_string($con, $row['RoomNumber']);
        array_push($array1, "<option value='" . $output . "'> " . $output . "</option>");
    }
    
    echo json_encode($array1);
    
    exit();
?>