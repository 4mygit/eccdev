<?php

include_once('conn.php');

function rule2($deviceid){
    global $con;
    $sql = "select * from `object` where  `deviceid` = '{$deviceid}' and objname = 'SaFanSpdPos' || objname = 'RaTmp' order by recordid DESC";

    $result = mysqli_query($con,$sql);
    $tableData =  array();

    while($rows =  mysqli_fetch_assoc($result)){
    var_dump($rows);
    }
}

rule2(2537216)

?>
