<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
// gets the ajax request type from client.
$requestType = (int) $_POST['requestType'];

// establish connection with database

// end connection managment
$con = db_connect();
// A flag from the client saying what kind of
// operation is being performed
switch ($requestType) {
    case 0:
        removeAsStudent($con, $_POST['eventid']);
        break;
    case 1:
        removeAsFaculty($con, $_POST['eventid']);
        break;
    default:
        break;
}
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
    $studentID = mysqli_real_escape_string($con, $_SESSION['username']);
    
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
    
    $con = db_connect();
    // in case of second layer mysql injection - covers all bases
    $facultyID = mysqli_real_escape_string($con, $_SESSION['username']);
    $sanitizedEventID = mysqli_real_escape_string($con, $eventID);
    mysqli_close($con);
    // draw from faculty database, if the query succeeds we will check if they are faculty
    if (db_getFacultyID($facultyID) != - 1) {
        
        
        
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

echo json_encode($result);
}