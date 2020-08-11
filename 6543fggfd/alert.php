<?php

$merchant_id = '76387';
$merchant_secret = '54GGGGbvbvcoi[[09978';
function getIP() {
if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
   return $_SERVER['REMOTE_ADDR'];
}
/*if (!in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189'))) {
    die("hacking attempt!");
}*/

$sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);

if ($sign != $_REQUEST['SIGN']) {
    die('wrong sign');
}

require('../inc/init.php');
$test=getcard($_REQUEST['MERCHANT_ORDER_ID']);
if($test['id']){
$amount=$_REQUEST['AMOUNT'];
//$test[balance]=$test[balance]+$amount;
//mysqli_query($mysqli,'UPDATE `users` SET `balance` = \''.$test[balance].'\', `notifyflag`=\'0\' WHERE `users`.`id` = '.(int)$test[id].';');
//if($test[referal]){$test2=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM users WHERE id='".(int)$test[referal]."'"));
/*if($test2[id]>0){
mysqli_query($mysqli,'UPDATE `users` SET `balance` = \''.($test2[balance]+$referal).'\', `notifyflag`=\'0\' WHERE `users`.`id` = '.(int)$test2[id].';');
}}*/
?>YES<?
header('Connection: close');
header("Content-Length: 3" );
header("Content-Encoding: none");
header("Accept-Ranges: bytes");
ob_end_flush();
ob_flush();
flush();
transaction(getcard('1000506236751958'),$test,$amount, "", 0, $comission, $mincomission);
//transaction(getcard('1000506236751958'),$test,$amount);
}else{die('polzovatel ne nayden');}



/*include_once '../include/sql.php';

$userId = (int) $_REQUEST['MERCHANT_ORDER_ID'];
$amount = round ($_REQUEST['AMOUNT'] * 100);
$intid = (int) $_REQUEST['intid'];

if (!$users = db::find('users', ['where'=>'id='.$userId])) {
  die('Клинет не найден :(');
}

//добавляем статистику
$sql = "INSERT INTO statistics
	(userId, code, description, amount, intid)
	VALUES (".$userId.", 1, 'Пополнение баланса с помощью FREE-KASSA', ".$amount.", ".$intid.")";
db::query($sql);

$sql = "UPDATE users SET balance=`balance`+".$amount." WHERE id=".$userId;
db::query($sql);*/

die ();

?>
