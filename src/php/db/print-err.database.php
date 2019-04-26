<?php
/**Purpose: if a variable named $debug is found and is true this will
 * echo the error message to the server
 * 
 */
if (isset($debug) && $debug)
	echo "(".mysqli_errno($con).") ".mysqli_error($con);
	