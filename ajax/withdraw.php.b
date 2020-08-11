<?
/*
БАНКОМАТ:
1) Алышева Алина Николаевна - БАНКОМАТ (ИНН: 760600603600) 
13G1 - +79295893561 :
Киви - 9295893561 пароль wQ6ozdMknw
ЯД - alina.alysheva@yandex.ru пароль WOqZ0h4Jna 
( номер кошелька 410015962012159 )
https://bartercoin.holding.bz/withdraw


5d842fb54c206521a1274978551df55f

*/
if($_POST['system'] != 'webmoney'){
    $_POST['target'] = preg_replace("/[^0-9]/", '', $_POST['target']);
}elseif($_POST['system'] == 'webmoney'){
//    $_POST['target'] = preg_replace("/[^0-9]/", '', $_POST['target']);
    if(!preg_match('/^\D{0,1}[0-9]{12,12}$/', $_POST['target'])){
        $err[] = "Неправильный номер карты";
    } 
}else{
    $err[] = "Неправильный номер карты";
}

$systems['qiwi']='QIWI';
$systems['ya']='Яндекс';
$systems['visa']='Visa Россия';
$systems['mastercard']='MasterCard Россия';
$systems['visa_sng']='Visa СНГ';
$systems['mastercard_sng']='MasterCard СНГ';
$systems['webmoney']='webmoney';
$systems['visa_mastercard']='visa_mastercard';

require('../inc/init.php');
if($_POST['system']=='ya')$comission=$comission;//$comission+0.03;
if($_COOKIE['card1']){$card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);}

$card1=$card;
//$card2=getcard('1000506236751958');

$card_id = $card['id'];
$timestamp = mysqli_query($mysqli,"SELECT timestamp FROM transactions WHERE fromid='$card_id' AND iswithdraw=1 order by timestamp desc limit 1");
$timestamp = mysqli_fetch_assoc($timestamp);
$timestamp = $timestamp['timestamp'];
$timestamp = strtotime($timestamp);//время последнего вывода с карты
$withdraw_int = ($card['withdraw_int']);
$delta_time = $withdraw_int*60 - (time() - $timestamp);
if($delta_time > 0){
   $err[]='Ваш интервал на вывод ' . $withdraw_int . ' мин. Можете выводить через ' . ceil($delta_time/60) . ' мин.'; 
}

//проверка на ЧС
if($card1['black'] == 1){
    $err_block='Ваша карта заблокирована. Обратитесь к администратору';
}

//проверка счета получателя на соответствие последнему
$recipient_oldest = recipient_oldest(htmlspecialchars($_POST['target']), htmlspecialchars($_POST['system']), $card1);

if(!$recipient_oldest){
    $err_alert='При выводе на другой счет '. $_POST['target']. ' , он автоматически привяжется к Вашей карте';
}

//проверка счета получателя
$recipient = recipient(htmlspecialchars($_POST['target']), htmlspecialchars($_POST['system']), htmlspecialchars($card_id), htmlspecialchars($card['number']));
if(!$recipient){
    $err_block='Ваша карта заблокирована. Обратитесь к администратору';
}

//может ли использовать текущий банкомат
$b = htmlspecialchars($_POST['b']);
$bankomats = json_decode($card['bankomats'], true);
$bankomats = $bankomats['allow'];
if($b <= 0 || $b >7){
    $err[] = 'Вы не можете пользоваться этим банкоматом';
}elseif(!in_array($b, $bankomats)){
    $err[] = 'Вы не можете пользоваться этим банкоматом';
}

//if(($card1['id']==$card2['id']) & $card1['id']>0)$err[]='Вы ввели 2 одинаковые карты';
if($card1['id']==0)$err[]='Вы ввели неверные данные своей карты';
//if($card2['id']==0)$err[]='Вы ввели неверные данные карты получателя';
$out=round((float)$_POST['sum']*$comission,2);
if($card1['id']){
if(($_POST['sum']*($comission-1))<$mincomission)$out=(float)$_POST['sum']+$mincomission;
if(($card1['balance']/*+$card1['lim']*/)<$out)$err[]="Недостаточно средств на вашей карте";
if((float)$_POST['sum']<=0)$err[]="Сумма должна быть больше 0";
$sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  
if(($sum['SUM(sum)']+$out)>$card1['monthlim'])$err[]="Превышен месячный лимит";
$sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(1*24*60*60))."' AND `iswithdraw`=1"));  
if(($sum['SUM(sum)']+(float)$_POST['sum'])>$card1['withdrawlim'])$err[]="Превышен суточный лимит на вывод";
if($out > $card1['lim_one'])$err[]="Превышен разовый лимит на вывод";
}
if($_POST['system']=='visa_mastercard'){
//  проверка типа платежной системы
    $check_vs_mc = check_vs_mc(htmlspecialchars($_POST['target']), htmlspecialchars($_POST['system']), $card1);//array('err' => $err, 'err_card' => $err_card, 'card' => $card, 'min' => $min)
    if($check_vs_mc['err'] == '1'){
	    if($_POST['sum'] < $check_vs_mc['min']){
		    $err[]="Можно выводить не менее ".$check_vs_mc['min']." BCR";
	    }	
    }elseif($check_vs_mc['err'] == '2'){
	    $err[] = 'Неправильный номер карты';
    }else{
	    $err[] = 'Карта не определилась';
    }
}
if(($_POST['system']=='webmoney') && ($_POST['sum'] < 10)){
    $err[]="Можно выводить не менее 10 BCR";
}
if($err_block){
    unset($err);
    $err[] = $err_block;
    $card=FALSE;setcookie ( 'card1', '',time()+60*60*24*30, '/');setcookie ( 'card2', '',time()+60*60*24*30, '/');setcookie ( 'card3', '',time()+60*60*24*30, '/');setcookie ( 'card4', '',time()+60*60*24*30, '/');
    $card1=FALSE;
}
if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
    $_POST['check1']='';
    $_POST['check2']='';
}
if(!$err[0] && !$err_block){//на данный момент - карты валидные, списание возможно
if($_POST['check2']=='no_telegram'){
    update_telegr($card1);
}
if($_POST['check1']=='' & $_POST['check2']==''){
$smscode=createsmscode($card1[phone]);
//проверка доверенного ip
if($smscode[1] != 'trust' && $smscode[1] != 'no_telegram'){
//    sms($card1[phone],'SMS-kod: '.$smscode[1].'; Snyatie '.number_format((float)$_POST['sum'], 2, ',', ' ').' BCR (RUB)');// na kartu *'.substr($card2[number],-4));
    sms_telegram($card1, $smscode[1], 'Снятие '.number_format((float)$_POST['sum'], 2, ',', ' ').' BCR (RUB)');// na kartu *'.substr($card2[number],-4));
    
}

?><script>$('#ajaxform').remove();</script>
<?if($err_alert){?>
    <div class="alert alert-info" role="alert"><?=$err_alert?></div>
<?}?>
<p class="text-center">Сумма для выдачи: <span class="target_commission" style="font-weight: bold"><?=(float)$_POST['sum'];?> BCR (RUB)</span></p>
<p class="text-center">Комиссия: <span class="target_commission" style="font-weight: bold"><?=$out-(float)$_POST['sum'];?> BCR (RUB)</span></p>
<p class="text-center">Сумма для списания: <span class="targer_amount" style="font-weight: bold"><?=$out;?> BCR (RUB)</span></p><form id="ajaxsms" onsubmit="$('#ajaxsms button[type=submit]').attr('disabled','disabled').text('обработка...');$('#new_sms').attr('disabled','disabled');var msg   = $('#ajaxsms').serialize();
        $.ajax({
          type: 'POST',
          url: 'ajax/withdraw.php',
          data: msg,
          success: function(data) {
            $('#ajaxresult').html(data);
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });return false;">
<input type="hidden" name="check1" value="<?=$smscode[0];?>">
<input type="hidden" name="action" value="<?=htmlspecialchars($_POST['action']);?>">
<input type="hidden" name="target" value="<?=htmlspecialchars($_POST['target']);?>">
<input type="hidden" name="system" value="<?=htmlspecialchars($_POST['system']);?>">
<input type="hidden" name="sum" value="<?=htmlspecialchars($_POST['sum']);?>">
<input type="hidden" name="b" value="<?=htmlspecialchars($_POST['b']);?>">
<input type='hidden' name='new_sms' value='0'>
<input type='hidden' name='delta_sms' value='30'>
<? if($smscode[1] == 'no_telegram'){?>
    <div class="form-group">
        <label>
            
            Для получения кодов подтверждения:<br>
            1. Подключите в Телеграм бота: <a href="https://telegram.me/SMS_MilitaryHolding2" target="_blank">@SMS_MilitaryHolding2_bot</a>;<br>
            2. Нажмите в Телеграм <i class="text-danger">START</i> - "Запуск бота" ссылка внизу экрана Телеграм;<br>
            3. Отправте боту код подтверждения <i class="text-danger"><?=$smscode[2]?></i>;<br>
            4. Нажмите "Подтвердить операцию";<br>
            5. В телеграм от бота придет подтверждение правильности кода;<br>
            
        </label>
    </div>
<?}elseif($smscode[1] != 'trust'){//проверка доверенного ip?>
<div class="form-group">
    <label>
        Код из СМС:<br>
        <button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
        <span class='label label-info' role='alert'>
            Через <ii id="delta_sms">30</ii> сек.
        </span>
    </label>
    <input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required>
</div>
<button type="submit" class="btn btn-success">Подтвердить операцию</button>
<?}
if($smscode[1] == 'trust' || $smscode[1] == 'no_telegram'){?>
    <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
    <button type="submit" class="btn btn-success center-block">Подтвердить операцию</button>
<?}?>
</form>

<script>
$('.bank .content').html('<b>Сумма для выдачи: <?=(float)$_POST['sum'];?> BCR</b><br><b>Комиссия: <?=$out-(float)$_POST['sum'];?> BCR</b><br><b>Будет списано: <?=$out;?> BCR</b><br><b>Введите код из СМС</b><div class="input input1"></div>');

$('input[name=check2]').on('change keyup click',function(){
$('.input1').text($(this).val());
});

$('#new_sms').click(function() {
    $('input[name=new_sms]').val('1');
    $('input[name=check2]').removeAttr('required');
    $('#ajaxsms').submit();
});

$(document).ready(function(){
    var delta_sms = 30;
    var timerId = setInterval(function(){
        $('#delta_sms').html(delta_sms);
        if(delta_sms == 0){
            $('#new_sms').removeAttr('disabled');
            $('#delta_sms').parent().html('');
            delta_sms = 30;
            clearInterval(timerId);
        }else{
            delta_sms--;
            $('input[name=delta_sms]').val(delta_sms);
        }
    },1000);
});

</script>

<?
}else{
if(checksmscode($_POST['check1'],$_POST['check2'],$card1[phone])){

$qiwi=(float)$_POST['sum'];
    $sum=(float)$_POST['sum'];
    
    $b = mysqli_escape_string($mysqli, $b);
    $info=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='bankomat' AND amount='$b'");
    $info=mysqli_fetch_assoc($info);
    $token_proxy = json_decode($info["token"], true);
    $card2 = $token_proxy["card"];
    $card2 = getcard($card2);
    $token = $token_proxy["token"];
    $proxy_ip = $token_proxy["ip"];
    $proxy_port = $token_proxy["port"];
    $proxy_usr = $token_proxy["usr"];
    $proxy_pass = $token_proxy["pass"];
//    $token = $info["token"];

	if( $curl = curl_init() ) {
		$linkas_qiwi = htmlspecialchars($_POST['target']);
        if($_POST['system']=='qiwi'){
            curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/sinap/api/v2/terms/99/payments');
        }
        if($_POST['system']=='ya'){
            curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/sinap/api/v2/terms/26476/payments');
        }

	if($_POST['system']=='visa_mastercard'){
            $system_card = $check_vs_mc['cod_vs_mc'];//$card1['cod_vs_mc'];
            curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/sinap/api/v2/terms/'.$system_card.'/payments');
            
            $myecho = " system_card_vs_mc: " . json_encode($system_card);
            mysqli_query($mysqli, "INSERT INTO qaz_barter (event) values('$myecho')");
            $myecho = " linkas_qiwi_vs_mc: " . json_encode($linkas_qiwi);
			mysqli_query($mysqli, "INSERT INTO qaz_barter (event) values('$myecho')");
        }

	if($_POST['system']=='webmoney'){
	    $sum = $sum/0.98; //2% за перевод
            $system_card = '31271';
            curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/sinap/api/v2/terms/'.$system_card.'/payments'); 
        }
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");                                                             
	    $time = date("d.m.Y H:i:s");

	    //$linkas_qiwi = htmlspecialchars($_POST['target']);
	    $s = $sum;
	    $sms_send = 'Вывод BCR';

	    //eval("\$sms_send = \"$sms_send\";");

	    $id = 1000 * time();
	    
	    $json_data = '{"id":"' . $id . '","sum":{"amount":' . str_replace(',','.',(float)$sum) . ',"currency":"643"},"paymentMethod":{"type":"Account","accountId":"643"}, "comment":"' . $sms_send . '","fields":{"account":"' . $linkas_qiwi . '"}}';
						      
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);    			
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                                                                                                                      
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($json_data),
		'Authorization: Bearer ' . $token)//$qiwi_token
	    ); 
            curl_setopt($curl, CURLOPT_PROXY, $proxy_ip);
            curl_setopt($curl, CURLOPT_PROXYPORT, $proxy_port);
            curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
		    
		    $out = curl_exec($curl);
			//sleep(10);
			
			$out_err = curl_error($curl);
			`echo " " >>/home/bartercoin/tmp/qaz`;
			`echo " b: "  $b >>/home/bartercoin/tmp/qaz`;
			`echo " sum: "  $sum >>/home/bartercoin/tmp/qaz`;
			$tmp_id = $card1['id'];
			$tmp_d = date("d-m-Y H:i:s" ,time());
			`echo " time: " $tmp_d  >>/home/bartercoin/tmp/qaz`;
			`echo " card1_id: " $tmp_id  >>/home/bartercoin/tmp/qaz`;
			`echo " token: "  $token >>/home/bartercoin/tmp/qaz`;
			`echo " proxy_ip: "  $proxy_ip >>/home/bartercoin/tmp/qaz`;
			`echo " proxy_port: "  $proxy_port >>/home/bartercoin/tmp/qaz`;
			`echo " proxy_usr: "  $proxy_usr >>/home/bartercoin/tmp/qaz`;
			`echo " proxy_pass: "  $proxy_pass >>/home/bartercoin/tmp/qaz`;
			$myecho = json_encode($out,JSON_UNESCAPED_UNICODE);
            `echo " out: "  $myecho >>/home/bartercoin/tmp/qaz`;
            $myecho = json_encode($out_err, JSON_UNESCAPED_UNICODE);
            `echo " out_err: "  $myecho >>/home/bartercoin/tmp/qaz`;
            
            if($_POST['system']=='visa_mastercard'){
	            $myecho = " out_visa_mc: " . json_encode(json_decode($out), JSON_UNESCAPED_UNICODE);
				mysqli_query($mysqli, "INSERT INTO qaz_barter (event) values('$myecho')");
				$myecho = " out_err_visa: " . json_encode(json_decode($out_err), JSON_UNESCAPED_UNICODE);
				mysqli_query($mysqli, "INSERT INTO qaz_barter (event) values('$myecho')");
			}

		    if (strpos($out,'Accepted') && !isset($err_card)) {
		    	//отправлено. лог и смс
transaction($card1,$card2,(float)$_POST['sum'],'Вывод БР на счёт '.$systems[$_POST['system']].' '.htmlspecialchars($_POST['target']), 1, $comission, $mincomission, $b);
//transaction($card1,$card2,(float)$_POST['sum'],'Вывод БР на счёт '.$systems[$_POST['system']].' '.htmlspecialchars($_POST['target']),1);
?><div class="alert alert-success">Вывод успешно завершён</div><script>

$('.bank .check').html('<div style="text-align:center;font-weight:bold;border-bottom:1px dashed">Выдача наличных</div><?=date('Y-m-d H:i:s');?><br><?=(float)$_POST['sum'];?> руб.<br><?=htmlspecialchars($systems[$_POST['system']]);?><br>BCR успешно выведены<div style="border-bottom:1px dashed;margin-bottom:5px;"></div><audio src="<?=$baseHref?>inc/sounds/pereschet-deneg-v-bankomate.mp3" autoplay="autoplay"></audio>');
$('.check').slideDown(2000);
$('.bank .content').html('<div style="text-align:center;font-size:55px;"><i class="fa fa-check"></i></div><div style="text-align:center;">УСПЕШНО</div>BCR успешно выведены');
setTimeout(function(){$('.money').addClass('active');},1800);

</script><?

header('Connection: close');
//header("Content-Length: 3" );
//header("Content-Encoding: none");
//header("Accept-Ranges: bytes");
ob_end_flush();
ob_flush();
flush();
sleep(1);

//привязка карты
add_card(htmlspecialchars($_POST['target']), htmlspecialchars($_POST['system']), (int)$card1['id'], $check_vs_mc['cod_vs_mc']); 

	//обновление счета
	if( $curl = curl_init() ) {

		curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
         
		// curl_setopt($curl, CURLOPT_HEADER, TRUE);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
                                                                                                                                                                                                 
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
			'Content-Type: application/json',
		    'Authorization: Bearer ' . $token)//$qiwi_token
		);
        curl_setopt($curl, CURLOPT_PROXY, $proxy_ip);
        curl_setopt($curl, CURLOPT_PROXYPORT, $proxy_port);
        curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_usr.':'.$proxy_pass);
	    
	    $out_count = curl_exec($curl);

	}

	curl_close($curl);

	$out_count = json_decode($out_count);

	$out_count = $out_count->accounts[0]->balance->amount;
	put_bank($mysqli, $b, $out_count);//file_put_contents('/home/bartercoin/tmp/bankbalance'.$b, $out_count);
	// $cur_date = date("d.m.Y H:i:s");

	//mysql_query("UPDATE adnins set qWbalans='$out_count' where id='1'");
		    }else{
				if(strpos($out,'message')){
					$message = json_decode(json_encode(json_decode($out), JSON_UNESCAPED_UNICODE), true);
					$err_card = $message['message'];
				}
				?><div class="alert alert-danger">Ошибка при выводе BCR: <?=$err_card?></div>
				<script>

$('.bank .check').html('<div style="text-align:center;font-weight:bold;border-bottom:1px dashed">Выдача наличных</div><?=date('Y-m-d H:i:s');?><br><?=(float)$_POST['sum'];?> руб.<br><?=htmlspecialchars($systems[$_POST['system']]);?><br>ОТКАЗАНО<br>Ошибка при зачислении средств<div style="border-bottom:1px dashed;margin-bottom:5px;"></div>');
$('.check').slideDown(2000);
$('.bank .content').html('<div style="text-align:center;font-size:55px;"><i class="fa fa-times"></i></div><div style="text-align:center;">ОТКАЗАНО</div>Ошибка при зачислении средств');
//setTimeout(function(){$('.money').addClass('active');},1800);

</script><?die();}
		
		// sleep(1);
	}

	curl_close($curl);



}else{?><div class="alert alert-danger">СМС код введён не верно</div><script>

$('.bank .check').html('<div style="text-align:center;font-weight:bold;border-bottom:1px dashed">Выдача наличных</div><?=date('Y-m-d H:i:s');?><br><?=(float)$_POST['sum'];?> руб.<br><?=htmlspecialchars($systems[$_POST['system']]);?><br>ОТКАЗАНО<br>Неверный ПИН из СМС<div style="border-bottom:1px dashed;margin-bottom:5px;"></div>');
$('.check').slideDown(2000);
$('.bank .content').html('<div style="text-align:center;font-size:55px;"><i class="fa fa-times"></i></div><div style="text-align:center;">ОТКАЗАНО</div>Неверный ПИН из СМС');
//setTimeout(function(){$('.money').addClass('active');},1800);

</script><?}
}
}else{?>
<div class="alert alert-danger">
<?foreach($err as $error){
if($flag)echo(', ');$flag=1;echo($error);
}?>
</div><script>$('#ajaxform button[type=submit]').removeAttr('disabled').text('Вывести BCR');</script>
<?}
?>


