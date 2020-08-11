<?php
ini_set('display_errors', 1);
require('inc/init.php');
ini_set('display_errors', 1);

echo('phone_users');
    
$result=mysqli_query($mysqli,"SELECT distinct(phone) FROM accounts WHERE phone!=''");

echo(json_encode($result));

unlink("/home/bartercoin/tmp/phones_barter");
$foptmp = fopen("/home/bartercoin/tmp/phones_barter", "ab");
foreach($result as $phone){
    if(strlen($phone['phone'])>=11){
        fwrite($foptmp, clear_phone($phone['phone']) . PHP_EOL);
    }
}
fclose($foptmp);
