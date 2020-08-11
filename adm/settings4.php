<?php
ini_set('display_errors', 0);
if($auth){
    $alert='';
    if(isset($_POST["token"])){
        $exp_token = mysqli_escape_string($mysqli, $_POST["exp_token"]);
        $token_proxy = array();
        $token_proxy['title'] = mysqli_escape_string($mysqli, $_POST["title"]);
        $token_proxy['token'] = mysqli_escape_string($mysqli, $_POST["token"]);
        $_POST["card"] = preg_replace("/[^0-9]/", '', $_POST["card"]);
        $token_proxy['card'] = mysqli_escape_string($mysqli, $_POST["card"]);
        $token_proxy['ip'] = mysqli_escape_string($mysqli, $_POST["ip"]);
        $token_proxy['port'] = mysqli_escape_string($mysqli, $_POST["port"]);
        $token_proxy['usr'] = mysqli_escape_string($mysqli, $_POST["usr"]);
        $token_proxy['pass'] = mysqli_escape_string($mysqli, $_POST["pass"]);
        $token_proxy = json_encode($token_proxy, JSON_UNESCAPED_UNICODE);
        $b = mysqli_escape_string($mysqli, $_POST["b"]);
        
        $result = mysqli_query($mysqli,"UPDATE settings SET token='$token_proxy', exp_token='$exp_token' WHERE title='bankomat' AND amount='$b'");
        if(!$result)  die ("Сбой: " . mysqli_error($mysqli));
        $alert = 'alert'.$b;
        ${$alert} = "<div class='alert alert-success'>Изменения сохранены</div>";
    }
    $info=mysqli_query($mysqli,"SELECT * FROM settings WHERE title='bankomat'");
?>
<body class="cbp-spmenu-push">
<!-- header -->
<? include('top.php');?>
<br>
<div class="container">
    <? foreach($info as $bank){
        $amount_max = ($bank["amount_max"]);
        $delta_time = ($bank["delta_time"]);
        $token_proxy = json_decode($bank["token"], true);
        $title = $token_proxy["title"];
        $token = $token_proxy["token"];
        $card = $token_proxy["card"];
        $proxy_ip = $token_proxy["ip"];
        $proxy_port = $token_proxy["port"];
        $proxy_usr = $token_proxy["usr"];
        $proxy_pass = $token_proxy["pass"];
        $exp_token = $bank["exp_token"];
        $b = $bank["amount"];
        $exp_day = intval((strtotime($exp_token) - time())/(60*60*24));
        $h_class = "alert-xs alert-success";
        $exp_notice = '';
        if($exp_day < 2){
            $h_class = "alert-xs alert-danger";
            $exp_notice = "Обновите токен";
        }

        //проверка счета
//        if( $curl = curl_init() ) {
//            curl_setopt($curl, CURLOPT_URL, 'https://edge.qiwi.com/funding-sources/v1/accounts/current');
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   
//            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
//                'Accept: application/json',
//                'Content-Type: application/json',
//                'Authorization: Bearer ' . $token)
//            ); 
//            $out_count = curl_exec($curl); //my
//        }
//        curl_close($curl);
//        $out_count = json_decode($out_count);
//        $out_count = $out_count->accounts[0]->balance->amount;
        //проверка счета
    ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Настройки токена и прокси банкомата:  <b><i><?=$b?></i></b>. 
                    </div>

                    <div class="panel-body">
                        <?$alert = 'alert'.$b;?>
                        <div id="result"><?=${$alert}?></div>
                        </div>
                        <form class="form-horizontal" method="POST" action="/adm/?settings=4">
                            <input name="b" type="hidden" value="<?=$b?>">
                            
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Название</label>
                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="title" value="<?=$title?>" required autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="card" class="col-md-4 control-label">Номер карты</label>
                                <div class="col-md-6">
                                    <input id="card" type="text" class="form-control" name="card" value="<?=$card?>">
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('ip') ? ' has-error' : '' }}">
                                <label for="ip" class="col-md-4 control-label">ip proxy</label>
                                <div class="col-md-6">
                                    <input id="ip" type="text" class="form-control" name="ip" value="<?=$proxy_ip?>" autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('port') ? ' has-error' : '' }}">
                                <label for="port" class="col-md-4 control-label">port proxy</label>
                                <div class="col-md-6">
                                    <input id="port" type="text" class="form-control" name="port" value="<?=$proxy_port?>" autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('usr') ? ' has-error' : '' }}">
                                <label for="usr" class="col-md-4 control-label">user proxy</label>
                                <div class="col-md-6">
                                    <input id="usr" type="text" class="form-control" name="usr" value="<?=$proxy_usr?>" autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('pass') ? ' has-error' : '' }}">
                                <label for="pass" class="col-md-4 control-label">password poxy</label>
                                <div class="col-md-6">
                                    <input id="pass" type="text" class="form-control" name="pass" value="<?=$proxy_pass?>" autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('token') ? ' has-error' : '' }}">
                                <label for="token" class="col-md-4 control-label">Токен Qiwi</label>
                                <div class="col-md-6">
                                    <input id="token" type="text" class="form-control" name="token" value="<?=$token?>" autofocus>
                                    <span class="help-block">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('exp_token') ? ' has-error' : '' }}">
                                <label for="exp_token" class="col-md-4 control-label">Срок токена</label>
                                <div class="col-md-6">
                                    <input name="exp_token" id="exp_token" type="date" class="form-control" value="<?=$exp_token?>" autofocus>
                                        <span class="help-block">
                                            <strong class="<?=$h_class?>">
                                                Осталось дней <?=$exp_day?> <?=$exp_notice?>
                                            </strong>
                                        </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="send_butt" class="col-md-6 control-label">
                                    <!--div class="g-recaptcha" data-sitekey="6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB"></div-->
                                    <div id="html_element"></div>
                                </label>
                                <div class="col-md-4">
                                    <button type="submit" id='send_butt' name="send_butt" class="btn btn-primary"> <!--disabled--><!--убрать коммент для рекапчи-->
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
        </div>
    <?}?>
</div>
    
</body>
<?
}?>

<script type="text/javascript">
    jQuery(function($) {
        $.mask.definitions['~']='[+-]';
        //
        $('[name=card]').mask('9999 9999 9999 9999');
    });
</script>
