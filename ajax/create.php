<?php
//рекаптча
//site key 6LdTFmsUAAAAAD_AHFItOC2bPZZP5JAx5l514Y8h   
//secret key 6LdTFmsUAAAAAMdd8yecByBuUk7W2flAOFiSrMth

require('../inc/init.php');

//$myecho = $_POST['g-recaptcha-response'];
////`echo " _POST[g-recaptcha-response]: "  $myecho >>/tmp/qaz`;
//$myecho =  " _POST[g-recaptcha-response]: " . $myecho;
//$foptmp = fopen($baseHref . 'tmp/qaz.txt', "w");
//fwrite($foptmp, $myecho . PHP_EOL);
//fclose($foptmp);
//die();

//рекаптча <!--убрать коммент для рекапчи-->
if($_POST['check1']=='' & $_POST['check2']==''){
    if($curl = curl_init()){
        $query = array(
            'secret' => '6LcwhzYUAAAAAJ_gz9MaYcjZDWTg8TV7fOhdLuGP',
            'response' => $_POST['g-recaptcha-response'],
        );

        curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query); 

        $out = curl_exec($curl);

        curl_close($curl);

        $out = json_decode($out, true);
    }

    if(!$out['success']){
        $err[] = "Вы робот?";
    }  
}
//<!--убрать коммент для рекапчи-->

if($_COOKIE['not_allow'] || $_COOKIE['card1']) $err[]='У Вас уже есть карта.'; //<!--убрать коммент для cookie-->

$myecho = json_encode($_COOKIE['not_allow']);
`echo " _COOCKIE[not_allow]: "  $myecho >>/tmp/qaz`;

$phone = clear_phone(mysqli_escape_string($mysqli,$_POST['phone']));
$phone = str_split($phone);
$phone = implode("{1,1}.*", $phone);
$phone = "^.*". $phone . "{1,1}.*$";
//var_dump($phone);
$ip_reg = $_SERVER['HTTP_X_REAL_IP'];

$res = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT id FROM accounts WHERE ip_reg = '$ip_reg' OR phone REGEXP '$phone'"));
if($res['id']) $err[]='';

//$myecho = $res['id'];
//`echo " res['id']: "  $myecho >>/tmp/qaz`;

//проверить телефон и ip на совпадение зоны

$phone_base = '+' . mysqli_escape_string($mysqli,$_POST['phone']);
$phone_utc = phone_utc($phone_base); //узнать зону телефона
$info_ip = info_ip($ip_reg);
$ip_utc = json_decode($info_ip, true);
//
//$myecho = json_encode($phone_utc);
//`echo " phone_utc: "  $myecho >>/home/bartercoin/tmp/qaz`;
//$myecho = json_encode($ip_utc['region']['utc']);
//`echo " ip_utc['region']['utc']: "  $myecho >>/home/bartercoin/tmp/qaz`;
//
//if($phone_utc <> $ip_utc['region']['utc']){
//	$err[] = "Отказ в регистрации";
//}

if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
    $_POST['check1']='';
    $_POST['check2']='';
}

if(!$err[0]){//на данный момент - карта валидная, можно активировать 
    if($_POST['check1']=='' & $_POST['check2']==''){
        //отправить смс
        $smscode=createsmscode($_POST['phone'], '', 0);
        sms($_POST['phone'],'SMS-kod: '.$smscode[1].'; Snyatie '.number_format((float)$_POST['sum'], 2, ',', ' ').' BCR (RUB)');// na kartu *'.substr($card2[number],-4));
    ?>  
        <!--удалить форму-->
        <script>$('#ajaxform').remove();</script>
        <script>
			$('#ajaxform button[type=submit]').removeAttr('disabled').text('Активировать карту');
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
        <div class="alert alert-success">На Ваш номер отправлен код для активации карты</div>

        <form id="ajaxsms" onsubmit="$('#ajaxsms button[type=submit]').attr('disabled','disabled').text('обработка...');$('#new_sms').attr('disabled','disabled');var msg   = $('#ajaxsms').serialize();
            $.ajax({
              type: 'POST',
              url: 'ajax/create.php',
              data: msg,
              success: function(data) {
                $('#ajaxresult').html(data);
              },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });return false;">
            <input type="hidden" name="check1" value="<?=$smscode[0];?>">
            <input type="hidden" name="name1" value="<?=htmlspecialchars($_POST['name1']);?>">
            <input type="hidden" name="name2" value="<?=htmlspecialchars($_POST['name2']);?>">
            <input type="hidden" name="name3" value="<?=htmlspecialchars($_POST['name3']);?>">
            <input type="hidden" name="phone" value="<?=htmlspecialchars($_POST['phone']);?>"><!--$_POST['sum']-->
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
                <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
                    Телеграмм бот  для принятия кода
                </a>
				<input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required>
			</div>
            <button type="submit" class="btn btn-success">Активировать карту</button>
        </form>
    <?
    }else{
        if(checksmscode($_POST['check1'],$_POST['check2'],$_POST['phone'])){
            $cicl = 1;
            while($cicl){
                $number = '1100' . strval(rand(0,9)).strval(rand(0,9)).strval(rand(0,9)).strval(rand(0,9)) . strval(rand(0,9)).strval(rand(0,9)).strval(rand(0,9)).strval(rand(0,9)) . strval(rand(0,9)).strval(rand(0,9)).strval(rand(0,9)).strval(rand(0,9));
                //lhun create
                $number = luhn_create($number);
                
                $res = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT id FROM accounts WHERE number = '$number'"));
                $res = $res['id'];
                //lhun test
                $luhn_test = luhn_test($number);

                if(!$res && $luhn_test){
                    $cicl = 0;
                }
            }

            $expiremonth = '12';
            $expireyear = '30';

            $cicl = 1;
            while($cicl){      
                $cvc = strval(rand(1,9)) . strval(rand(0,9)) . strval(rand(0,9));
                if($cvc != '666'){
                    $cicl = 0;
                }
            }

            $activated = '1';
            $balance = '0.00';
            $lim = '0';
            $monthlim = '5000';//'1500';
            $withdrawlim = '100';//'50';
            $bankomats = '{"allow":[1,8]}';

            $name1 = mysqli_escape_string($mysqli,$_POST['name1']);
            $name2 = mysqli_escape_string($mysqli,$_POST['name2']);
            $name3 = mysqli_escape_string($mysqli,$_POST['name3']);
            $phone=preg_replace('/^(\+?8)(.+)/', '7$2', $phone);

            if($phone_utc){
                $no_err = mysqli_query($mysqli,"INSERT INTO `accounts` (number, expiremonth, expireyear, cvc, activated, balance, bankomats, lim, monthlim, withdrawlim, name1, name2, name3, phone, phone_utc, ip_reg, info_ip) VALUES ('$number', '$expiremonth', '$expireyear', '$cvc', '$activated',  '$balance', '$bankomats', '$lim', '$monthlim', '$withdrawlim', '$name1', '$name2', '$name3', '$phone_base', '$phone_utc', '$ip_reg', '$info_ip')");
	            sql_err($mysqli, 'INSERT INTO accounts');
            }else{
                $no_err = mysqli_query($mysqli,"INSERT INTO `accounts` (number, expiremonth, expireyear, cvc, activated, balance, bankomats, lim, monthlim, withdrawlim, name1, name2, name3, phone, ip_reg, info_ip) VALUES ('$number', '$expiremonth', '$expireyear', '$cvc', '$activated',  '$balance', '$bankomats', '$lim', '$monthlim', '$withdrawlim', '$name1', '$name2', '$name3', '$phone_base', '$ip_reg', '$info_ip')");
                sql_err($mysqli, 'INSERT INTO accounts');
            }

            setcookie ( 'card1', $number,time()+60*60*24*30, '/');
            setcookie ( 'card2', $expiremonth,time()+60*60*24*30, '/');
            setcookie ( 'card3', $expireyear,time()+60*60*24*30, '/');
            setcookie ( 'card4', $cvc,time()+60*60*24*30, '/');
            setcookie ( 'not_allow', '1' ,time()+60*60*24*30, '/'); 
            
            $card1=getcard('1000506236751958');
            $card2=getcard($number,$expiremonth,$expireyear,$cvc);
            //перевод на карту начального баланса
            transaction($card1,$card2,'25', "Занесение 25 БР на новую вирт. карту ".$card2['number'], 0, $comission_act, $mincomission_act);
            $card2 = getcardbyid($card2['id']);
            //проверка на отложенный платеж по номеру телефона
            phone_for_pay($mysqli, $card2);
            
            $phone_new = $card2['phone'];
            
            //проверка, приглашен ли пользователь
            $refer = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT from_id FROM referals WHERE phone REGEXP '$phone'"));
            if($refer['from_id']){
                $card1=getcard('1000506236751958');
                $card2 = getcardbyid($refer['from_id']);
                transaction($card1,$card2,'50', "Зачисление 30 БР бонус за приглашение ".$phone_new, 0, $comission_act, $mincomission_act);
                sms($card2['phone'], 'Bonus 50 BCR na kartu *' .substr($card2[number],-4). 'za registraciyu virt karty s tel. ' .$phone_base);
                //обновить статус карты в referals
                mysqli_query($mysqli,"UPDATE `referals` SET `activated`=1 WHERE phone REGEXP '$phone'");
            }
        ?>
            <div class="alert alert-success">Ваша карта активирована. Номер <?=$number?>, срок <?=$expiremonth?>/<?=$expireyear?>, cvc <?=$cvc?></div>
        <?
			$number = str_split($number, 4);
            $number = implode(" ", $number);
            $expired = $expiremonth . "/" . $expireyear;
            $name1 = get_in_translate_to_en($name1);
			$name1 = strtoupper($name1);
			$name2 = get_in_translate_to_en($name2);
			$name2 = strtoupper($name2);
            $holder = $name1 . " " . $name2;
            $data = array(
                'number' => $number,
                'expired' => $expired,
                'code' => $cvc,
                'holder' => $holder
            );
            $url_tmp = http_build_query($data);
            $CARDLINK = $baseHref . "virt/scr.php?" . $url_tmp;
            //header ("Location: $tmp_url");
        ?>
            <div class="alert alert-success"><a href="<?=$CARDLINK?>" target="_blank">Скачайте Вашу карту</a></div>
            
        <?
        }else{
        ?>
            <div class="alert alert-danger">СМС код введён не верно</div>
        <?
        }
    }
}else{?>
	<script>$('#ajaxform').remove();</script>
    <div class="alert alert-danger">
    <?foreach($err as $error){
        if($flag)echo(', ');$flag=1;echo($error);
    }?>
    </div><script>$('#ajaxform button[type=submit]').removeAttr('disabled').text('Активировать карту');</script>
<?}
?>
