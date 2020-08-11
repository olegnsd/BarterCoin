<?php
//чтобы люди получали 3 BCR  за рефа
//а другой 5р
//итого 1 юзер 8р
//нормально
//и спам
//чтобы выбираи - системые коробочки юзать или рекламные
//где банкомат - там где-то делать поле «порекомендоать систему (опаичвается)»
//«порекомендовать систему (оплачвается)»
//в день до 5 можно салть приглашений на нос
//(регулиовать в админке)
//кому соклько
//рефу приходит смс c линком на /create
//и он закрепляется за рефером
//и когда рега происходит, человек получает бабло
//BCR

if(!$card){include('loginform.php');}else{
    if(isset($_POST['phone'])){
        $phone_base = mysqli_escape_string($mysqli,$_POST['phone']);
        $phone = clear_phone($phone_base);
        if(strlen($phone) < 11 ){
            $err[] = "Неверный номер телефона";
        }
        $user_id = $card['id'];
        $phone = str_split($phone);
        $phone = implode("{1,1}.*", $phone);
        $phone = "^.*". $phone . "{1,1}.*$";
        $refer_all = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT * FROM referals WHERE from_id = '$user_id' AND phone REGEXP '$phone'"));
        if($refer_all['id'] &&  $refer_all['activated'] == 0){
            $echo_err = ceil(((60*60*24*2) - (time() - strtotime($refer_all['date'])))/(60*60*24));
            $echo_err = $echo_err <= 0? 1 : $echo_err;
            $err[] = "На номер телефона ". $_POST['phone'] ." Вы уже отправили приглашение ". $refer_all['date'] .", еще одно можно будет отправить через ". $echo_err ." дн.";
        }
        if($refer_all['id'] &&  $refer_all['activated'] == 1){ 
            $err[] = "По номеру телефона ". $_POST['phone'] ." карта уже активирована";
        }
        if(!isset($err)){//ошибок нет      
            //send sms
            $sms_text = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT token FROM settings WHERE title = 'sms_text'"));
            $sms_text = $sms_text['token'];
            
            $phone = str_replace(' ','',$card['phone']);//номер приглашающего
            eval("\$sms_text = \"$sms_text\";");//подстановка переменных
            
            $sms_out = sms(clear_phone($phone_base), $sms_text);
            
            $sms_errs = array('[699]','[3]','[623]','[700]','[617]','[2]','[602]','[7]');
            foreach($sms_errs as $sms_err){
                if(strripos(json_encode($sms_out), $sms_err)){
                     $err[] = "Извините СМС не отправлено, попробуйте позже";
                }
            }
            if(!$sms_out){
                 $err[] = "Извините СМС не отправлено, попробуйте позже!";
            }
            if(!isset($err)){//ошибок нет
                mysqli_query($mysqli,"INSERT INTO `referals` (phone, from_id, date, activated) VALUES ('$phone_base', '$user_id', CURRENT_TIMESTAMP, 0)");
                $info = "Приглашение отправлено на номер ". $_POST['phone'];
            }
             
            //$myecho = json_encode($sms_out);
            //`echo " sms_out: "  $myecho >>/home/bartercoin/tmp/qaz`;
            //$myecho = json_encode($sms_out['1']['credits']);
            //`echo " sms_out_id: "  $myecho >>/home/bartercoin/tmp/qaz`;
        }
    }
    
    //$card - данные юзера
    //удалить приглашения больше двух дней
    $user_id = $card['id'];
    $exper = time() - 60*60*24*2;
    mysqli_query($mysqli,"DELETE FROM referals WHERE from_id = '$user_id' AND activated <> 1 AND date < (CURRENT_DATE()-2)");
    //все приглашения
    $refer_all = (mysqli_query($mysqli,"SELECT * FROM referals WHERE from_id = '$user_id'"));
    //приглашения за сегодня
    $refer_today = mysqli_fetch_assoc(mysqli_query($mysqli,"SELECT COUNT(phone) FROM referals WHERE from_id = '$user_id' AND date = CURRENT_DATE()"));
    $user_left = $card['amount_ref'] - $refer_today['COUNT(phone)'];
?>

<div class="row">
<div class="col-md-6 col-xs-12">

<div class="pageTitle">
	<div class="alert alert-info">
		<a href='https://bartercoin.holding.bz/api'>Принимайте платежи с сайта с комиссией 0% и получайте выручку - https://bartercoin.holding.bz/api</a>
	</div>
	<h2>Порекомендовать систему</h2>  					
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?if(isset($err)){?>
                        <div class="alert alert-danger">
                            <?$err_echo = implode(", ", $err)?>
                            <?=$err_echo?>
                        </div>
                    <?}else{?>
                        <?if(isset($info)){?>
                            <div class="alert alert-success">
                                <?=$info?>
                            </div>
                        <?}?>
                        <?if($user_left > 0){?>
                            <div class="alert alert-info">
                                После регистрации рекомендуемого Вам придет бонус 50 BCR.
                                Вы можете порекомендовать <?=$user_left?> раз(а) сегодня
                            </div>
                        <?}else{?>
                            <div class="alert alert-danger">
                                <?$echo_tmp=$card['amount_ref']?>
                                На сегодня рекомендации закончились. Завтра сможете приглашать <?=$echo_tmp?> раз(а).
                            </div>
                        <?}?>
                    <?}?>
                </div>

                <div class="panel-body">
                    
                    <?if($user_left && !isset($err) > 0){?>
                    <form class="form-horizontal" method="POST" action="/referals">
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                                <input name="phone" id="phone" type="text" class="form-control" placeholder="(____) ___-____" value="" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="send_butt" class="col-md-4 control-label">
                            </label>
                            <div class="col-md-6">
                                <button type="submit" id='send_butt' name="send_butt" class="btn btn-primary" > <!--disabled--><!--убрать коммент для рекапчи-->
                                    Пригласить
                                </button>
                            </div>
                        </div>
                    </form>
                    <?}?>
                    <!--script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
				        async defer> 
				    </script--><!--убрать коммент для рекапчи-->
                </div>
                <div class="panel-footer">
                    <div class="panel panel-default">
                      <!-- Default panel contents -->
                      <div class="panel-heading">Ваши приглашения</div>

                      <!-- Table -->
                      <div class='table-responsive'>
                      <table class="table  table-hover">
                          <tr>
                            <th>Телефон</th>
                            <th>Активирован</th>
                            <th>Дата приглаш.</th>
                            <th>Дней до удаления</th>
                          </tr>
                          
                        <?while($refer = mysqli_fetch_assoc($refer_all)){?>
                          <tr <?if($act = $refer['activated'])echo("class='success'")?>>
                            <td><?=$refer['phone']?></td>
                            <td>
                            <?$act = $refer['activated'] ? 'Да':'Нет'?>
                            <?=$act?>
                            </td>
                            <td><?=$refer['date']?></td>
                            <td>
                                <?$delta=ceil((60*60*24*2 - (time() - strtotime($refer['date'])))/(60*60*24))?>
                                <?if($delta <= 0) $delta = "завтра"?>
                                <?if($refer['activated'] == 1) $delta = ''?>
                                <?=$delta?>
                            </td>
                          </tr>
                        <?}?>
                      </table>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
    
<script type="text/javascript" src="../js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
    //Код jQuery, установливающий маску для ввода телефона элементу input
    //1. После загрузки страницы,  когда все элементы будут доступны выполнить...
    $(function(){
      //2. Получить элемент, к которому необходимо добавить маску
      // $("#phone").mask("7(999) 999-9999");
    });
    $('#nav_bar_3').addClass('active');    
    
</script>

<?}?>
