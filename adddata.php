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
$objtype = $data->objtype;
$objinstance = $data->objinstance;
$objvalue = $data->objvalue;
$objdesc = $data->objdesc;
$objunit = $data->objunit;

//$location = $data->location;

 $sql =
 "INSERT INTO `object` (`recordid`, `deviceid`, `objname`, `objtype`,`objinstance`, `objvalue`,`objdesc`,`objunit`,`dated`) 
VALUES (NULL, '{$deviceid}', '{$objname}','{$objtype}','{$objinstance}','{$objvalue}','{$objdesc}','{$objunit}',now())";

if(mysqli_query($con,$sql)){
    $id = mysqli_insert_id($con);

    echo json_encode(

        array('message' => "success",
        'status_code' => 200       

        )

    );
    exit();

}else{
    echo json_encode(

        array('message' => "failed",
        'status_code' => 202       

        )

    );

}





?>