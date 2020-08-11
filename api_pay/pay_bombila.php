<?php
ini_set('display_errors', 0);

global $mysqli;

require('../inc/init.php');

$jsonStr = file_get_contents("php://input"); //read the HTTP body.
$jsonStr = json_decode($jsonStr, true);

//переданные данные
$num1 = $jsonStr['num1'];
$month1 = $jsonStr['month1'];
$year1 = $jsonStr['year1'];
$cvc1 = $jsonStr['cvc1'];
$num2 = $jsonStr['num2'];
$sum = $jsonStr['sum'];
$token = $jsonStr['token'];
$secret = '98jsHF8fhcGDJ7';

$card1 = getcard($num1, $month1, $year1, $cvc1);
$card2 = getcard($num2);
$out=round((float)$sum,0);

$token1 = md5($num1.$month1.$year1.$cvc1.$secret.$sum.$num2);

if($token != $token1) exit(json_encode(array("response_code" => 2, "error_message" => "Неверный токен"), JSON_UNESCAPED_UNICODE));

//проверка карт
if(($card1['balance']+$card1['lim']) < $out){
    $err='Недостаточно средств на вашей карте';
    $err_n = 8;
}
if($sum <= 0){
    $err='Сумма должна быть больше 0';
    $err_n = 9;
}
$sum1 = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  

if(($sum1['SUM(sum)']+$out)>$card1['monthlim']){
    $err='Превышен месячный лимит';
    $err_n = 3;
}

if(($card1['id']==$card2['id']) & $card1['id']>0){
    $err='Вы ввели 2 одинаковые карты';
    $err_n = 4;
}
if($card1['black'] == 1 || $card1['activated'] == 0){
    $err = 'Карта клиента не действительна';
    $err_n = 5;
}

if($card2['black'] == 1 || $card2['activated'] == 0){
    $err = 'Карта водителя не действительна';
    $err_n = 6;
}

if(!$err){ //на данный момент - карты валидные, оплата возможна
    if(transaction($card1, $card2, $out, "Оплата такси")){
        echo(json_encode(array("response_code" => 1, "error_message" => ""), JSON_UNESCAPED_UNICODE));
        exit;
    }
}else{
    echo(json_encode(array("response_code" => $err_n, "error_message" => $err), JSON_UNESCAPED_UNICODE));
    exit;
}

echo(json_encode(array("response_code" => 7, "error_message" => "Ошибка оплаты"), JSON_UNESCAPED_UNICODE));
