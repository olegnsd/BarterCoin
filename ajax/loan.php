<?php
//
require('../inc/init.php');

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

if($_POST['sum'] <= 0 || (int)($_POST['sum']) == ''){
    $err[] = 'Отказано';
}

if($_COOKIE['card1']){
    $card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);
}

if($_POST['new_sms']=='1' && $_POST['delta_sms']=='0'){
    $_POST['check1']='';
    $_POST['check2']='';
}

if(!$err[0]){//на данный момент - карта валидная, можно занимать 
    if($_POST['check1']=='' & $_POST['check2']==''){
        //отправить смс
        $smscode=createsmscode($card['phone']);
        if($smscode[1] != 'trust'){
	        sms($card['phone'],'SMS-kod: '.$smscode[1].'; Zaym');// na kartu *'.substr($card2[number],-4));
       }
    ?>  
        <!--удалить форму-->
        <script>
            $('#ajaxform').attr('hidden','hidden');
            $('#ajax_loans').remove();
        </script>
        <div class="alert alert-success">На Ваш номер отправлен код для подтверждения займа</div>

        <form id="ajaxsms" onsubmit="$('#ajaxsms #sub').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxsms').serialize();
            $.ajax({
              type: 'POST',
              url: 'ajax/loan.php',
              data: msg,
              success: function(data) {
                $('#ajaxresult').html(data);
              },
              error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
              }
            });return false;">
            <input type="hidden" name="check1" value="<?=$smscode[0];?>">
            <input type='hidden' name='new_sms' value='0'>
            <input type='hidden' name='delta_sms' value='30'>
            <input type='hidden' name='sum' value='<?=$_POST['sum']?>'>
            <?if($smscode[1] != 'trust'){//проверка доверенного ip?>
            <div class="form-group">
            <label>
                Код из СМС:<br>
                <button type="button" id="new_sms" class="btn btn-info" disabled>Выслать код повторно</button>
                <span class='label label-info' role='alert'>
                    Через <ii id="delta_sms">30</ii> сек.
                </span>
            </label>
            <input type="text" class="form-control" name="check2" placeholder="Введите код из СМС" required value=""></div>
            <button type="button" id="sub" class="btn btn-success">Подтвердить займ</button>
            <?}else{?>
                <input type="hidden" class="form-control" name="check2" value="<?=$smscode[1]?>">
                <button type="submit" id="sub" class="btn btn-success center-block">Подтвердить займ</button>
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
            (function($){
                var files = []; // переменная. будет содержать данные файлов
                // заполняем переменную данными файлов, при изменении значения file поля
                $('#ajaxform input[type=file]').each(function(){
                    
                    files.push(this.files[0]);//obj.age = obj.age.toString();
//                    alert( JSON.stringify(this.files[0].toString()) );
                });
                // обработка и отправка AJAX запроса при клике на кнопку upload_files
                $('#ajaxsms #sub').on( 'click', function( event ){
                    $('#ajaxsms #sub').attr('disabled','disabled').text('обработка...');
                    event.stopPropagation(); // остановка всех текущих JS событий
                    event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега
                    
                    // ничего не делаем если files пустой
                    if( typeof files == 'undefined' ) return;
                    
                    // создадим данные файлов в подходящем для отправки формате
                    var data = new FormData();
                    
                    data.append( 'foto', files[0] );
                    data.append( 'register', files[1] );

                    // добавим переменную идентификатор запроса
                    data.append( 'check1', <?=$smscode[0];?>);
                    data.append( 'check2', $('#ajaxsms input[name=check2]').val());
                    data.append( 'name1', $('#ajaxform input[name=name1]').val());
                    data.append( 'name2', $('#ajaxform input[name=name2]').val());
                    data.append( 'name3', $('#ajaxform input[name=name3]').val());
                    data.append( 'sum', $('#ajaxform input[name=sum]').val());
                    data.append( 'fisl', $('#ajaxform input[name=fisl]').val());
                    
                    // AJAX запрос
                    $.ajax({
                        url         : 'ajax/loan.php',
                        type        : 'POST',
                        data        : data,
                        cache       : false,
//                        dataType    : 'json',
                        // отключаем обработку передаваемых данных, пусть передаются как есть
                        processData : false,
                        // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                        contentType : false,
                        // функция успешного ответа сервера
                        success     : function( respond, status, jqXHR ){
                            // ОК
                            if( typeof respond.error === 'undefined' ){
                                // файлы загружены, делаем что-нибудь
                                $('#ajaxresult').html(respond);
                            }
                            // error
                            else {
                                console.log('ОШИБКА: ' + respond.error );
                            }
                        },
                        // функция ошибки ответа сервера
                        error: function( jqXHR, status, errorThrown ){
                            console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
                        }
                    });
                });
            })(jQuery)
        </script>
    <?
    }else{
        if(checksmscode($_POST['check1'],$_POST['check2'],$card['phone'])){
            
            $user_id = $card['id'];
            $info=mysqli_query($mysqli,"SELECT l.id FROM loans l, accounts a WHERE l.user_id='$user_id'");
            $info=mysqli_fetch_assoc($info);
            
            if(!$info){
                upload_file($_FILES, $card, $_POST['fisl']);  
            }else{
                save_loan($card['id']);
            }
            ?>
            <div class="alert alert-success">Ваши данные приняты к рассмотрению</div>
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

function upload_file($files, $card, $fisl){
    global $mysqli;
    
    // Если upload файла
    $file_name = array(0 => 'foto', 1 => 'register');
    foreach ($file_name as $value){
        if(isset($files["$value"])){
            $myfile = $files["$value"]["tmp_name"]; 
            $myfile_name = $files["$value"]["name"]; 
            $myfile_size = $files["$value"]["size"]; 
            $myfile_type = $files["$value"]["type"]; 
            $error_flag = $files["$value"]["error"]; 
            
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
                
                $path_save = $value . $card['id'];//'/home/bartercoin/tmp/passport/'. $value . $card['id'] . '.jpeg';
                //$im_cr = imagejpeg($im, $path_save, 20);
                ob_start();
                imagejpeg($im, $path_save3, 20);
                $imgData = ob_get_clean();
                imagedestroy($im);

                //сохранить картинку в бд
                $im_cr = store_img(base64_encode($imgData), $path_save);
                
                $myecho = json_encode(file_exists($path_save));
                `echo " file_exists(path_save): "  $myecho >>/home/bartercoin/tmp/qaz`;
                
                if(!$im_cr){?>
                    <div class="alert alert-danger">Ошибка загрузки. Возможные причины: Не правильный тип файла</div>
                    <? die();
                }
                $succ = true;
                
            }else{?>
                <div class="alert alert-danger">Ошибка загрузки. Возможные причины: Сбой</div>
                <? die();
            }
        }else{
			$myecho = json_encode("else");
			`echo " else: "  $myecho >>/home/bartercoin/tmp/qaz`;
			?>
            <div class="alert alert-danger">Ошибка загрузки. Возможные причины: Не правильный тип файла</div>
            <? die();
        }
    }
    if($succ){// || !$files['foto']){
        $user_id = $card['id'];
        $name1 = mysqli_escape_string($mysqli, $_POST['name1']);
        $name2 = mysqli_escape_string($mysqli, $_POST['name2']);
        $name3 = mysqli_escape_string($mysqli, $_POST['name3']);
        $fisl = (int)$fisl;

        mysqli_query($mysqli, "UPDATE accounts SET name1='$name1', name2='$name2', name3='$name3', loan_accept='$fisl' WHERE id = '$user_id'");
        
        save_loan($user_id);
    }
}
function save_loan($user_id){
    global $mysqli;
    $sum_loan = (int)($_POST['sum']);
    $date_loan = date('d-m-Y H:i'); 
    $decision = '0'; //на рассмотрении
    $no_err = mysqli_query($mysqli,"INSERT INTO `loans` (user_id, sum_loan, date_loan, decision) VALUES ('$user_id', '$sum_loan', CURRENT_TIMESTAMP, '$decision')");
}
?>
