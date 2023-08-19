<?php
header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST');

include_once('conn.php');

$data = json_decode(file_get_contents("php://input"));



$deviceid	 = $data->deviceid;
$ruleno = $data->ruleno;


//$location = $data->location;

 $sql = "select * from `alarm` where  `deviceid` = '{$deviceid}' and  `ruleno` = '{$ruleno}' order by recordid DESC limit 0,1";

$result = mysqli_query($con,$sql);
$tableData =  array();

$rows =  mysqli_fetch_assoc($result);
extract($rows);
$jsonData = array( 

    'status_code'=> 200,
    'message'=> "Success",
    'alarm' => $alarm
 
 );
 
 echo json_encode($jsonData);
?>