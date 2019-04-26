<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/db/connect.database.php';
function db_connect()
{
    
    return dbConnect();
}

function db_insert($into, $arguments)
{
    $keys = array();
    $vals = array();
    // open connection to database
    $con = db_connect();
    foreach ($arguments as $key => $val) {
        // can we trust the developers used safe key names?
        $keys[] = $key;
        $vals[] = mysqli_real_escape_string($con, $value);
        
        // RESTRICTING VIA ARGUMENTS on given table
        // Example:
        // switch ($into) {
        // case 'schedule':
        // if (!isScheduleColumn($key)) {
        // include 'disconnect.database.php';
        // return null;
        // }
        // default:
        // include 'disconnect.database.php';
        // return null;
        // }
    } // end foreach
    $query = "INSERT INTO (" . implode(',', $into) . " VALUES (" . implode(',', $vals) . ")";
    $res = mysqli_query($con, $query);
    
    // return value - number rows inserted
    $affRows = mysqli_affected_rows($con);
    
    // close connection
    mysqli_close($con);
    return $affRows;
}
 // end db_insert
/**
 * Purpose: Use to determine if a user is faculty
 * 
 * @param string $name
 *            - name of facultyMember to find
 *            return int id of faculty member, or -1 if they are not faculty
 */
function db_getFacultyID($name)
{

    $con = db_connect();
    // sanitize
    $name = mysqli_real_escape_string($con, $name);
    $query = "SELECT id FROM faculty WHERE username='$name'";
    
    
    $res = mysqli_query($con, $query);
    if ($row = mysqli_fetch_array($res)) {
        $var = (int)$row['id'];
        mysqli_close($con);
        return ($var);
    }
    return -1;

}

/*Gets the list of buildings from db 
 *returns as array of strings*/
function db_getBuildings()
{
    $con = db_connect();

    $query = "SELECT DISTINCT Building FROM room ORDER BY Building ASC";
    $res = mysqli_query($con,$query);
    $ret = array();

    while ($row = mysqli_fetch_array($res)) {
        $ret[] = $row['Building'];
    }
    
    mysqli_close($con);
    return $ret;
}

?>


