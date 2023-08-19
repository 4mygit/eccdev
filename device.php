<?php

include_once('conn.php');

include_once('function.php');


$sql = "select *  from `device`";

$result = mysqli_query($con,$sql);
?>
<html>
    <body border ="1">
<table style = "border: 1px solid black;">
<tr><th style = "border: 1px solid black;">ID</th><th style = "border: 1px solid black;">Brand</th><th style = "border: 1px solid black;"> Controller</th style = "border: 1px solid black;"><th style = "border: 1px solid black;">IP</th> <th style = "border: 1px solid black;">Port</th> <th style = "border: 1px solid black;">Action</th></tr>

<?php

while($rows =  mysqli_fetch_assoc($result)){
    extract($rows);
   
?>
<tr><th style = "border: 1px solid black;"><?php echo $id; ?></th><th style = "border: 1px solid black;"> <?php echo $manufacturer; ?></th><th style = "border: 1px solid black;"> <?php echo $equipment; ?></th><th style = "border: 1px solid black;"><?php echo $ip; ?></th> <th style = "border: 1px solid black;"><a href="<?php echo $port; ?>?id=<?php echo $id; ?>&email=<?php echo $email; ?>"><?php echo $port; ?></a></th> <th style = "border: 1px solid black;"><a href="deleterecord.php?id=<?php echo $id; ?>&email=<?php echo $email; ?>">delete</th></tr>

<?php
}
?>