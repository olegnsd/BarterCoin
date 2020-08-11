<?
require('../inc/init.php');
if($_COOKIE['card1']){$card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);}$card1=$card;
$sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(1*24*60*60))."' AND `iswithdraw`=1")); 
echo($card1['withdrawlim']-$sum['SUM(sum)']);
?>
