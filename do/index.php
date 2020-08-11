<?
require('../inc/init.php');
$operation=0;
if($_POST['action']=='send')$operation=2;
if($_POST['action']=='check')$operation=3;
if($_POST['action']=='activate')$operation=1;
if(isset($_GET['pay']))$operation=4;
if(isset($_GET['stock']))$operation=5;
if(isset($_GET['pay2']))$operation=6;

$operations=array('Ошибка','Активация карты','Перевод средств','Проверка баланса','Оплата');

ob_start();
include('../inc/template/topmin.php');

ini_set('display_errors', 0);

if($operation==0){?><div class="alert alert-danger">Ошибка. Попробуйте перейти с формы на сайте ещё раз</div><?}
if($operation==2 && strlen($_POST['tonum']) >= 16){
$card1=getcard($_POST['fromnum'],$_POST['frommonth'],$_POST['fromyear'],$_POST['fromcvc']);
$card2=getcard($_POST['tonum']);
if(($card1['id']==$card2['id']) & $card1['id']>0)$err[]='Вы ввели 2 одинаковые карты';
if($card1['id']==0)$err[]='Вы ввели неверные данные своей карты';
if($card1['black'] == 1)$err[]='Ваша карта заблокирована';
if($card2['id']==0){
    $card2=getcard($_POST['tonum'], 0, 0, 0, 0, 0);
}
if($card2['id']==0)$err[]='Вы ввели неверные данные карты получателя';
if($card2['black']==1)$err[]='Карта получателя заблокирована';
if($card2['activated']==0 && $card2['black']==0){
    $res = mysqli_fetch_array(mysqli_query($mysqli, "SELECT c.id FROM card_for_pay AS c WHERE c.number='".$card2['number']."'"));
    if($res['id']){
        $err[]='Вы ввели неверные данные карты получателя';
    }else{
        $card_pay = 1;
    } 
}
//определение комиссии
$comiss_base=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT comission FROM comissions WHERE `sum`<='". (int)$card1['balance']. "' ORDER BY `sum` DESC LIMIT 1"));
if($comiss_base){
	$comission_act = 1 + $comiss_base['comission']/100;
}
$out=round((float)$_POST['sum']*$comission_act,0);
if($card1['id']){
if(($_POST['sum']*($comission_act-1))<$mincomission_act)$out=(float)$_POST['sum']+$mincomission_act;
if(($card1['balance']+$card1['lim'])<$out)$err[]="Недостаточно средств на вашей карте";
if((float)$_POST['sum']<=0)$err[]="Сумма перевода должна быть больше 0";
$sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  
if(($sum['SUM(sum)']+$out)>$card1['monthlim'])$err[]="Превышен месячный лимит";
}
if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
    $_POST['check1']='';
    $_POST['check2']='';
}
if(!$err[0]){//на данный момент - карты валидные, списание возможно
if($_POST['check1']=='' & $_POST['check2']==''){
$smscode=createsmscode($card1[phone]);
if($smscode[1] != 'trust'){
	sms($card1[phone],'SMS-kod: '.$smscode[1].'; Perevod '.number_format((float)$_POST['sum'], 2, ',', ' ').' BCR (RUB) na kartu *'.substr($card2[number],-4));
}
if(!$card_pay == 1){?>
    <p class="text-center">Номер телефона получателя: <span class="target_phone" style="font-weight: bold"><?=$card2[phone];?></span></p>
    <p class="text-center">ФИО: <span class="target_name" style="font-weight: bold"><?=htmlspecialchars($card2[name1].' '.$card2[name2].' '.$card2[name3]);?></span></p>
<?}else{?>
    <p class="text-center"><span class="target_phone" style="font-weight: bold">Карта получателя не активирована. Списание произойдет при активации карты </span></p>
    <p class="text-center">Узнать статус или управлять картой можно в разделе <span class="target_name" style="font-weight: bold"><a  href='/pay_card' target='_blank'>Настройка пластиковых карт для расчетов</a></span></p>
<?}?>
<p class="text-center">Комиссия: <span class="target_commission" style="font-weight: bold"><?=$out-(float)$_POST['sum'];?> BCR (RUB)</span></p>
<p class="text-center">Сумма для списания: <span class="targer_amount" style="font-weight: bold"><?=$out;?> BCR (RUB)</span></p><form method="post">
<input type="hidden" name="check1" value="<?=$smscode[0];?>">
<input type="hidden" name="action" value="<?=htmlspecialchars($_POST['action']);?>">
<input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
<input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
<input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
<input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
<input type="hidden" name="tonum" value="<?=htmlspecialchars($_POST['tonum']);?>">
<input type="hidden" name="sum" value="<?=htmlspecialchars($_POST['sum']);?>">
<?if($smscode[1] != 'trust'){//проверка доверенного ip?>
<div class="form-group"><label>
Код из СМС:
</label>
<input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required></div>
<button type="submit" class="btn btn-success">Подтвердить операцию</button>
<?}else{?>
    <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
    <button type="submit" class="btn btn-success center-block">Подтвердить операцию</button>
<?}?>
</form>
<?if($smscode[1] != 'trust'){//проверка доверенного ip?>
<form id="ajaxsms" method="post">
    <input type="hidden" name="check1" value="">
    <input type="hidden" name="check2" value="">
    <input type="hidden" name="action" value="<?=htmlspecialchars($_POST['action']);?>">
    <input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
    <input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
    <input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
    <input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
    <input type="hidden" name="tonum" value="<?=htmlspecialchars($_POST['tonum']);?>">
    <input type="hidden" name="sum" value="<?=htmlspecialchars($_POST['sum']);?>">
    <input type='hidden' name='new_sms' value='0'>
    <input type='hidden' name='delta_sms' value='30'>
    <label>
        <br>
        <button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
        <span class='label label-info' role='alert'>
            Через <ii id="delta_sms">30</ii> сек.
        </span>
    </label>
    <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
        Телеграмм бот  для принятия кода
    </a>
</form>
<?}?>
<script src="../js/jquery.min.js"></script>
<script>
    $('#new_sms').click(function() {
        $('input[name=new_sms]').val('1');
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
	if($card_pay == 1){//отложенный перевод
        $res = mysqli_query($mysqli,"SELECT p.* FROM per_room AS p WHERE p.acc_id='".$card1['id']."' LIMIT 1;");
        $test=mysqli_fetch_assoc($res);
        sql_err($mysqli, 'per_room');
        if(!$test['id']){
            mysqli_query($mysqli,'INSERT INTO `per_room` (acc_id) values ('.$card1[id].');');
            sql_err($mysqli, 'INSERT per_room');
        }
        $res_room = mysqli_fetch_assoc(mysqli_query($mysqli,'SELECT * FROM `per_room` WHERE acc_id='.$card1[id].';'));
        sql_err($mysqli, 'SELECT * FROM per_room');
        $room_id = $res_room['id'];
        $card_rel = $card1['id'];
        $number = $card2['number'];
        $amount = (float)$_POST['sum'];
        $sql = "INSERT INTO card_for_pay (room_id, card_rel, name, number, amount, date_act) values ('$room_id', '$card_rel', '', '$number', '$amount', CURRENT_TIMESTAMP)";
        $res = mysqli_query($mysqli, $sql);
        sql_err($mysqli, 'INSERT INTO card_for_pay ');?>
        <div class="alert alert-success">Отложенный перевод успешно завершён</div>
        <a class="btn btn-primary btn-md" href='/pay_card'>Настройка пластиковых карт для расчетов</a>
    <?}else{//перевести BCR
        if(transaction($card1,$card2,(float)$_POST['sum'], "", 0, $comission_act, $mincomission_act)){
            $fromnum = str_replace(' ', '',$_POST['fromnum']);
            $tonum = str_replace(' ', '',$_POST['tonum']);
            $sum_tran = (float)$_POST['sum'];

            $myecho = "php ../tasks/call_task.php cron6538 $fromnum $tonum $sum_tran";
            `echo " php: "  $myecho >>/home/bartercoin/tmp/qaz`;

            `php ../tasks/call_task.php cron6538 $fromnum $tonum $sum_tran > /dev/null &`;
            //		task_call($card1, getcard($_POST['tonum']), (float)$_POST['sum']);//звонок кому перевод
            ?>
            <div class="alert alert-success">Перевод успешно завершён</div><br>
        <?}else{?>
            <div class="alert alert-danger">Ошибка</div>
        <?} 
    }
}else{?><div class="alert alert-danger">СМС код введён не верно</div><?}
}
}else{?>
<div class="alert alert-danger">
<?foreach($err as $error){
if($flag)echo(', ');$flag=1;echo($error);
}?>
</div>
<?}
exit;
}

//перевод по номеру телефона
if($operation==2 && strlen($_POST['tophone']) >= 10){
    $card1=getcard($_POST['fromnum'],$_POST['frommonth'],$_POST['fromyear'],$_POST['fromcvc']);
    
    $phone = clear_phone($_POST['tophone']);
    if(strlen($phone) !=11)$err[]='Вы ввели неверные данные телефона получателя';
    if(substr($phone, 0, 1) != 7 && substr($phone, 0, 1) != 8)$err[]='Допустимы телефоны по России';
    $phone = str_split($phone);
    $phone = implode("{1,1}.*", $phone);
    $phone = "^.*". $phone . "{1,1}.*$";//SELECT a.* FROM accounts AS a, transactions AS t WHERE a.phone REGEXP '^.*7{1,1}.*9{1,1}.*2{1,1}.*6{1,1}.*0{1,1}.*0{1,1}.*0{1,1}.*1{1,1}.*0{1,1}.*2{1,1}.*6{1,1}.*$' AND t.fromid=a.id ORDER BY t.timestamp DESC LIMIT 1 //79260001026 
    $card2 = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT a.* FROM accounts AS a, transactions AS t  WHERE a.phone REGEXP '$phone' AND t.fromid=a.id ORDER BY t.timestamp DESC LIMIT 1"));
    sql_err($mysqli, 'SELECT *.a FROM accounts AS a, transactions AS t');
    if($card2['id']==0){
        $card2 = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT a.* FROM accounts AS a WHERE a.phone REGEXP '$phone' LIMIT 1"));
    }
    if(($card1['id']==$card2['id']) & $card1['id']>0)$err[]='Вы ввели 2 одинаковые карты';
    if($card1['id']==0)$err[]='Вы ввели неверные данные своей карты';
    if($card1['black'] == 1)$err[]='Ваша карта заблокирована';
    if($card2['id']==0){
        $phone_pay = 1;
    }else{
        if(($card2['activated']==0 || $card2['black']==1) && !$err[0])$err[]='Карта получателя не активирована или заблокирована';
    }
    //определение комиссии
    $comiss_base=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT comission FROM comissions WHERE `sum`<='". (int)$card1['balance']. "' ORDER BY `sum` DESC LIMIT 1"));
    if($comiss_base){
        $comission_act = 1 + $comiss_base['comission']/100;
    }
    $out=round((float)$_POST['sum']*$comission_act,0);
    if($card1['id']){
    if(($_POST['sum']*($comission_act-1))<$mincomission_act)$out=(float)$_POST['sum']+$mincomission_act;
    if(($card1['balance']+$card1['lim'])<$out)$err[]="Недостаточно средств на вашей карте";
    if((float)$_POST['sum']<=0)$err[]="Сумма перевода должна быть больше 0";
    $sum=mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT SUM(sum) FROM transactions WHERE `fromid`=".(int)$card1['id']." AND timestamp > '".date("Y-m-d H:i:s", time()-(30*24*60*60))."'"));  
    if(($sum['SUM(sum)']+$out)>$card1['monthlim'])$err[]="Превышен месячный лимит";
    }
    if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
        $_POST['check1']='';
        $_POST['check2']='';
    }
    if(!$err[0]){//на данный момент - карты валидные, списание возможно
    if($_POST['check1']=='' & $_POST['check2']==''){
    $smscode=createsmscode($card1[phone]);
    if($smscode[1] != 'trust'){
	    sms($card1[phone],'SMS-kod: '.$smscode[1].'; Perevod '.number_format((float)$_POST['sum'], 2, ',', ' ').' BCR (RUB) na kartu *'.substr($card2[number],-4).', tel: '.clear_phone($_POST['tophone']));
    }
    if(!$phone_pay == 1){?>
        <p class="text-center">Номер телефона получателя: <span class="target_phone" style="font-weight: bold"><?=$card2[phone];?></span></p>
        <p class="text-center">ФИО: <span class="target_name" style="font-weight: bold"><?=htmlspecialchars($card2[name1].' '.$card2[name2].' '.$card2[name3]);?></span></p>
    <?}else{?>
        <p class="text-center"><span class="target_phone" style="font-weight: bold">Перевод на номер телефона. Списание произойдет при активации карты бартеркоин на этот номер</span></p>
        <p class="text-center">Номер телефона получателя: <span class="target_phone" style="font-weight: bold"><?=htmlspecialchars($_POST['tophone']);?></span></p>
        <p class="text-center">Узнать статус или управлять телефонами можно в разделе <span class="target_name" style="font-weight: bold"><a  href='/pay_phone' target='_blank'>Настройка телефонов для расчетов</a></span></p>
    <?}?>
    <p class="text-center">Комиссия: <span class="target_commission" style="font-weight: bold"><?=$out-(float)$_POST['sum'];?> BCR (RUB)</span></p>
    <p class="text-center">Сумма для списания: <span class="targer_amount" style="font-weight: bold"><?=$out;?> BCR (RUB)</span></p><form method="post">
    <input type="hidden" name="check1" value="<?=$smscode[0];?>">
    <input type="hidden" name="action" value="<?=htmlspecialchars($_POST['action']);?>">
    <input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
    <input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
    <input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
    <input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
    <input type="hidden" name="tophone" value="<?=htmlspecialchars($_POST['tophone']);?>">
    <input type="hidden" name="sum" value="<?=htmlspecialchars($_POST['sum']);?>">
    <?if($smscode[1] != 'trust'){//проверка доверенного ip?>
    <div class="form-group"><label>
    Код из СМС:
    </label>
    <input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required></div>
    <button type="submit" class="btn btn-success">Подтвердить операцию</button>
    <?}else{?>
        <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
        <button type="submit" class="btn btn-success center-block">Подтвердить операцию</button>
    <?}?>
    </form>
    <?if($smscode[1] != 'trust'){//проверка доверенного ip?>
    <form id="ajaxsms" method="post">
        <input type="hidden" name="check1" value="">
        <input type="hidden" name="check2" value="">
        <input type="hidden" name="action" value="<?=htmlspecialchars($_POST['action']);?>">
        <input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
        <input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
        <input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
        <input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
        <input type="hidden" name="tophone" value="<?=htmlspecialchars($_POST['tophone']);?>">
        <input type="hidden" name="sum" value="<?=htmlspecialchars($_POST['sum']);?>">
        <input type='hidden' name='new_sms' value='0'>
        <input type='hidden' name='delta_sms' value='30'>
        <label>
            <br>
            <button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
            <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
                Телеграмм бот  для принятия кода
            </a>
            <span class='label label-info' role='alert'>
                Через <ii id="delta_sms">30</ii> сек.
            </span>
        </label>
        <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
            Телеграмм бот  для принятия кода
        </a>
    </form>
    <?}?>
    <script src="../js/jquery.min.js"></script>
    <script>
        $('#new_sms').click(function() {
            $('input[name=new_sms]').val('1');
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
        if($phone_pay == 1){//отложенный перевод
            $res = mysqli_query($mysqli,"SELECT p.* FROM per_room AS p WHERE p.acc_id='".$card1['id']."' LIMIT 1;");
            $test=mysqli_fetch_assoc($res);
            sql_err($mysqli, 'per_room');
            if(!$test['id']){
                mysqli_query($mysqli,'INSERT INTO `per_room` (acc_id) values ('.$card1[id].');');
                sql_err($mysqli, 'INSERT per_room');
            }
            $res_room = mysqli_fetch_assoc(mysqli_query($mysqli,'SELECT * FROM `per_room` WHERE acc_id='.$card1[id].';'));
            sql_err($mysqli, 'SELECT * FROM per_room');
            $room_id = $res_room['id'];
            $card_rel = $card1['id'];
            $phone = clear_phone($_POST['tophone']);
            $amount = (float)$_POST['sum'];
            $sql = "INSERT INTO phone_for_pay (room_id, card_rel, name, number, amount, date_act) values ('$room_id', '$card_rel', '', '$phone', '$amount', CURRENT_TIMESTAMP)";
            $res = mysqli_query($mysqli, $sql);
            sql_err($mysqli, 'INSERT INTO phone_for_pay ');
            $text_sms = "BarterCoin онлайн.  ".mb_strtoupper($card1['name2'])." ".mb_strtoupper($card1['name3'])." ".mb_strtoupper(mb_substr($card1['name1'], 0, 1)).". перевел(а) Вам ".$amount." BCR. https://bartercoin.holding.bz";
            ?>
            <div class="alert alert-success">Отложенный перевод успешно завершён</div>
            <? if(sms($phone, $text_sms)){?>
                <div class="alert alert-success">СМС о переводе <?=$amount?> BCR отправлено на номер: <?=$phone?></div>
            <?}?>
            <a class="btn btn-primary btn-md" href='/pay_phone'>Настройка телефонов для расчетов</a>
        <?}else{//перевести BCR
            if(transaction($card1,$card2,(float)$_POST['sum'], "", 0, $comission_act, $mincomission_act)){
                $fromnum = str_replace(' ', '',$_POST['fromnum']);
                $tonum = str_replace(' ', '',$card2['number']);
                $sum_tran = (float)$_POST['sum'];

                $myecho = "php ../tasks/call_task.php cron6538 $fromnum $tonum $sum_tran";
                `echo " php: "  $myecho >>/var/www/tmp/qaz`;

                `php ../tasks/call_task.php cron6538 $fromnum $tonum $sum_tran > /dev/null &`;
                //		task_call($card1, getcard($_POST['tonum']), (float)$_POST['sum']);//звонок кому перевод
                ?>
                <div class="alert alert-success">Перевод успешно завершён</div><br>
            <?}else{?>
                <div class="alert alert-danger">Ошибка</div>
            <?} 
        }

    }else{?><div class="alert alert-danger">СМС код введён не верно</div><?}
    }
    }else{?>
        <div class="alert alert-danger">
        <?foreach($err as $error){
        if($flag)echo(', ');$flag=1;echo($error);
        }?>
        </div>
    <?}
    exit;
}

if($operation==3){
$card1=getcard($_POST['fromnum'],$_POST['frommonth'],$_POST['fromyear'],$_POST['fromcvc']);
if($card1['id']==0)$err[]='Вы ввели неверные данные своей карты';

if(!$err[0]){?>
<h3>Баланс карты <?=substr($card1['number'],0,4);?> <?=substr($card1['number'],4,4);?> <?=substr($card1['number'],8,4);?> <?=substr($card1['number'],12,4);?></h3>
<div class="alert alert-info">
<b>Баланс карты: </b> <?=$card1['balance'];?> БР
<hr>
<b>Кредитный лимит: </b> <?=$card1['lim'];?> БР
<hr>
<b>Месячный лимит: </b> <?=$card1['monthlim'];?> БР
</div>
<?}else{?>
<div class="alert alert-danger">
<?foreach($err as $error){
if($flag)echo(', ');$flag=1;echo($error);
}?>
</div>
<?}
}

if($operation==4){include('pay.php');
}

if($operation==5){include('stock.php');
}

if($operation==6){include('pay2.php');
}
//Активация
if($operation==1){
$card1=getcard($_POST['fromnum'],$_POST['frommonth'],$_POST['fromyear'],$_POST['fromcvc'],0);
if($card1['id']==0)$err[]='Вы ввели неверные данные карты';
if($card1['activated'])$err[]='Карта уже активирована';
if($_POST['lastname']=='' | $_POST['firstname']=='' | $_POST['middlename']=='' | $_POST['phone']=='')$err[]='Вы не заполнили обязательные поля';
if(!$err[0]){
if($_POST['check1']=='' & $_POST['check2']==''){
$smscode=createsmscode($_POST['phone'], '', 2);
//if(!sms($_POST['phone'],'SMS-kod: '.$smscode[1].'; Aktivaciya karty *'.substr($card1[number],-4))){?><!--<div class="alert alert-danger">Не удалось отправить СМС</div>--><?//}else{
?><form method="post">
<input type="hidden" name="check1" value="<?=$smscode[0];?>">
<input type="hidden" name="action" value="<?=htmlspecialchars($_POST['action']);?>">
<input type="hidden" name="fromnum" value="<?=htmlspecialchars($_POST['fromnum']);?>">
<input type="hidden" name="frommonth" value="<?=htmlspecialchars($_POST['frommonth']);?>">
<input type="hidden" name="fromyear" value="<?=htmlspecialchars($_POST['fromyear']);?>">
<input type="hidden" name="fromcvc" value="<?=htmlspecialchars($_POST['fromcvc']);?>">
<input type="hidden" name="lastname" value="<?=htmlspecialchars($_POST['lastname']);?>">
<input type="hidden" name="firstname" value="<?=htmlspecialchars($_POST['firstname']);?>">
<input type="hidden" name="middlename" value="<?=htmlspecialchars($_POST['middlename']);?>">
<input type="hidden" name="phone" value="<?=htmlspecialchars($_POST['phone']);?>">

<div class="form-group"><label>
<!--
Код из СМС:
-->
</label>
<input type="hidden" class="form-control" name="check2" placeholder="Введите код из СМС"  value="<?=$smscode[1]?>"></div>
<button type="submit" class="btn btn-success">Активировать карту</button>
</form><?//}
}else{
if(checksmscode($_POST['check1'],$_POST['check2'],$_POST['phone'])){
//проверка ип
$ip_user = $_SERVER['HTTP_X_REAL_IP'];
$ip_arr[] = $ip_user;
$ip_arr = json_encode($ip_arr);
mysqli_query($mysqli,"UPDATE `accounts` SET ip_trusted='$ip_arr', `activated`='1', `name1` = '".mysqli_escape_string($mysqli,htmlspecialchars($_POST['lastname']))."', `name2` = '".mysqli_escape_string($mysqli,htmlspecialchars($_POST['firstname']))."', `name3` = '".mysqli_escape_string($mysqli,htmlspecialchars($_POST['middlename']))."', `phone` = '".mysqli_escape_string($mysqli,htmlspecialchars($_POST['phone']))."' WHERE `accounts`.`id` = ".(int)$card1['id'].";");
//перевести на карту 100 bcr
$start_bal = 100;
$card_donor=getcard('1000506236751958');
transaction($card_donor,$card1,$start_bal, "Занесение ".$start_bal." БР на новую карту ".$card1['number']);
$card1=getcardbyid($card1['id']);
//проверить карту на отложенный перевод по номеру карты
card_for_pay($mysqli, $card1);
$card1=getcardbyid($card1['id']);
//проверить карту на отложенный перевод по номеру телефона
phone_for_pay($mysqli, $card1);
?><div class="alert alert-success">Карта успешно активирована</div><?
}else{?><div class="alert alert-danger">СМС код введён не верно</div><?}
}
}else{?>
<div class="alert alert-danger">
<?foreach($err as $error){
if($flag)echo(', ');$flag=1;echo($error);
}?>
</div>
<?}
}

include('../inc/template/bottommin.php');
echo(ob_get_clean());?>
