<?php
ini_set('display_errors', 0);
require('../inc/init.php');
$card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);
require('../inc/auth_front.php');

if($auth_front){
    if(isset($_GET['card_n'])){
        $card = mysqli_query($mysqli, "SELECT a.number, a.balance, a.lim, a.monthlim, a.withdrawlim, a.lim_one, a.bankomats FROM accounts AS a, card_for_pay AS c, per_room AS p WHERE c.id=". (int)$_GET['card_n'] ." AND a.number = c.number  AND p.id = ".$account['id']." LIMIT 1;");//". (int)$_GET['card_n'] ." 
        sql_err($mysqli, 'card_info');
        if($card){
           $card = mysqli_fetch_array($card);
        }else{
           $card = 'card_false'; 
        }
        echo json_encode($card);//, JSON_UNESCAPED_UNICODE
        exit;
    }

    //вывод ошибок sql
    function sql_err($mysqli, $fun){
        $myecho = json_encode(mysqli_error($mysqli), JSON_UNESCAPED_UNICODE);
        if(strlen($myecho) > 5)`echo " $fun : "  $myecho >>/var/www/tmp/qaz_pay_util`;
        return;
    }
    
}
