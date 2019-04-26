<?php
$user = "sewalte";

$con = mysqli_connect('localhost','s002681','her3ved8', 'test');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"test");
$sql="SELECT building, roomnumber, DATE_FORMAT(startdate, '%m-%d-%Y'), starttime, endtime FROM schedule WHERE user='".$user."' AND startdate >= CURDATE()  ORDER BY MONTH(startdate) ASC, DAYOFMONTH(startdate) ASC, HOUR(starttime) ASC" ;
$result = mysqli_query($con,$sql);
$results = array();

while($row = mysqli_fetch_array($result)) {
    array_push($results,"<tr><td> " .$row['building'] ." </td><td> " .$row['roomnumber'] ." </td><td> " . date("g:i a", strtotime($row['starttime'])) ." </td><td> ". date("g:i a", strtotime($row['endtime'])) ." </td><td> ". $row["DATE_FORMAT(startdate, '%m-%d-%Y')"] ."</td></tr>");
}
mysqli_close($con);

echo json_encode($results);
exit;
?>