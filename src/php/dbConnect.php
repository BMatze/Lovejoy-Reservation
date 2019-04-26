<?php


function connect($db) {
    $user = "s002681";
    $pass = "her3ved8";
    $server = "localhost";
        return mysqli_connect($server,$user,$pass,$db);
}

function queryBuildings($con) {
    $query = "SELECT DISTINCT Building FROM Room";
    if ($result = mysqli_query($con, $query)) {
        $resSet = array();
        while ($row = mysqli_fetch_array($result)) {
            $resSet[] = $row['Building'];
        }
        mysqli_free_result($result);
        return $resSet;
    }
    return null;
}
function queryRooms($con,$bldg) {
    $query = "SELECT DISTINCT RoomNumber FROM Room where Building='$bldg'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $resSet = array();
        while ($row = mysqli_fetch_array($result)) {
            $resSet[] = $row['RoomNumber'];
        }
        mysqli_free_result($result);
        return $resSet;
    }
}
function queryDescription($con,$bldg,$room) {
    $query = "SELECT Description FROM Room where Building='$bldg' and RoomNumber='$room'";
    
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $resSet = array();
        while ($row = mysqli_fetch_array($result)) {
            $resSet[] = $row['RoomNumber'];
        }
        mysqli_free_result($result);
        return $resSet;
    }
}
function queryReservations($con, $date) {
    $query = "SELECT r.user,Room.building,Room.RoomNumber, r.starttime,r.endtime,r.checkedin FROM reservation r WHERE starttime=STR_TO_DATE($date,'%Y/%m/%d') INNER JOIN Room on Room.id = r.roomid ";
    $result = mysqli_query($con, $query);
   
    if ($result) {
        $resSet = array();
       while ($row = mysqli_fetch_array($result)) {
           $resSet[] = $row;
       }
        mysqli_free_result($result);
        return $resSet;
    }
}
function queryReservationsTargeted($con, $date,$timeStart,$timeEnd) {
    $query = "SELECT r.user,Room.building,Room.RoomNumber, r.starttime,r.endtime,r.checkedin FROM reservation r WHERE (r.starttime BETWEEN STR_TO_DATE($date $timeStart,'%Y/%m/%d %H:%i:%s') AND STR_TO_DATE($date $timeEnd,'%Y/%m/%d %H:%i:%s') or r.endtime BETWEEN STR_TO_DATE($date $timeStart,'%Y/%m/%d %H:%i:%s') AND STR_TO_DATE($date $timeEnd,'%Y/%m/%d %H:%i:%s')) AND Room.Building='{$_SESSION['reserve-building']}' AND Room.RoomNumber='{$_SESSION['reserve-roomnum']}' INNER JOIN Room on Room.id = r.roomid";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        $resSet = array();
        while ($row = mysqli_fetch_array($result)) {
            $resSet[] = $row;
        }
        mysqli_free_result($result);
        return $resSet;
    }
    return array();
}
function queryRoomID($con,$bldg,$rn) {
    $query = "SELECT id FROM Room WHERE (Building='$bldg' and RoomNumber='$rn')";
    echo "$bldg $rn";
    
    if ($res =mysqli_query($con,$query)) {
    	echo $res;
    	$id = mysqli_fetch_array($res)['id'];
    	mysqli_free_result($res);
    	return $id;
    }
    
    return '-1';
    
}
function addReservation($con,$bldg,$rn,$date,$st,$et,$uid) {
	echo "INSERT INTO reservation (user,roomid,starttime,endtime,checkedin) VALUES ('$uid',".queryRoomID($con, $bldg, $rn).", $date $st,$date $et, 0)";
    $query = "INSERT INTO reservation (user,roomid,starttime,endtime,checkedin) VALUES ('$uid',".queryRoomID($con, $bldg, $rn).", '$date $st','$date $et', 0)";
    $res =mysqli_query($con,$query);
    echo ($res).".";
    
    if ($res) {
       if (mysqli_affected_rows($con) > 0) {
       	return true;
       }
    }
}
?>