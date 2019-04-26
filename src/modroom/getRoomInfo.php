<?php 
    $array1 = array();
    $building = $_POST['building'];
    $number = $_POST['number'];	
    array_push($array1, $building, $number);

    $con = mysqli_connect('localhost','s002681','her3ved8', 'test');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    mysqli_select_db($con,"test"); 

    $floor="SELECT Floor FROM room WHERE Building = '".$building."' AND RoomNumber = '".$number."'"; 
    $result_floor = mysqli_query($con,$floor);
    
    while($row = mysqli_fetch_array($result_floor)) {
        $output = $row['Floor'];
    }
    array_push($array1, $output);

    $description="SELECT Description FROM room WHERE Building = '".$building."' AND RoomNumber = '".$number."'";
    $result_desc = mysqli_query($con,$description);
    
    while($row = mysqli_fetch_array($result_desc)) {
        $output = $row['Description'];
    }
    array_push($array1, $output);

    $id="SELECT Id FROM room WHERE Building = '".$building."' AND RoomNumber = '".$number."'";
    $result_id = mysqli_query($con,$id);

    while($row = mysqli_fetch_array($result_id)) {
        $output = $row['Id'];
    }
    array_push($array1, $output);

    mysqli_close($con);

    echo json_encode($array1);
    exit();
?>