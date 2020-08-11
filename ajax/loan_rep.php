<?php
//
require('../inc/init.php');

if($_COOKIE['card1']){
    $card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);
}

if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
    $_POST['check1']='';
    $_POST['check2']='';
}

if(!$err[0]){//на данный момент - карта валидная, можно принимать займ 
    if($_POST['check1']=='' & $_POST['check2']==''){
        $loan_id = (int)($_POST['loan_id']);
        $loan = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM loans WHERE id='$loan_id'"));
        $sum_loan = $loan['sum_loan'] - $loan['loan_rep'];
        //отправить смс
        $smscode=createsmscode($card['phone']);
        if($smscode[1] != 'trust'){
	        sms($card['phone'],'SMS-kod: '.$smscode[1].'; Vozvrat Zayma BRC');// na kartu *'.substr($card2[number],-4));
	    }
    ?>  
        <!--удалить форму-->
        <script>
            $('#ajaxform').attr('hidden','hidden');
            $('#ajax_loans').remove();
        </script>
        <div class="alert alert-success">На Ваш номер отправлен код для подтверждения</div>

        <form id="ajaxsms" onsubmit="$('#ajaxsms .sub').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxsms').serialize();
            $.ajax({
              type: 'POST',
              url: 'ajax/loan_rep.php',
              data: msg,
              success: function(data) {
                $('#ajaxresult').html(data);
              },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });return false;">
            Сумма возврата:
            <input type="number" name="sum_loan" min="0" value="<?=$sum_loan;?>">
            <input type="hidden" name="loan_id" value="<?=$loan_id;?>">
            <input type="hidden" name="check1" value="<?=$smscode[0];?>">
            <input type='hidden' name='new_sms' value='0'>
            <input type='hidden' name='delta_sms' value='30'>
            <?if($smscode[1] != 'trust'){//проверка доверенного ip?>
            <div class="form-group">
            <label>
                Код из СМС:<br>
                <button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
                <span class='label label-info' role='alert'>
                    Через <ii id="delta_sms">30</ii> сек.
                </span>
            </label>
                <a class="btn btn-block btn-default " target="_blank"  href="http://t-do.ru/sms_mil_bot">
                    Телеграмм бот  для принятия кода
                </a>
            <input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required value=""></div>
            <button type="submit" class="btn btn-success sub">Подтвердить возврат займа</button>
            <?}else{?>
                <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
                <button type="submit" class="btn btn-success center-block sub">Подтвердить возврат займа</button>
            <?}?>
        </form>

        <script>
            $('#ajaxsms #new_sms').click(function() {
                $('#ajaxsms input[name=new_sms]').val('1');
            //        $('#resend').html("<input type='hidden' name='resend' value='1'>");
                $('#ajaxsms input[name=check2]').removeAttr('required');
                $('#ajaxsms').submit();
            });

            $(document).ready(function(){
                var delta_sms = 30;
                var timerId = setInterval(function(){
                    $('#ajaxsms #delta_sms').html(delta_sms);
                    if(delta_sms == 0){
                        $('#ajaxsms #new_sms').removeAttr('disabled');
                        $('#ajaxsms #delta_sms').parent().html('');
                        delta_sms = 30;
                        clearInterval(timerId);
                    }else{
                        delta_sms--;
                        $('#ajaxsms input[name=delta_sms]').val(delta_sms);
                    }
                    //$('.tobank2').remove();
                    //$(".tobank").clone().addClass('tobank2').removeClass('tobank').appendTo(".bank .screen");
                },1000);
            });
        </script>
    <?
    }else{
        if(checksmscode($_POST['check1'],$_POST['check2'],$card['phone'])){
            
            $myecho = json_encode($_POST["sum_loan"]);
            `echo " sum_loan: "  $myecho >>/tmp/qaz`;
            $myecho = json_encode($_POST['check1']);
            `echo " _POST[check1]: "  $myecho >>/tmp/qaz`;
            
            $sum_loan = htmlspecialchars($_POST['sum_loan']);
            
            $loan_id = (int)($_POST['loan_id']);
            $loan = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT l.*, a.phone FROM loans AS l, accounts AS a WHERE l.id = '$loan_id' AND l.user_id=a.id"));
            
            $coock_phone = clear_phone($card['phone']);
            $phone = clear_phone($loan['phone']);
            
            if($loan['decision'] == 0 || $loan['decision'] == 2){?>
                <div class="alert alert-danger">Займ не одобрен</div>
                <?die();
            }
            if($coock_phone != $phone){?>
                <div class="alert alert-danger">Отказано</div>
                <?die();
            }
            if($sum_loan > $card['balance']){?>
                <div class="alert alert-danger">Недостаточно средств</div>
                <?die();
            }
            if($sum_loan > $loan['sum_loan'] - $loan['loan_rep']){?>
                <div class="alert alert-danger">Неверная сумма</div>
                <?die();
            }
            
            $card1=$card;
            $card2=getcard('1000506236751958');
            
            transaction($card1,$card2,(int)$sum_loan, 'Возврат займа БР ', 1, $comission, $mincomission);
            
            $sum_loan_base = $loan['sum_loan'];
            $loan_rep_base = $loan['loan_rep'] + $sum_loan;
            mysqli_query($mysqli, "UPDATE `loans` SET `sum_loan`='$sum_loan_base', `loan_rep`='$loan_rep_base', `date_rep`=CURRENT_TIMESTAMP WHERE `id`='$loan_id'");
            
        ?>
            <div class="alert alert-success">Займ возвращен</div>
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
    </div><script>$('#ajaxform button[type=submit]').removeAttr('disabled').text('Подтвердить займ');</script>
<?}

function upload_file($files, $card){// это резерв не рабочий
    global $mysqli;
    
    $myecho = json_encode($_FILES["foto"]["tmp_name"]);
    `echo " files[foto][tmp_name]: "  $myecho >>/tmp/qaz`;
    
    // Если upload файла
    $file_name = array(0 => 'foto', 1 => 'register');
    foreach ($file_name as $value){
        if(isset($files["$value"])){
            $myfile = $files["$value"]["tmp_name"]; 
            $myfile_name = $files["$value"]["name"]; 
            $myfile_size = $files["$value"]["size"]; 
            $myfile_type = $files["$value"]["type"]; 
            $error_flag = $files["$value"]["error"]; 
            
            $myecho = json_encode($myfile_name);
            `echo " myfile_name: "  $myecho >>/tmp/qaz`;

            // Если ошибок не было 
            if($error_flag == 0) 
            {
                $succ = false;
                // если размер файла больше 512 Кб
                if ($myfile_size > 6144*1024){?>
                    <div class="alert alert-danger">Размер файла больше 6 мб! Уменьшите файл и повторите попытку</div>
                    <? die();
                } 
                
                $im = imagecreatefromstring(file_get_contents($myfile));
                
                $path_save = '../temp/passport/'. $value . $card['id'] . '.jpeg';
                $im_cr = imagejpeg($im, $path_save, 20);
                if(!$im_cr || !file_exists($path_save)){?>
                    <div class="alert alert-danger">Ошибка загрузки. Возможные причины: Не правильный тип файла</div>
                    <? die();
                }
                $succ = true;
                
            }else{?>
                <div class="alert alert-danger">Ошибка загрузки. Возможные причины: Сбой</div>
                <? die();
            }
        }
    }
    if($succ){
        $user_id = $card['id'];
        $loans = (mysqli_query($mysqli, "SELECT * FROM loans WHERE user_id = '$user_id'"));
        $amount_loan = $loans->num_rows + 1;
        $data = json_decode($card['data'], true);
        if($loans->num_rows == 0){
            $data['allow'] = '1'; //займы разрешены
            $data['sum']['1'] = $sum;
            $data['accept']['1'] = '1'; //на рассмотрении
            $data['date']['1'] = date('d-m-Y H:i'); 
            $data['transh']['1'] = '1'; //не выдан
            $data['date_tr']['1'] = '';
        }else{
            $data['sum'][lenght($data['sum'])+1] = htmlspecialchars($_POST['sum']);
            $data['accept'][lenght($data['sum'])+1] = '1'; //на рассмотрении
            $data['date'][lenght($data['sum'])+1] = date('d-m-Y H:i');
            $data['transh'][lenght($data['sum'])+1] = '1'; //не выдан
            $data['date_tr']['1'] = '';
        }
        $data = json_encode($data);
        $name1 = htmlspecialchars($_POST['name1']);
        $name2 = htmlspecialchars($_POST['name2']);
        $name3 = htmlspecialchars($_POST['name3']);

        mysqli_query($mysqli, "UPDATE accounts SET name1='$name1', name2='$name2', name3='$name3' WHERE id = '$user_id'");
        
        $no_err = mysqli_query($mysqli,"INSERT INTO `loans` (user_id, sum_loan, date_loan, decision) VALUES ('$number', '$expiremonth', '$expireyear', '$cvc', '$activated',  '$balance', '$lim', '$monthlim', '$withdrawlim', '$name1', '$name2', '$name3', '$phone_base', '$phone_utc', '$ip_reg', '$info_ip')");
    }
}
?>
