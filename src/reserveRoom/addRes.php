<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
$con = db_connect();
    

    $startdate = date('Y-n-j', strtotime($_POST['d']));
    $enddate = "";
    $starttime = mysqli_real_escape_string($con, $_POST['t']);
    $endtime = mysqli_real_escape_string($con, $_POST['end']).":00";
    $color = "#511730";
    $url = "";
    $user = mysqli_real_escape_string($con, $_POST['e']);
    $building = mysqli_real_escape_string($con, $_POST['b']);
    $roomnumber = mysqli_real_escape_string($con, $_POST['n']);
    $removedstart = "";
    $removedend = "";
    /**WARNING: This is vulnerable until we use phpCAS!!**/
    $facID = db_getFacultyID($user);
    if ($facID == -1) {
        //$user = phpCAS::getUser();
    }
    
    
    
    $timeDiff = $endtime - $starttime;

    if($timeDiff == 1){
        $removedstart = $starttime.":00";
        $removedend = ($starttime+1).":00";
    }
    else if($timeDiff == 2){
        $removedstart = $starttime.":00,".($starttime+1).":00";
        $removedend = ($starttime+1).":00,".($starttime+2).":00";
    }
    else if($timeDiff == 3){
        $removedstart = $starttime.":00,".($starttime + 1).":00,".($starttime + 2).":00";
        $removedend = ($starttime+1).":00,".($starttime+2).":00,".($starttime+3).":00";
    }

    $con = mysqli_connect('localhost','s002681','her3ved8', 'test');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    mysqli_select_db($con,"test"); 

    $query = mysqli_query($con, "SELECT user FROM schedule WHERE startdate='".$startdate."' AND user= '".$user."'");
    if(mysqli_num_rows($query) > 0){
        echo 'already reserved';
        exit();
    }
    else{
        $starttime = $starttime . ":00";
        $res = "INSERT INTO `test`.`schedule` (`name`, `startdate`, `enddate`, `starttime`, `endtime`, `color`, `url`, `user`, `building`, `roomnumber`, `removedstart`, `removedend`) VALUES ('$name', '$startdate', '$enddate', '$starttime', '$endtime', '$color', '$url', '$user', '$building', '$roomnumber', '$removedstart', '$removedend')";
        if (mysqli_query($con, $res)) {
            echo 'success';
        } 
        else {
            echo 'failed';
        }
        exit();
    }
?>