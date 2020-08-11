<?

if(isset($_GET['card'])){
    $card=getcard($_GET['card']);
}

$data=mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM `shops` WHERE id='".(int)$_GET['shop']."' LIMIT 1;"));
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
        if($_GET['oper'] != '2' && $_GET['oper'] != '5'){?>
            <p class="text-center">Действие: <span style="font-weight: bold"><?=htmlspecialchars($data['name']);?>. При отмене требования на бирже, сумма и акции вернутся на Ваш счет</span></p>
            <p class="text-center">ID платежа: <span style="font-weight: bold"><?=htmlspecialchars($_GET['id']);?></span></p>
            <p class="text-center">Описание: <span style="font-weight: bold"><?=htmlspecialchars($_GET['comment']);?></span></p>
            <p class="text-center">Комиссия: <span class="target_commission" style="font-weight: bold"><?=$out-(float)$_GET['sum'];?> BCR (RUB)</span></p>
            <p class="text-center">Сумма платежа: <span class="targer_amount" style="font-weight: bold"><?=(float)$out;?> BCR (RUB)</span></p>
        <?}elseif($_GET['oper'] == '2'){
            $_POST['check1'] = '1';
            $_POST['check1'] = '1';
            $_POST['fromnum'] = $card['number'];
            $_POST['frommonth'] = $card['expiremonth'];
            $_POST['fromyear'] = $card['expireyear'];
            $_POST['fromcvc'] = $card['cvc'];
        }
		
		if($_POST['fromnum']==''){?>
			
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
				<div class="col-sm-7  col-xs-12"><input type="submit" class="btn btn-success btn-block" value="Перевести"></div>
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
			if(($card1['balance']+$card1['lim'])<$out & $_GET['oper'] != '2')$err[]="Недостаточно средств на вашей карте";
			$sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  
			if((($sum['SUM(sum)']+$out)>$card1['monthlim']) & $_GET['operation'] != '2')$err[]="Превышен месячный лимит";
			
			if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
                $_POST['check1']='';
                $_POST['check2']='';
            }
			
			if(!$err[0]){//на данный момент - карты валидные, списание возможно
				if($_POST['check1']=='' & $_POST['check2']==''){
					$smscode=createsmscode($card1[phone], $card1['number']);
					if($smscode[1] != 'trust'){
						sms($card1[phone],'SMS-kod: '.$smscode[1].'; Oplata '.number_format((float)$out, 2, ',', ' ').' BCR (RUB)');
					}
					?><form method="post" id="ajaxsms">
					<input type="hidden" name="check1" value="<?=$smscode[0];?>">
					<input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
					<input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
					<input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
					<input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
					<input type='hidden' name='new_sms' value='0'>
                    <input type='hidden' name='delta_sms' value='30'>
                    <?if($smscode[1] != 'trust'){//проверка доверенного ip?>
                    <div class="form-group">
                        <label>
                            Код из СМС:<br>
                            <button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
                            <span class='label label-info' role='alert'>
                                <ii id="delta_sms">30</ii> сек.
                            </span>
                        </label><br><br>
                        <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
                            Телеграмм бот  для принятия кода
                        </a>
                        <input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required>
                    </div>
					<button type="submit" class="btn btn-success">Подтвердить операцию</button>
					<?}else{?>
                        <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
                        <button type="submit" class="btn btn-success center-block">Подтвердить операцию</button>
                    <?}?>
					</form><?
				}else{
					if(checksmscode($_POST['check1'],$_POST['check2'],$card1[phone]) | $_GET['oper'] == '2'){
						$curl = curl_init();
						curl_setopt($curl, CURLOPT_URL, $data['url']);
						curl_setopt($curl, CURLOPT_POST, 1);
						curl_setopt($curl, CURLOPT_POSTFIELDS, array(
						"id" => (int)($_GET['id']),
						"sum" => (float)$_GET['sum'],
						"secret" => md5($_GET['shop'].$data['key2'].$_GET['id'].(float)$_GET['sum']),
						));
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
						
						$data1 = curl_exec($curl);
						
						`echo "                "   >>/home/bartercoin/tmp/qaz`;
						$myecho = date("d.m.Y H:i:s");
						`echo ""  $myecho >>/home/bartercoin/tmp/qaz`;
						$myecho = json_encode($data1);
						`echo " data1: "  $myecho >>/home/bartercoin/tmp/qaz`;
						$c_info = curl_getinfo($curl);
						$myecho = json_encode($c_info);
						`echo " curl_getinfo: "  $myecho >>/home/bartercoin/tmp/qaz`;
						$myecho = json_encode(curl_getinfo($curl, CURLINFO_SSL_VERIFYRESULT));
						`echo " CURLINFO_SSL_VERIFYRESULT: "  $myecho >>/home/bartercoin/tmp/qaz`;
						$myecho = json_encode($c_info['certinfo']);
						`echo " certinfo: "  $myecho >>/home/bartercoin/tmp/qaz`;
						$myecho = curl_error($curl);
						`echo " curl_error: "  $myecho >>/home/bartercoin/tmp/qaz`;
						
						curl_close($curl);
						
						if($data1=='YES12'){//покупка отложенная(лимитная)
							if(transaction($card1,$card2,(float)$_GET['sum'],'Перевод id='.$_GET['id'].' в '.$data['name'], 0, $comission, $mincomission)){?>
								<div class="alert alert-success">Перевод <?=((float)$_GET['sum'])?> BCR на счет биржы успешно завершен</div><!--script>   window.location = "<?$_GET['return'];?>"</script-->
							<?}else{?>
								<div class="alert alert-danger">Ошибка</div>
							<?}
                        }elseif(strpos($data1,'YES11')){
							$deals = json_decode($data1, true);//карты и суммы для перечисления продавцам
                            $deals = $deals[1];
                            $deals = json_decode($deals, true);
                            if(!$deals['count'][0]){?>
                                <div class="alert alert-danger">Ошибка перевода</div>
                            <?
                                die();
                            }
                            $card1=getcard($_POST['fromnum'], $_POST['frommonth'], $_POST['fromyear'], $_POST['fromcvc']);
                            $card2 = getcardbyid($data['card']);
                            if(transaction($card1,$card2,(float)$_GET['sum'],'Перевод id='.$_GET['id'].' в '.$data['name'], 0, $comission, $mincomission)){?>
								<div class="alert alert-success">Перевод <?=((float)$_GET['sum'])?> BCR на счет биржы успешно завершен</div>
							<?}else{?>
								<div class="alert alert-danger">Ошибка: Перевод на счет биржы</div>
							<?
                                die();
                            }
                            //перевод продавцам
                            $i = 1;
                            foreach($deals['count'] as $key=>$count){
                                $card_b = mysqli_escape_string($mysqli, $deals['card'][$key]);
                                $count = (int)$count;
                                $price = (float)$deals['price'][$key];
                                $sum = $count * $price;
                                $card_sum['sum'][] = $sum;
                                $card_b = getcard($card_b);
                                if($card_b){
                                    $card2 = getcardbyid($data['card']);
                                    transaction($card2,$card_b,$sum,'Продажа акций BCR '.$count.' шт. по '.$price.' состоялась', 0, $comission, $mincomission);
                                    sms($card_b['phone'],'Karta *'.substr($card_b[number],-4).'; Prodaza akciy BCR: '.$count.' akc po '.$price.' BCR; vsego '.$sum. ' BCR sostoyalas');
                                }else{
                                    $card_err['id'][] = $deals['id'][$key];
                                    $card_err['akcion_id'][] = $deals['akcion_id'][$key];
                                    $card_err['count'][] = $count;
                                    $card_err['price'][] = $price;
                                    $card_err['sum'][] = $count * $price;
                                ?>
                                    <div class="alert alert-danger">Ошибка перевода <?=($count * $price)?> BCR на карту <?=$deals['card'][$key]?></div>
                                <?}
                                $i++;
                            }
                            //отмена не состоявшихся переводов продавцам
                            if(isset($card_err)){
                                $sum_err = array_sum($card_err['sum']);
                                $count_err = array_sum($card_err['count']);
                                $card1=getcard($_POST['fromnum'], $_POST['frommonth'], $_POST['fromyear'], $_POST['fromcvc']);
                                $card2 = getcardbyid($data['card']);
                                if(transaction($card2, $card1, $sum_err, 'Перевод id='.$_GET['id'].' отмена '.$data['name'], 0, $comission, $mincomission)){?>
                                    <div class="alert alert-danger">Отмена перевода <?=$sum_err?> BCR на счет биржы успешно завершен</div>
                                <?}else{?>
                                    <div class="alert alert-danger">Ошибка: Отмена перевода на счет биржы</div>
                                <?}
                                $json_data = json_encode($card_err);
                                $id_c = (int)$_GET['id'];
                                
                                $post_data = array(
                                    "secret" => md5($_GET['shop'].$data['key2'].$_GET['id'].(float)$_GET['sum']),
                                    "id" => (int)($_GET['id']),
                                    "sum" => (float)$_GET['sum'],
                                    "card_err" => $json_data,
                                    
                                );
 
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_URL, $data['url']);
                                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); 
                                
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                                $data1 = curl_exec($curl);
                                $data1_err = curl_error($curl);
                                curl_close($curl);
 
                                if($data1=='YES_ERR'){?>
                                    <div class="alert alert-danger">Отмена покупки <?=$count_err?> акций на сумму <?=$sum_err?> BCR на бирже успешно завершена</div>
                                <?}
                            }
                            $sms_count = array_sum($deals['count']) - array_sum($card_err['count']);
                            $sms_sum = array_sum($card_sum['sum']) - array_sum($card_err['sum']);
                            sms($card1['phone'],"Pokupka akciy BCR: ".$sms_count." na summu ".$sms_sum." BCR sostoyalas");
                            ?>
                            <div class="alert alert-success">Покупка акций BCR: <? echo(array_sum($deals['count']) - array_sum($card_err['count']))?> на сумму <? echo(array_sum($card_sum['sum']) - array_sum($card_err['sum']))?> BCR состоялась.
                            </div>
                            <? if(isset($card_err)){?>
                            <div class="alert alert-info">Оставшиеся <? echo(array_sum($card_err['count']))?>акций можете купить в другой сделке
                            </div>
                            <?}?>
                            
						<?}elseif(strpos($data1,'YES21')){//продажа рыночная
							$deals = json_decode($data1, true);
                            $deals = $deals[1];
                            $deals = json_decode($deals, true);//карты и суммы для смс покупателям
                            if(!$deals['count'][0]){?>
                                <div class="alert alert-danger">Ошибка перевода</div>
                            <?
                                die();
                            }
                            if(transaction($card2,$card1,(float)$_GET['sum'],'Перевод id='.$_GET['id'].' из '.$data['name'], 0, $comission, $mincomission)){
                                sms($card1['phone'],"Prodazha akciy BCR: ". array_sum($deals['count']). " na summu ".(float)$_GET['sum']." BCR sostoyalas");
                                ?>
								<div class="alert alert-success">Перевод <?=((float)$_GET['sum'])?> BCR на счет <?=$card1['number']?> продавца успешно завершен</div>
								<div class="alert alert-success">Продажа акций BCR <?=array_sum($deals['count'])?> шт. на сумму <?=(float)$_GET['sum']?> успешно завершена</div>
							<?}else{?>
								<div class="alert alert-danger">Ошибка: Перевод на счет продавца</div>
							<?
                                die();   
                            }
                            //смс покупателям
                            $i = 1;
                            foreach($deals['count'] as $key=>$count){
                                $card_b = mysqli_escape_string($mysqli, $deals['card'][$key]);
                                $count = (float)$count;
                                $price = (float)$deals['price'][$key];
                                $sum = $count * $price;
                                $card_b = getcard($card_b);
                                
                                sms($card_b['phone'],"Karta *".substr($card_b[number],-4).";Pokupka akciy BCR: ".$count." akc po ".$price." BCR; vsego ".$sum. " BCR sostoyalas");
                            }
                            
						}else{?>
							<div class="alert alert-danger">Биржа вернула ошибку. <?=htmlspecialchars($data1);?></div>
						<?}
					}else{?>
						<div class="alert alert-danger">СМС код введён не верно</div>
					<?}
				}
			}else{?>
				<div class="alert alert-danger">
				<?foreach($err as $error){
					if($flag)echo(', ');$flag=1;echo($error);
				}?>
                </div>
			<?}
		}?><?
	}else{?>
		<div class="alert alert-danger">
		<?foreach($err as $error){
			if($flag)echo(', ');$flag=1;echo($error);
		}?>
		</div>
	<?}
}else{?><div class="alert alert-danger">Магазин не найден</div><?}?>
<br>
<a href="<?=$_GET['return'];?>" class="button button-info">Вернуться на биржу</a>

<script src="../js/jquery.min.js"></script>
<script>
$('#new_sms').click(function() {
    $('input[name=new_sms]').val('1');
    $('input[name=check2]').removeAttr('required');
    $('#ajaxsms').submit();
});

$(document).ready(function(){
//    alert('entrance');
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
        //$('.tobank2').remove();
        //$(".tobank").clone().addClass('tobank2').removeClass('tobank').appendTo(".bank .screen");
    },1000);
});
</script>

