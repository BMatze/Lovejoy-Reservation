<?php
/**File: clientProxy.php
 * Purpose: Handle AJAX request sent from client.
 * Returns: Status code representing success or failure.
 * Author: Brock Matzenbacher
 * Description: A BTS site that serves functions for 
 *     various client activities that need validation.
 */

require_once 'dbConnect.php';
require_once 'facultyInfo.php';

// constants
$ITER = 0;
$CANCEL_RESERVE_STUDENT = $ITER ++;
$CANCEL_RESERVE_FACULTY = $ITER ++;
$ADD_FACULTY = $ITER ++;
$REM_FACULTY = $ITER ++;
$RESERVE_ROOM = $ITER ++;

// gets the ajax request type from client.
$requestType = (int) $_POST['requestType'];
// establish connection with database
$con = connect('test2');
// end connection managment

// A flag from the client saying what kind of
// operation is being performed
switch ($requestType) {
    case $CANCEL_RESERVE_STUDENT:
        removeAsStudent($con, $_POST['eventid']);
        break;
    case $CANCEL_RESERVE_FACULTY:
        removeAsFaculty($con, $_POST['eventid']);
        break;
    case $RESERVE_ROOM:
        
        $building = (isset($_POST['bldg']) ? mysqli_real_escape_string($con, $_POST['bldg']) : false);
        $roomNum = (isset($_POST['rn']) ? mysqli_real_escape_string($con, $_POST['rn']) : false);
        $date = (isset($_POST['dt']) ? mysqli_real_escape_string($con, $_POST['dt']) : false);
        $startTime = (isset($_POST['st']) ? mysqli_real_escape_string($con, $_POST['st']) : false);
        $endTime = (isset($_POST['et']) ? mysqli_real_escape_string($con, $_POST['et']) : false);
        $userID = phpCAS::getUser();
        if (isFaculty())
            $userID = mysqli_real_escape_string($con, $_POST['userid']);
        
        reserveRoomHandler($con, $building, $roomNum, $date, $startTime, $endTime, $userID);
        break;
    case $ADD_FACULTY:
        break;
    case $REM_FACULTY:
        break;
    
    default:
}

// close db connection
mysqli_close($con);

/*
 * Purpose: Validates the current user is the one
 * who has the selected scheduled event.
 * If valid, it will continue to remove the event.
 *
 */
function removeAsStudent($con, $eventID)
{
    // prevent second layer mysql injection
    $studentID = mysqli_real_escape_string($con, phpCAS::getUser());
    
    // sanitize to prevent mysql injection
    $sanitizedEventID = mysqli_real_escape_string($con, $eventID);
    
    if ($result = mysqli_query($con, "SELECT id FROM schedule WHERE user='$studentID' and id='$sanitizedEventID'")) {
        // the current studentID matches that of the user who reserved the room.
        if (mysqli_num_rows($result) == 1) {
            if (mysqli_query($con, "DELETE FROM schedule WHERE id='$sanitizedEventID' LIMIT 1")) {
                $result->response = '+';
                $result->message = "The event was successfully removed";
            } else {
                $result->response = '-';
                $result->message = "Could not remove the event";
            }
        } else {
            $result->response = '-';
            $result->message = "Given event does not appear to exist";
        }
    } else {
        $result->response = '-';
        $result->message = "Could not perform necessary operations to complete this request.";
    }
    echo json_encode($result);
}

/*
 * Purpose: Validates the current user is faculty.
 * If valid, continue to remove the provided event.
 */
function removeAsFaculty($con, $eventID)
{
    // in case of second layer mysql injection - covers all bases
    $facultyID = mysqli_real_escape_string($con, phpCAS::getUser());
    
    // draw from faculty database, if the query succeeds we will check if they are faculty
    if ($res = mysqli_query($con, "SELECT user from faculty where user='$facultyID'")) {
        // this means the facultyID was listed in the faculty database.
        if (mysqli_num_rows($res) == 1) {
            // free result set
            mysqli_free_result($res);
            // protection from sql Injection
            $sanitizedEventID = mysqli_real_escape_string($con, $eventID);
            
            // perform the remove operation.
            if (mysqli_query($con, "DELETE FROM schedule WHERE id='$sanitizedEventID' LIMIT 1")) {
                $result->response = '+';
                $result->message = "The event was successfully removed";
            } else {
                $result->response = '-';
                $result->message = "Could not remove the event";
            }
        } else {
            $result->response = '-';
            $result->message = "Could not verify faculty.";
        }
    } else {
        $result->response = '-';
        $result->message = "Could not perform necessary operations to complete this request.";
    }
    echo json_encode($result);
}

/**
 *
 * @param string:bool $building
 * @param string:bool $roomNum
 * @param string:bool $startTime
 * @param string:bool $endTime
 * @param string:bool $userID
 */
function reserveRoomHandler($con, $building, $roomNum, $date, $startTime, $endTime, $userID)
{
    $result = new \stdClass();
    if (! phpCAS::isSessionAuthenticated()) {
        echo 'session not authenticated';
    }
    if ($building) {
        
        $_SESSION['reserve-building'] = $building;
        $_SESSION['reserve-roomnum'] = null;
        $_SESSION['reserve-st'] = null;
        $_SESSION['reserve-et'] = null;
        $result->building = updateBuildings($con);
        $result->roomnum = updateRoomNumbers($con);
        
        if (count($result->roomnum->dset) > 0) {
        	$_SESSION['reserve-roomnum'] = $result->roomnum->dset[0];
        	$result->starttime = updateStartTimes($con);
        	if (isset($result->starttime->dset) && count($result->starttime->dset)) {
        		$_SESSION['reserve-st'] = $result->starttime->dset[0];
        	}
        	
        }
        if (isset($_SESSION['reserve-roomnum'])) {
        	
        }
        	
    }
    if ($roomNum) {
        $_SESSION['reserve-roomnum'] = $roomNum;
        // refresh starttimes (if date)
        
        $result->roomnum = queryRooms($con, $_SESSION['reserve-building']);
        $result->desc = queryDescription($con, $_SESSION['reserve-building'], $roomnum);
        $result->starttime = updateStartTimes($con);
        
    }
    if ($date) {
        $_SESSION['reserve-date'] = $date;
        // refresh starttimes (if roomNum)
        $result->starttime = updateStartTimes($con);
        $result->endtime = updateEndTimes($con);
    }
    if ($startTime) {
        $_SESSION['reserve-st'] = $startTime;
        // refresh endtimes (if date & roomNum)
        $result->endtime = updateEndTimes($con);
    }
    if ($endTime) {
        $_SESSION['reserve-et'] = $endTime;
    }
    if ($userID) {
        $_SESSION['reserve-userid'] = $userID;
        // user clicked submit
        if (reserveRoom($_SESSION['reserve-building'], $_SESSION['reserve-roomnum'], $_SESSION['reserve-date'], $_SESSION['reserve-st'], $_SESSION['reserve-et'], $userID)) {
        	$result->response="+";
        	$result->message="Reservation added successfully";
        } else {
        	$result->response="-";
        	$result->message="Reservation was not added..";
        }
    
    }
    echo json_encode($result);
}

function updateBuildings($con)
{
    $resSet = queryBuildings($con);
    $building = new \stdClass();
    $building->dset = array();
    foreach ($resSet as $key => $value) {
        if ($building == $value) {
            $building->selected = $key;
        }
        $building->dset[] = $value;
    }
    return $building;
}

function updateRoomNumbers($con)
{
    $resSet = queryRooms($con, $_SESSION['reserve-building']);
    
    $roomnum = new \stdClass();
    $roomnum->dset = array();
    foreach ($resSet as $key => $value) {
        $roomnum->dset[] = $value;
    }
    $roomnum->selected = 0;
    $_SESSION['reserve-roomnum'] = $result->roomnum->dset[0];
    return $roomnum;
}

function updateStartTimes($con)
{
    $starttime = new \stdClass();
    // end time - if set we can restrict search to 3 hours prior,
    if (isset($_SESSION['reserve-date'])) {
        $rt = DateTime::createFromFormat("m/j/Y", $_SESSION['reserve-date']);
        $now = new DateTime();
        for ($i = getStartTime($rt); $i < getEndTime($rt); $i ++) {
            
            //hardcoded timeblock sizes to get this working
            date_time_set($rt, $i, 0);
            if (date_diff($now,$rt)->invert) {
                continue;
            }
            $resSet = queryReservationsTargeted($con, $date, "$i:00", ($i + 1) . ":00");
            
            if (count($resSet) > 0) {
                continue;
            }
            $starttime->dset[] = date_format($rt, "h:00A");
        }
    }
    return $starttime;
}
/**
 * Credit: Vael Victus and konsolenfreddy from stackoverflow
 *
 * @param DateTime $dateString
 * @return DateTime
 */
function roundToNextHour($dateString)
{
    $date = new DateTime($dateString);
    $minutes = $date->format('i');
    if ($minutes > 0) {
        $date->modify("+1 hour");
        $date->modify('-' . $minutes . ' minutes');
    }
    return $date;
}

function zeroToHour($dateString)
{
    $date = new DateTime($dateString);
    $minutes = $date->format('i');
    $seconds = $date->format('s');
    if ($minutes > 0) {
        $date->modify('-' . $minutes . ' minutes');
    }
    if ($seconds > 0) {
        $date->modify('-' . $seconds . ' seconds');
    }
    return $date;
}

/* END roundToNextHour */
function updateEndTimes($con)
{
    $endtime = new \stdClass();
    
    // end time - if set we can restrict search to 3 hours prior,
    if (isset($_SESSION['reserve-date']) && isset($_SESSION['reserve-st'])) {
        $now = new DateTime();
        $endtime->dset = array();
        $start = date_format(date_create_from_format("h:iA", $_SESSION['reserve-st']), 'H');
        for ($i = $start; $i <= getEndTime($rt) && $i - $start < getMaxAllowedTimeBlocks(); $i ++) {
            $rt = DateTime::createFromFormat("m/j/Y H:i:s", $_SESSION['reserve-date'] . " ".($i+1).":00:00");
            $resSet = queryReservationsTargeted($con, $date, ($i + 1) . ":00", ($i + 2) . ":00");
            if (date_diff($now,$rt)->invert) {
                continue;
            }
            if (count($resSet) > 0) {
                continue;
            }
            $endtime->dset[] = date_format($rt, "h:00A");
        }
    }
    return $endtime;
}

function reserveRoom($bldg, $room, $dt, $st, $et, $us)
{
    if (date_parse($st)['hour'] && (date_parse($st)['hour'] < getStartTime($dt)) || date_parse($et)['hour'] && (date_parse($et)['hour'] > getEndTime($dt))) {
        // out of range
        echo('naughty user?');
        return false;
    }
   
    if (count(queryReservationsTargeted($con, $date, $st, $et))==0)
        return addReservation($con, $bldg, $room, $dt, $st, $et, $us);
    return false;
}


