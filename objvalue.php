<?php
header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST');

include_once('conn.php');

$data = json_decode(file_get_contents("php://input"));

//$userid = $_GET['mb'];

$devicetableid = 2;

$deviceid	 = $data->deviceid;
$objname = $data->objname;


//$location = $data->location;

 $sql = "select * from `object` where  `deviceid` = '{$deviceid}' and `objname` = '{$objname}' order by recordid DESC limit 0,1";

$result = mysqli_query($con,$sql);
$tableData =  array();

$rows =  mysqli_fetch_assoc($result);
extract($rows);
$jsonData = array( 

    'status_code'=> 200,
    'message'=> "Success",
    'objvalue' => $objvalue
 
 );
 
 echo json_encode($jsonData);
?>