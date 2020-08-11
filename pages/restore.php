
<!--script src='https://www.google.com/recaptcha/api.js?render=6LdTFmsUAAAAAD_AHFItOC2bPZZP5JAx5l514Y8h'></script-->
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : '6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB',
            'callback': 'activ_sub',
             'theme'  : 'light',
//            'size'    : 'compact'
        });
    };
    function activ_sub(token){
        $("#send_butt").prop("disabled", false);
    }
</script>

<div class="pageTitle">
<h2>Восстановление карты</h2>  					
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Вы получите СМС со ссылкой на Вашу карту
                </div>

                <div class="panel-body">
                    <div id="ajaxresult">
                    </div>
                    <form class="form-horizontal" method="POST" onsubmit="$('#ajaxform button[type=submit]').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxform').serialize();
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
                    });return false;" id="ajaxform">

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Телефон</label>

                            <div class="col-md-6">
                        
                                <input name="phone" id="phone" type="text" class="form-control" placeholder="7(___) ___-____" value="" required autofocus>
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
                                    Получить смс
                                </button>
                            </div>
                        </div>
                    </form>
                    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
				        async defer> 
				    </script><!--убрать коммент для рекапчи-->
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
  //    $("#phone").mask("7(999) 999-9999");
    });
    $('#nav_bar_3').addClass('active');    
    
</script>

<style>

</style>
