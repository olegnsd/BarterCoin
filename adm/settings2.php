<?php
ini_set('display_errors', 0);
if($auth){
    $alert='';
    if(isset($_POST["sms_text"])){
        $sms_text = htmlspecialchars($_POST["sms_text"]);
        $info=mysqli_query($mysqli,"UPDATE settings SET token='$sms_text' WHERE title='sms_text'");
        $alert = "<div class='alert alert-success'>Изменения сохранены</div>";
    }else{
        $info=mysqli_query($mysqli,"SELECT token FROM settings WHERE title='sms_text'");
        $info=mysqli_fetch_assoc($info);
        $sms_text = htmlspecialchars($info["token"]);
    }
?>
<body class="cbp-spmenu-push">
<!-- header -->
<? include('top.php');?>
<br>
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Настройки приглашений для регистрации виртуальных карт
                    </div>

                    <div class="panel-body">
                        <div id="result"><?=$alert?></div>
                        </div>
                        <form class="form-horizontal" method="POST" action="/adm/?settings=2">

                            <div class="form-group{{ $errors->has('sms_text') ? ' has-error' : '' }}">
                                <label for="sms_text" class="col-md-4 control-label">Текст СМС</label>
                                <div class="col-md-6">
                                    <textarea id="sms_text" type="text" class="form-control" name="sms_text" rows=7 required autofocus><?=$sms_text?>
                                    </textarea>
                                    <span class="help-block">
                                        <strong>$phone номер приглашающего</strong>
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
        </div>
    
</body>
<?
}?>
