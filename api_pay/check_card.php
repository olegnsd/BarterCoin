<?php
ini_set('display_errors', 0);

global $mysqli;

require('../inc/init.php');

$jsonStr = file_get_contents("php://input"); //read the HTTP body.

$jsonStr = json_decode($jsonStr, true);

//переданные данные
$num = $jsonStr['num'];
$month = $jsonStr['month'];
$year = $jsonStr['year'];
$cvc = $jsonStr['cvc'];
$token = $jsonStr['token'];
$secret = 'hdTK4Ms0a5Myq9';

$check_card = new check_card;

//проверка карты
if($num && $month && $year && $cvc && $token && !$jsonStr['cod']){
    $card = $check_card->check($mysqli, $num, $month, $year, $cvc, $token, $secret);
    if($card){
        $date_sms =mysqli_fetch_assoc( mysqli_query($mysqli, "SELECT id FROM sms_bombila WHERE id_acc='".$card[id]."' AND date>(CURRENT_TIMESTAMP()-15)"));
        if($date_sms['id']){
            exit(json_encode(array("response_code" => 7, "error_message" => "Время СМС"), JSON_UNESCAPED_UNICODE));
        }
        $smscode = createsmscode($card['phone'], '', 0);

        mysqli_query($mysqli, "INSERT INTO sms_bombila (cod, id_acc) values ('$smscode[1]', '".$card['id']."')");

		sms($card['phone'],'SMS-kod: '.$smscode[1].'; Привязка карты Bartercoin *'.substr($card[number],-4));// убрать коммент
        
        echo(json_encode(array("response_code" => 1, "error_message" => ""), JSON_UNESCAPED_UNICODE));
    }
    exit;
}elseif($num && $month && $year && $cvc && $token && $jsonStr['cod']){
    
    $card = $check_card->check($mysqli, $num, $month, $year, $cvc, $token, $secret);
    if($card){
        $check_sms = $check_card->check_sms($mysqli, $card, $jsonStr['cod']);
    }
    
}

class check_card{
    public $amount_bank_d;
    
    public function __construct() { }
    
    //проверка карты
    public function check($mysqli, $num, $month, $year, $cvc, $token, $secret){
        
        $card = getcard($num, $month, $year, $cvc);
        
        $token1 = md5($secret.$num.$month.$year.$cvc);

        if($token != $token1) exit(json_encode(array("response_code" => 2, "error_message" => "Неверный токен"), JSON_UNESCAPED_UNICODE));

        //проверка карт
        if($card['black'] == 1 || $card['activated'] == 0){
            $err = 'Карта не действительна';
            $err_n = 3;
        }

        if(!$err){ //на данный момент - карты валидные, привязка возможна
            return $card;
        }else{
            echo(json_encode(array("response_code" => $err_n, "error_message" => $err), JSON_UNESCAPED_UNICODE));
            exit;
        }

    }
    
    public function check_sms($mysqli, $card, $cod){
        mysqli_query($mysqli, "DELETE FROM sms_bombila WHERE date<(CURRENT_TIMESTAMP()-60*5)");
        $check_cod = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT id FROM sms_bombila WHERE cod='".mysqli_escape_string($mysqli,$cod)."' AND id_acc='".$card['id']."'"));
        $check_cod = $check_cod['id'];
        
        if($check_cod){
            mysqli_query($mysqli, "DELETE FROM sms_bombila WHERE id_acc='".$card[id]."' OR date<(CURRENT_TIMESTAMP()-60*5)");

            echo(json_encode(array("response_code" => 4, "error_message" => ''), JSON_UNESCAPED_UNICODE));
            exit;
        }else{
            echo(json_encode(array("response_code" => 5, "error_message" => 'Код неверный'), JSON_UNESCAPED_UNICODE));
            exit;
        }
    }
}

echo(json_encode(array("response_code" => 6, "error_message" => "Ошибка привязки карты"), JSON_UNESCAPED_UNICODE));
