<?

if($_COOKIE['card1']){$card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);}

if($_GET['card_form']){
$card2=getcard(mysqli_escape_string($mysqli, $_GET['card_form']));
if($card2['id']==0 || $card2['black'] == 1)$err[]='Карта привязанная к магазину не активна';
if((float)$_GET['sum']<=0)$err[]="Сумма перевода должна быть больше 0";

//определение комиссии
$comiss_base=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT comission FROM comissions WHERE `sum`<='". (int)$card['balance']. "' ORDER BY `sum` DESC LIMIT 1"));
if($comiss_base){
	$comission = 1 + $comiss_base['comission']/100;
}
	
$out=round((float)$_GET['sum']*$comission,0);
if(($_GET['sum']*($comission-1))<$mincomission)$out=round((float)$_GET['sum']+$mincomission,2);
	
if(!$err[0]){
$name = $card['name1'].' '.$card['name2'].' '.$card['name3'];
$comment = htmlspecialchars($_GET['comment']).', '.$name.', карта '.$card['number'];
//$_GET['comment'] = $comment;
?><p class="text-center">Магазин: <span style="font-weight: bold"><?=htmlspecialchars($_GET['targets']);?></span></p>
<!--<p class="text-center">ID платежа: <span style="font-weight: bold"><?htmlspecialchars($_GET['id']);?></span></p>-->
<p class="text-center">Описание платежа: <span style="font-weight: bold"><?=$comment;?></span></p>
<p class="text-center">Комиссия: <span class="target_commission" style="font-weight: bold"><?=$out-(float)$_GET['sum'];?> BCR (RUB)</span></p>
<p class="text-center">Сумма платежа: <span class="targer_amount" style="font-weight: bold"><?=(float)$out;?> BCR (RUB)</span></p>
<?if($_POST['fromnum']==''){?>

<form method="post" id="savecard1">
    							<input autofocus="" type="text" class="form-control cardnum" placeholder="Номер карты" name="fromnum"  onkeydown="setTimeout(function(){
$('#savecard1').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('#savecard1 [name=savenum]').val().charAt(0)==3)$('#savecard1').addClass('ae');
if($('#savecard1 [name=savenum]').val().charAt(0)==2)$('#savecard1').addClass('mi');
if($('#savecard1 [name=savenum]').val().charAt(0)==4)$('#savecard1').addClass('visa');
if($('#savecard1 [name=savenum]').val().charAt(0)==5)$('#savecard1').addClass('mc');
if($('#savecard1 [name=savenum]').val().charAt(0)==6)$('#savecard1').addClass('ma');
if($('#savecard1 [name=savenum]').val().charAt(0)==1)$('#savecard1').addClass('bc');
},1);"<?if($card)echo(' value="'.substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4).'"');?> required=""><br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="Месяц" name="frommonth"<?if($card)echo(' value="'.$card['expiremonth'].'"');?> required=""></div>
<div class="col-sm-2  col-xs-12 text-center" style="line-height: 34px;font-size: 20px;color: white;">/</div>
<div class="col-sm-5  col-xs-12"><input type="text" class="form-control cardnum" placeholder="Год" name="fromyear"<?if($card)echo(' value="'.$card['expireyear'].'"');?> required=""></div>
</div>

<br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="CVC" name="fromcvc"<?if($card)echo(' value="'.$card['cvc'].'"');?> required=""></div>
<div class="col-sm-7  col-xs-12"><input type="submit" class="btn btn-success btn-block" value="Оплатить"></div>
</div>
<p style="color:red;padding: 30px;display:none;">Оплата<br>только с карт BarterCoin</p><script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';
//
$('#savecard1 [name=savenum]').mask('9999 9999 9999 9999',{completed:function(){$('#savecard1 [name=savemonth]').focus();}});

$('#savecard1 [name=savemonth]').mask('99',{completed:function(){$('#savecard1 [name=saveyear]').focus();}});

$('#savecard1[name=saveyear]').mask('99',{completed:function(){$('#savecard1 [name=savecvc]').focus();}});

$('#savecard1 [name=savecvc]').mask('999',{completed:function(){$('#savecard1 input[type=submit]').focus();}});

///$('[name=sum]').mask('000.000.000.000.000,00',{reverse: true,completed:function(){$('#submit123').focus();}});



});</script><script>
setTimeout(function(){
$('#savecard1').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=fromnum]').val().charAt(0)==3)$('#savecard1').addClass('ae');
if($('[name=fromnum]').val().charAt(0)==2)$('#savecard1').addClass('mi');
if($('[name=fromnum]').val().charAt(0)==4)$('#savecard1').addClass('visa');
if($('[name=fromnum]').val().charAt(0)==5)$('#savecard1').addClass('mc');
if($('[name=fromnum]').val().charAt(0)==6)$('#savecard1').addClass('ma');
if($('[name=fromnum]').val().charAt(0)==1)$('#savecard1').addClass('bc');
},1);
</script><style>
#savecard1{border: 2px dashed #dddfe0;    padding: 30px;
    border-radius: 14px;margin:0 auto;
    transition: .3s ease all;min-height: 276px;max-width:420px;}
#savecard1.ae{background-color: #007cc2;background-image:url(img/cards/ae.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.visa{background-color: #ffa336;background-image:url(img/cards/visa.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.mc{background-color: #971010;background-image:url(img/cards/mc.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.ma{background-color: #0079f0;background-image:url(img/cards/ma.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.mi{background-color: #4ca847;background-image:url(img/cards/mi.png);background-position: 97% 97%;background-repeat:no-repeat;}
#savecard1.bc{background-color: #3d2b1f;background-image:url(img/cards/bc.png);background-position: 97% 97%;background-repeat:no-repeat;}

#savecard1.ae p{display:block !important;}
#savecard1.visa p{display:block !important;}
#savecard1.mc p{display:block !important;}
#savecard1.ma p{display:block !important;}
#savecard1.mi p{display:block !important;}
</style>

</form>
<?}else{
$card1=getcard($_POST['fromnum'],$_POST['frommonth'],$_POST['fromyear'],$_POST['fromcvc']);
if(($card1['id']==$card2['id']) & $card1['id']>0)$err[]='Вы ввели 2 одинаковые карты';
if($card1['id']==0)$err[]='Вы ввели неверные данные своей карты';
if(($card1['balance']+$card1['lim'])<$out)$err[]="Недостаточно средств на вашей карте";
$sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  
if(($sum['SUM(sum)']+$out)>$card1['monthlim'])$err[]="Превышен месячный лимит";
	
if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
    $_POST['check1']='';
    $_POST['check2']='';
}
	
if(!$err[0]){//на данный момент - карты валидные, списание возможно
	if($_POST['check1']=='' & $_POST['check2']==''){
		$smscode=createsmscode($card1[phone]);
		if($smscode[1] != 'trust'){
			sms($card1[phone],'SMS-kod: '.$smscode[1].'; Oplata '.number_format((float)$out, 2, ',', ' ').' BCR (RUB)');
		}
		?><form method="post" id="ajaxsms">
		<input type="hidden" name="check1" value="<?=$smscode[0];?>">
		<input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
		<input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
		<input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
		<input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
		<input type="hidden" name="comment" value="<?=$comment?>">
		<?if($smscode[1] != 'trust'){//проверка доверенного ip?>
		<div class="form-group">
			<input type='hidden' name='new_sms' value='0'>
			<input type='hidden' name='delta_sms' value='30'>
			<div class="form-group">
				<label>
					Код из СМС:<br>
					<button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
					<span class='label label-info' role='alert'>
						 <ii id="delta_sms">30</ii> сек.
					</span>
				</label>
				<input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required>
                <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
                    Телеграмм бот  для принятия кода
                </a>
			</div>
		</div>
		<button type="submit" class="btn btn-success">Подтвердить операцию</button>
		<?}else{?>
            <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
            <button type="submit" class="btn btn-success center-block">Подтвердить операцию</button>
        <?}?>
		</form>
		<script src="../js/jquery.min.js"></script>
		<script>
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
				if(transaction($card1,$card2,(float)$_GET['sum'],'Оплата заказа '.$_GET['id'].' в магазине '.$data['name'], 0, $comission, $mincomission)){ ?>
					<div class="alert alert-success">Оплата успешно завершена</div><script>   window.location = "<?=$_GET['return'];?>"</script>
				<?}else{?>
					<div class="alert alert-danger">Ошибка</div>
				<?}
		}else{?>
			<div class="alert alert-danger">СМС код введён не верно</div>
		<?}
	}

}else{?>
	<div class="alert alert-danger">
	<?foreach($err as $error){
		if($flag)echo(', ');$flag=1;echo($error);
	}
}
}?><?
}else{?>
<div class="alert alert-danger">
<? foreach($err as $error){
if($flag)echo(', ');$flag=1;echo($error);
}?>
</div>
<? }
}else{?><div class="alert alert-danger">Магазин не найден</div><?}


?>
