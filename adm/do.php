<?php
include('../old/config.php');
require('../old/functions.php');
require('../inc/session.php');//session_start();
require('auth.php');if($auth){

if($_POST[id]){?><? 
$old=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM accounts WHERE `id`=".(int)$_POST[id].";"));  
if(isset($_POST['black'])){
    $black = true;
}else{
    $_POST['black'] = 0;
}
$bankomats = $_POST[bankomats];//mysqli_escape_string($mysqli,$_POST['bankomats']);
$bank_all = array();
$bank_all['allow'] = explode(',', $bankomats);
$bankomats = json_encode($bank_all);
$user_inf = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM accounts WHERE id = ".(int)$_POST['id'].";"));
if((int)$_POST['activated'] == 1 && !$user_inf['name1'] && !$user_inf['name2'] && !$user_inf['name3'] && !$user_inf['phone'] && $user_inf['balance'] == 0 && !$user_inf['black'] && !$_POST['black'] && !$user_inf['ip_reg'] && !$user_inf['phone_utc'] && !$user_inf['yandex'] && !$user_inf['qiwi'] && !$user_inf['visa_mastercard'] && !$user_inf['webmoney'] && !$user_inf['black_wallet'] && !$user_inf['last_sms']){
    $start_bal = 100;
    $card1=getcard('1000506236751958');
    transaction($card1,$user_inf,$start_bal, "Занесение 100 БР на новую карту ".$user_inf['number'], 0, 0, 0);
}else{
    $start_bal = 0;
}
if(mysqli_query($mysqli,"UPDATE `accounts` SET `activated` = '".(int)$_POST[activated]."', `black` = '".(int)$_POST[black]."', `lim` = '".(float)$_POST[lim]."', `monthlim` = '".(float)$_POST[monthlim]."', `withdrawlim` = '".(float)$_POST[withdrawlim]."', `lim_one` = '".(int)$_POST[lim_one]."', `withdraw_int` = '".(float)$_POST[withdraw_int]."', `amount_ref` = '".(float)$_POST[amount_ref]."', `bankomats` = '$bankomats', `name1` = '".mysqli_escape_string($mysqli,$_POST[name1])."', `name2` = '".mysqli_escape_string($mysqli,$_POST[name2])."', `name3` = '".mysqli_escape_string($mysqli,$_POST[name3])."', `phone` = '".mysqli_escape_string($mysqli,$_POST[phone_main])."' WHERE `accounts`.`id` = ".(int)$_POST[id].";")){
	if(((float)$old[lim]!=(float)$_POST[lim]) | (float)$old[monthlim]!=(float)$_POST[monthlim] | (float)$old[withdrawlim]!=(float)$_POST[withdrawlim]){
        /*require_once("../sms/transport.php");
        $api = new Transport();
        $phones = array($_POST[phone]);
        $params = array(
            'text' => 'Karta *'.substr($old[number],-4).'; Vam izmeneny limity; Kreditniy limit:'.number_format((float)$_POST[lim], 2, ',', ' ').' BCR (RUB); Mesyachniy limit: '.number_format((float)$_POST[monthlim], 2, ',', ' ').' BCR (RUB)',
            'source' => 'BarterCoin',
            'channel' => '0'

        );
        $send = $api->send($params,$phones);*/

        if(!sms($_POST[phone_main],'Karta *'.substr($old[number],-4).'; Vam izmeneny limity; Kreditniy limit:'.number_format((float)$_POST[lim], 2, ',', ' ').' BCR (RUB); Mesyachniy limit: '.number_format((float)$_POST[monthlim], 2, ',', ' ').' BCR (RUB); Limit na vyvod s sutki: '.number_format((float)$_POST[withdrawlim], 2, ',', ' ').' BCR (RUB)')){
            die(json_encode(array("<div class='alert alert-danger'>Не удалось отправить СМС</div>", "")));
        }else {
            echo(json_encode(array("<div class='alert alert-success'>Отправлена СМС об изм.лим.</div>", "")));
        }
    }else{
        echo(json_encode(array("Сохранено", $_POST['black']))); 
    }
}else{
    die('ошибка'); 
} 
}
}else{?>Необходимо переавторизоваться<?}
?>
