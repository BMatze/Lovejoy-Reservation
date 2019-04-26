<?php

/**
 * 
 * @var boolean $faculty - value representing if the current user is faculty.
 */
require_once 'dbConnect.php';
function isFaculty() {
    $link = connect('test2');
    $sanitized = mysqli_real_escape_string($link, phpCAS::getUser());
    $query = "SELECT * FROM Faculty WHERE '" . $sanitized . "'=Faculty.user";
    $result = mysqli_query($link, $query);
    $faculty = (mysqli_num_rows($result) == 1);
    mysqli_free_result($result);
    mysqli_close($link);
    return $faculty;
}

?>
