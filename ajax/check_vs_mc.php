<?php
require('../inc/init.php');
//проверка типа платежной системы
$linkas_qiwi = $_GET['card'];
$card1=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);
$res = check_vs_mc(htmlspecialchars($linkas_qiwi), 'visa_mastercard', $card1);

echo(json_encode($res, JSON_UNESCAPED_UNICODE));

