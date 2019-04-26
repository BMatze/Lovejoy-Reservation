<?php
    $building = $_POST['building'];
    $number = $_POST['number'];	
    $floor = $_POST['floor'];
    $description = $_POST['description'];	
    $id = $_POST['id'];


    #Creates the connection to the database used			  
    $con = mysqli_connect('localhost','s002681','her3ved8', 'test');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    #Selects the proper database
    mysqli_select_db($con,"test");
    
    $bld="SELECT Building FROM room WHERE Id = '".$id."'";
    $result_bld = mysqli_query($con,$bld);
    $num="SELECT RoomNumber FROM room WHERE Id = '".$id."'";
    $result_num = mysqli_query($con,$num);
    $flr="SELECT Floor FROM room WHERE Id = '".$id."'";
    $result_flr = mysqli_query($con,$flr);
    $desc="SELECT Description FROM room WHERE Id = '".$id."'";
    $result_desc = mysqli_query($con,$desc);
    
    while($row = mysqli_fetch_array($result_bld)) {
        $final_bld = $row['Building'];
    }
    while($row = mysqli_fetch_array($result_num)) {
        $final_num = $row['RoomNumber'];
    }
    while($row = mysqli_fetch_array($result_flr)) {
        $final_flr = $row['Floor'];
    }
    while($row = mysqli_fetch_array($result_desc)) {
        $final_desc = $row['Description'];
    }

    #Checks if the current item is different and also makes sure the db isn't updated with an empty variable			       
    $test = "SELECT RoomNumber, Building FROM room WHERE Building='". $building ."' AND RoomNumber= '". $number ."' AND Id<> '". $id ."'";
    $query = mysqli_query($con, $test );
    if(mysqli_num_rows($query) > 0){
        echo "exits";
    }
    else{
        $count = 0;
        if($building != "" && $building != $final_bld){
            $update = "UPDATE room SET Building='". $building ."' WHERE ID='". $id ."'";
            $mod_room = mysqli_query($con,$update);
            $count = $count + 1;
        }
        if($number != "" && $number != $final_num){
            $update = "UPDATE room SET RoomNumber='". $number ."' WHERE ID='". $id ."'";
            $mod_room = mysqli_query($con,$update);
            $count = $count + 1;
        }
        if($floor != "" && $floor != $final_flr){
            $update = "UPDATE room SET Floor='". $floor ."' WHERE ID='". $id ."'";
            $mod_room = mysqli_query($con,$update);
            $count = $count + 1;
        }
        if($description != "" && $description != $final_desc){
            $update = "UPDATE room SET Description='". $description ."' WHERE ID='". $id ."'";
            $mod_room = mysqli_query($con,$update);
            $count = $count + 1;
        }
        if($count > 0){
            echo "success";
        }
        else{
            echo "not modified";
        }
    }

    exit();    
?>