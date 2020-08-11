
<!--script src='https://www.google.com/recaptcha/api.js?render=6LdTFmsUAAAAAD_AHFItOC2bPZZP5JAx5l514Y8h'></script-->
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : '6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB',
            'callback': 'activ_sub'
        });
    };
    function activ_sub(token){
        $("#send_butt").prop("disabled", false);
    }
</script>

<div class="pageTitle">
<h2>Регистрация виртуальной карты</h2>  					
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
					После регистрации у Вас будет стартовый баланс который Вы можете тратить или выводить на свое усмотрение
                    <a class="btn btn-block btn-default " target="_blank" href="http://t-do.ru/sms_mil_bot">
                        Телеграмм бот  для принятия кода
                    </a>
                </div>

                <div class="panel-body">
                    <div id="ajaxresult">
                    </div>
                    <form class="form-horizontal" method="POST" onsubmit="$('#ajaxform button[type=submit]').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxform').serialize();
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
                    });return false;" id="ajaxform">

                        <div class="form-group{{ $errors->has('name1') ? ' has-error' : '' }}">
                            <label for="name1" class="col-md-4 control-label">Фамилия</label>

                            <div class="col-md-6">
                                <input id="name1" type="text" class="form-control" name="name1" value="<?=$name1?>" required autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('name2') ? ' has-error' : '' }}">
                            <label for="name2" class="col-md-4 control-label">Имя</label>

                            <div class="col-md-6">
                                <input id="name2" type="text" class="form-control" name="name2" value="<?=$name1?>" required autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('name3') ? ' has-error' : '' }}">
                            <label for="name3" class="col-md-4 control-label">Отчество</label>

                            <div class="col-md-6">
                                <input id="name3" type="text" class="form-control" name="name3" value="<?=$name1?>" required autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

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
                            <label for="html_element" class="col-md-4 control-label">
                            </label>
                            <div for="html_element" class="col-md-6 control-label">
                                <!--div class="g-recaptcha" data-sitekey="6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB"></div-->
                                <div id="html_element"></div>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="send_butt" class="col-md-4 control-label">
                            </label>
                            <div class="col-md-6">
                                <button type="submit" id='send_butt' name="send_butt" class="btn btn-primary" disabled> <!--disabled--><!--убрать коммент для рекапчи-->
                                    Получить карту
                                </button>
                            </div>
                        </div>
                    </form>
                    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
				        async defer> <!--убрать коммент для рекапчи-->
				    </script>
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
      // $("#phone").mask("Z9(999) 999-9999", {translation:  {'Z': {pattern: /[0-9]/, optional: true}}});

    });
    $('#nav_bar_3').addClass('active');    
    
</script>

<script>
//    grecaptcha.ready(function() {
//        grecaptcha.execute('6LdTFmsUAAAAAD_AHFItOC2bPZZP5JAx5l514Y8h', {action: 'action_name'})
////        .then(function(token) {
////        $("#re_token").attr("value", token);
////        });
//    });
//    $(document).ready(function() {
//       console.log( "ready!" );
//    });
</script>

<style>
.card{border: 2px dashed #dddfe0;
    border-radius: 14px;margin:0 auto;
    transition: .3s ease all;min-height: 276px;max-width:420px;}
.card.ae{background-color: #007cc2;background-image:url(img/cards/ae.png);background-position: 97% 97%;background-repeat:no-repeat;}
.card.visa{background-color: #ffa336;background-image:url(img/cards/visa.png);background-position: 97% 97%;background-repeat:no-repeat;}
.card.mc{background-color: #971010;background-image:url(img/cards/mc.png);background-position: 97% 97%;background-repeat:no-repeat;}
.card.ma{background-color: #0079f0;background-image:url(img/cards/ma.png);background-position: 97% 97%;background-repeat:no-repeat;}
.card.mi{background-color: #4ca847;background-image:url(img/cards/mi.png);background-position: 97% 97%;background-repeat:no-repeat;}
.card.bc{background-color: #3d2b1f;background-image:url(img/cards/bc.png);background-position: 97% 97%;background-repeat:no-repeat;}

.card.ae p{display:block !important;}
.card.visa p{display:block !important;}
.card.mc p{display:block !important;}
.card.ma p{display:block !important;}
.card.mi p{display:block !important;}
</style>
