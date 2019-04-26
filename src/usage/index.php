<?php


$fileName = "usage".date('m-d-Y').".csv";

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename={$fileName}");
header("Expires: 0");
header("Pragma: public");

$fh = @fopen( 'php://output', 'w' );

$con = mysqli_connect('localhost','s002681','her3ved8', 'test');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"test"); 

$usage="SELECT name, startdate, starttime, endtime, user FROM schedule ORDER BY MONTH(startdate) ASC, DAYOFMONTH(startdate) ASC, starttime ASC"; 
$result_usage = mysqli_query($con,$usage);


// Put the data into the stream
fputcsv($fh, array('room reserved', 'start date', 'start time', 'end time', 'user'));

while($row = mysqli_fetch_array($result_usage)) {
    fputcsv($fh, array($row['name'], date("m-d-Y", strtotime($row['startdate'])), date("g:i a", strtotime($row['starttime'])), date("g:i a",strtotime($row['endtime'])), $row['user']));
}
// Close the file
fclose($fh);
// Make sure nothing else is sent, our file is done
exit;
?>