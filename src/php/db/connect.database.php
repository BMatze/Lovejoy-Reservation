<?php
/**
 * Purpose: Isolate database connection's to a single instance that needs changed.
 */
 //Scoping to prevent unintended variable leakage

function dbConnect(){
	$host = "localhost";
	$user = "";
	$pass = "";
	$defaultDB = 'test';

	return mysqli_connect($host,$user,$pass,$defaultDB);
}
?>