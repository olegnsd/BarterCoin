<?
require('../inc/init.php');

if(isset($_GET['card'])){
    $card=getcard($_GET['card']);
}

$data=mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM `shops` WHERE id='".(int)$_GET['shop']."' LIMIT 1;"));

//запрос баланса карты биржи
if((int)$_GET['balance'] == 1){
    $balance = mysqli_fetch_array(mysqli_query($mysqli,"SELECT `balance` FROM `accounts` WHERE id='".$data['card']."'"));
    die($balance['balance']);
}

if($data['id']>0){
	$card2=getcardbyid($data['card']);
	if($card2['id']==0 || $card2['black'] == 1)$err[]='Карта привязанная к бирже не активна';
	if((float)$_GET['sum']<=0)$err[]="Сумма перевода должна быть больше 0";
	if($_GET['id']=='')$err[]="Не указан ID платежа";
	if($_GET['return']=='')$err[]="Не указан URL возврата";
	$test=md5($data['id'].$data['key1'].$_GET['id'].(float)$_GET['sum']);
	if($_GET['secret']!=$test)$err[]="Неправильный хэш";
	$out=round((float)$_GET['sum']*$comission,2);
	if(($_GET['sum']*($comission-1))<$mincomission)$out=round((float)$_GET['sum']+$mincomission,2);
	if(!$err[0]){
        if($_GET['oper'] == '5'){//возврат средств, при удалении требования-купить     
            $card1 = $card;
			if($card1){
                transaction($card2,$card1,(float)$_GET['sum'],'Возврат средств на покупку BCR id='.$_GET['id'].' в '.$data['name'], 0, $comission, $mincomission);
                sms($card1['phone'],'Karta *'.substr($card1[number],-4).': Vozvrat '.(int)$_GET['sum'].' BCR na pokupku '.(int)$_GET['count'].' akciy BCR');
				die("RETURN_OK");
			}else{
				die("RETURN_ERR");
			}
            die("ERR");
        }
    }
}
