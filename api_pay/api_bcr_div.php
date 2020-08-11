<?php

ini_set('display_errors', 0);

require('../inc/init.php');


ini_set('display_errors', 0);

$json_data = file_get_contents("php://input"); //read the HTTP body.

$json_data = json_decode($json_data, true);


$token = md5($json_data['card1'] . $secret. $json_data['card2']. $json_data['sum']. $salt);

if($json_data['token'] != $token){
	die('Невырный токен');
}

$card1 = $json_data['card1'];
$card2 = $json_data['card2'];
$sum = $json_data['sum'];
$comment = $json_data['comment'];

$card1 = getcard($card1);
$card2 = getcard($card2);
$sum=round((float)$sum,0);

//проверка карт
if(($card1['balance']+$card1['lim']) < $sum){
    $err="Недостаточно средств на карте доноре";
    $err_n = 8;
}
if($sum <= 0){
    $err="Сумма должна быть больше 0";
    $err_n = 9;
}
$sum1 = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  
if(($sum1['SUM(sum)']+$sum)>$card1['monthlim']){
    $err="Превышен месячный лимит";
    $err_n = 3;
}

if(($card1['id']==$card2['id']) & $card1['id']>0){
    $err='Вы ввели 2 одинаковые карты';
    $err_n = 4;
}
if($card1['black'] == 1 || $card1['activated'] == 0){
    $err = 'Карта донора не действительна';
    $err_n = 5;
}

if($card2['black'] == 1 || $card2['activated'] == 0){
    $err = 'Карта получателя не действительна';
    $err_n = 6;
}

if(!$err){ //на данный момент - карты валидные, оплата возможна
    if(transaction($card1, $card2, $sum, $comment)){
        echo(json_encode(array("response_code" => "Accepted", "error_message" => ""), JSON_UNESCAPED_UNICODE));
        exit;
    }
}else{
    echo(json_encode(array("response_code" => $err_n, "error_message" => $err), JSON_UNESCAPED_UNICODE));
    exit;
}

echo(json_encode(array("response_code" => 7, "error_message" => "Ошибка оплаты"), JSON_UNESCAPED_UNICODE));
