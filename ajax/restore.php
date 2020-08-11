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

$phone_base = mysqli_escape_string($mysqli,$_POST['phone']);
$phone = clear_phone($phone_base);
if(strlen($phone) < 11){
    $err[] = "Неверный номер телефона";
}

if(!$err[0]){//на данный момент - телефон валидный, можно восстанавливать 
    if($_POST['check1']=='' & $_POST['check2']==''){
        //отправить смс
        $smscode=createsmscode($_POST['phone'], '', 0);
        //проверка доверенного ip
        if($smscode[1] != 'trust'){
	        sms($phone, 'SMS-kod: ' . $smscode[1].'; восстановление карты');// na kartu *'.substr($card2[number],-4));
	    }
        ?>  
        <!--удалить форму-->
        <script>$('#ajaxform').remove();</script>
        <div class="alert alert-success">На Ваш номер отправлен код для восстановления карты</div>

        <form id="ajaxsms" onsubmit="$('#ajaxsms button[type=submit]').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxsms').serialize();
            $.ajax({
              type: 'POST',
              url: 'ajax/restore.php',
              data: msg,
              success: function(data) {
                $('#ajaxresult').html(data);
              },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });return false;">
            <input type="hidden" name="check1" value="<?=$smscode[0];?>">
            <input type="hidden" name="phone" value="<?=htmlspecialchars($_POST['phone']);?>"><!--$_POST['sum']-->
            <?if($smscode[1] != 'trust'){//проверка доверенного ip?>
            <div class="form-group"><label>
            Код из СМС:
            </label>
            <input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required></div>
            <button type="submit" class="btn btn-success">Восстановить карту</button>
            <?}else{?>
                <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
                <button type="submit" class="btn btn-success center-block">Восстановить карту</button>
            <?}?>
        </form>
    <?
    }else{
        
        $myecho = json_encode($_POST['check1']. " ". $_POST['check2']. " " .$_POST['phone']);
        `echo " check1 check2 phone: "  $myecho >>/tmp/qaz`;
        
        if(checksmscode($_POST['check1'],$_POST['check2'],$_POST['phone'])){
            $phone_base = mysqli_escape_string($mysqli,$_POST['phone']);
            $phone = clear_phone($phone_base);
            $phone_tmp = str_split($phone);
            $phone_tmp = implode("{1,1}.*", $phone_tmp);
            $phone_tmp = "^.*". $phone_tmp . "{1,1}.*$";
            $users = (mysqli_query($mysqli,"SELECT * FROM accounts WHERE phone REGEXP '$phone_tmp'  AND `activated`='1' AND `black`='0'"));
            
            if($users->num_rows == 0){?>
                <div class="alert alert-danger">У Вас нет карты</div>
            <?}
            
            while($user = mysqli_fetch_assoc($users)){
                $number = $user['number'];
                $name1 = $user['name1'];
                $name2 = $user['name2'];
                $expiremonth = $user['expiremonth'];
                $expireyear = $user['expireyear'];
                $cvc = $user['cvc'];
                
                $sms_text = "Ваша карта BarterCoin: $number, $expiremonth/$expireyear, $cvc"; 
                
                sms($phone, $sms_text);

                ?>
                <div class="alert alert-success">Ваша карта: Номер <?=$number?>, срок <?=$expiremonth?>/<?=$expireyear?>, cvc <?=$cvc?></div>
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
                ?>

                <div class="alert alert-success"><a href="<?=$CARDLINK?>" target="_blank">Скачайте Вашу карту</a></div>
            <?}  
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
    </div><script>$('#ajaxform button[type=submit]').removeAttr('disabled').text('Восстановить карту');</script>
<?}
?>
