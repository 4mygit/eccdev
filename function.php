<?php



function getPrevMonth($curDate){

  

$newdate = date("M", strtotime ( '-1 month' , strtotime ( $curDate ) )) ;



$curday = date('d', strtotime($curDate));

$curmonth = date('m', strtotime($curDate));

$curyear = date('y', strtotime($curDate));

if($curmonth == '01'){



    return $newdate."'".date("y", strtotime ( '-1 year' , strtotime ( $curDate ) ));

}else{



//return $newdate."\'".$curyear;

return $newdate;

}

}





/***********************/

function getReadDateFormat($readingDate){



$date = DateTime::createFromFormat("Y-m-d", $readingDate);

    $yr = $date->format("Y");

    $month = $date->format("m");

    $d = $date->format("d");



    $newReadingDate = $yr.'-'.$month.'-'.'01';

    

    return $newReadingDate;

  

}

/***********************/



function dateCompare($tableDate, $apiDate){



    if ($apiDate > $tableDate) {

        $date = "2010-05-12";

        $nd = date_parse_from_format("Y-m-d", $tableDate);

        $newdateMonth = $nd["month"];



        $cd = date_parse_from_format("Y-m-d", $apiDate);

        $currentdateMonth = $cd["month"];



        if($newdateMonth == $currentdateMonth){

            return 2; // Update table with new value

        }

        else {

            return 1; // Insert new data on table



        }

}else if($apiDate == $tableDate){

    return 2;



}else{

return 0; // No work on db

}





}



function getLastMonthRead($email,$update = 0){

    global $con;

    $sql = "select * from `consumption` where  `email` = '{$email}'";

    $result = mysqli_query($con,$sql);

    $total = mysqli_num_rows($result);

    if($update == 1){

      $sqlForPreMonthRead = "select * from `consumption` where  `email` = '{$email}' order by id DESC limit 1,1";

    }else{

        $sqlForPreMonthRead = "select * from `consumption` where  `email` = '{$email}' order by id DESC limit 0,1";



    } 

    $PreMonthReadResult = mysqli_query($con,$sqlForPreMonthRead);

    $PreMonthReadData = mysqli_fetch_assoc($PreMonthReadResult);

    return $PreMonthReadData['meterreads'];



}



function getCustomerId($email){

    global $con;

    $sqlForCustId = "select * from `user` where  `email` = '{$email}'";

    $totalResult = mysqli_query($con,$sqlForCustId);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['custid'];

}



function addBilling($custid,$billDate,$email,$billingmonth,$consumption,$consumptionId =0, $billtype = '0'){

    global $con;

    $date = DateTime::createFromFormat("Y-m-d", $billDate);

    $yr = $date->format("Y");

    $month = $date->format("m");

    $d = $date->format("d");



    $dueDate = $yr.'-'.$month.'-'.'21';



    if($month == 12)

    $nextMonth = '01';

    else

    $nextMonth =sprintf("%02d",  $month +1);



    if($month == 12)

    $yr = $yr +1; 

    $nextMonthDate = $yr.'-'.$nextMonth.'-'.'07';

    $nextMonthDate;

    

    $amount = $consumption * 5;

    $sqlBilling = "INSERT INTO `billing` 

    (`id`, `consumptionid`,`custid`, `email`, `billingdate`, `billingmonth`, `yearfor`,

     `duedate`, `consumption`,`amount`,  `totalamount`, `billtype`, `status`)

      VALUES (NULL, {$consumptionId},'{$custid}', '{$email}', '{$billDate}',

       '{$billingmonth}', '2022', '{$dueDate}', '{$consumption}', '{$amount}',  

    '{$amount}','{$billtype}', 0)";

    

    mysqli_query($con,$sqlBilling);

}



function updateBilling($consumptionId,$newDate,$consumption){

    global $con;

        

    $amount = $consumption * 5;

    $sqlBilling = "update `billing` set `consumption` = {$consumption} , `amount` = {$amount}, `totalamount` = {$amount}  where `consumptionid` = {$consumptionId}";

    

    mysqli_query($con,$sqlBilling);

}



function getConsumptionValueForComparison($email,$readDate){



    global $con;

    $sql = "select * from `consumption` where  `email` = '{$email}' and readdate = '{$readDate}'";

    $result = mysqli_query($con,$sql);

    //$total = mysqli_num_rows($result);

    $userData = mysqli_fetch_assoc($result);

    return $userData['monthlyconsumption'];



}



function getCustomerPostcode($email){

    global $con;

    $sqlForCustId = "select * from `user` where  `email` = '{$email}'";

    $totalResult = mysqli_query($con,$sqlForCustId);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['areacode'];

}



function getBillStatusOfUser_old($email,$readDate){



    global $con;

        $readDate = substr($readDate,0,8).'11';

    $sql = "select * from `billing` where  `email` = '{$email}' and `billingdate` = '{$readDate}'";

    $result = mysqli_query($con,$sql);

    $total = mysqli_num_rows($result);

    

    //$total = mysqli_num_rows($result);

    $userData = mysqli_fetch_assoc($result);

    if(isset($userData['status'])){
        return $userData['status'];

    }else{
        $readDate = substr($readDate,0,8).'10';

        $sql = "select * from `billing` where  `email` = '{$email}' and `billingdate` = '{$readDate}'";
    
        $result = mysqli_query($con,$sql);
    
        $total = mysqli_num_rows($result);
    
        
    
        //$total = mysqli_num_rows($result);
    
        $BISuserData = mysqli_fetch_assoc($result);
    
    
        return $BISuserData['status'];

    }





}



function getBillStatusOfUser($id){



    global $con;

        //$readDate = substr($readDate,0,8).'11';

    $sql = "select * from `billing` where  `consumptionid` = '{$id}'";

    $result = mysqli_query($con,$sql);

    //$total = mysqli_num_rows($result);

    $userData = mysqli_fetch_assoc($result);

    return $userData['status'];



}





function getEmailFromMeterid($meterid){



    global $con;

    $sql = "select * from `consumption` where  `meterid` = '{$meterid}'";

    $result = mysqli_query($con,$sql);

    //$total = mysqli_num_rows($result);

    $userData = mysqli_fetch_assoc($result);

    return $userData['email'];



}



function getMeterIdFromEmail($email){



    global $con;

    $sql = "select * from `consumption` where  `email` = '{$email}'";

    $result = mysqli_query($con,$sql);

    //$total = mysqli_num_rows($result);

    $userData = mysqli_fetch_assoc($result);

    return $userData['meterid'];



}



function getUserDetails($email){

    global $con;

    $sqlForCustId = "select * from `user` where  `email` = '{$email}'";

    $totalResult = mysqli_query($con,$sqlForCustId);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData;





}



function getBillStatus($consumptionId){

    global $con;

    $sqlForCustId = "select * from `billing` where  `consumptionid` = '{$consumptionId}'";

    $totalResult = mysqli_query($con,$sqlForCustId);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['billtype'];





}



function getMonthlyAvg($postcode,$formonth){

    global $con;

    $sql = "SELECT AVG(monthlyconsumption) as avg FROM consumption where postcode = '{$postcode}'  

            and state = 'approved' and formonth = '{$formonth}'";

    $result = mysqli_query($con,$sql);

    //$total = mysqli_num_rows($result);

    $userData = mysqli_fetch_assoc($result);

    return $userData['avg'];





}



function isApproved($existingLastRecordId){

    global $con;

    $sql = "select * from `consumption`  where id = {$existingLastRecordId} and state = 'approved'";

   // $sql = "select * from `consumption` where  `email` = '{$email}'";

    $result = mysqli_query($con,$sql);

    $total = mysqli_num_rows($result);

    //$userData = mysqli_fetch_assoc($result);

    //return $userData['meterid'];

    if($total > 0){

        return true;

    }else{

        return false;

    }



}



function getAvgOfApp($appliance){

    global $con;

   $sql2 = "SELECT avg(value) as avg FROM `appusage` where appliance = '{$appliance}'";

   $result2 = mysqli_query($con,$sql2);

   $rows =  mysqli_fetch_assoc($result2);

   return $rows['avg'];

}



function getParntApp($appliance){

    global $con;

   $sql2 = "SELECT * FROM `appliance` where appliance_name = '{$appliance}'";

   $result2 = mysqli_query($con,$sql2);

   $rows =  mysqli_fetch_assoc($result2);

   return ucfirst($rows['appliance_type']);

}



function getParntAppWithId($appliance){

    global $con;

   $sql2 = "SELECT * FROM `appliance` where appliance_name = '{$appliance}'";

   $result2 = mysqli_query($con,$sql2);

   $rows =  mysqli_fetch_assoc($result2);

   return ucfirst($rows['appliance_type']);

}



function getChild($prntCat){

    global $con;

    $children =  array();

    $totalAvg = 0;

    $count = 0;

   $sql2 = "SELECT * FROM `appliance` where appliance_type = '{$prntCat}'";

   $result2 = mysqli_query($con,$sql2);

   while($rows =  mysqli_fetch_assoc($result2)){

   array_push($children,$rows['appliance_name']);

   }



  foreach($children as $appl){

    $count++;

    $totalAvg += getAvgOfApp($appl);



  }
  if($count != 0)
   return $totalAvg/$count;
   else
   return $totalAvg;
 
}

function getProjectedVal($email,$consumptionId){

    global $con;

//    if($consumptionId != ''){
  //       $sql = "select * from eusage where id = '{$consumptionId}' limit 0,1";
   // }else{
//    $sql = "select * from eusage where month = 'May-22' limit 0,1";
    $sql = "select * from eusage where email = '{$email}' order by recordno desc limit 0,1";
//}
    $totalResult = mysqli_query($con,$sql);
    
    $total = mysqli_num_rows($totalResult);


    $userData = mysqli_fetch_assoc($totalResult);
    if($total > 0){

    return $userData['projected_eusage'];
    }
    else{
        return 0;
    }

}

function getDeviceBrand($appliance_id){

    global $con;

    $sql = "select * from app_brand where appid = '{$appliance_id}' limit 0,1";

    $totalResult = mysqli_query($con,$sql);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['brand'];


}

function getDeviceModel($appliance_id){

    global $con;

    $sql = "select * from app_brand where appid = '{$appliance_id}' limit 0,1";

    $totalResult = mysqli_query($con,$sql);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['model'];


}

function getDeviceRating($appliance_id){

    global $con;

    $sql = "select * from app_brand where appid = '{$appliance_id}' limit 0,1";

    $totalResult = mysqli_query($con,$sql);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['rating'];


}

function getDeviceId($appliance_id){

    global $con;

    $sql = "select * from app_brand where appid = '{$appliance_id}' limit 0,1";

    $totalResult = mysqli_query($con,$sql);

    $userData = mysqli_fetch_assoc($totalResult);

    return $userData['deviceid'];


}


?>