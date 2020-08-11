<? if(!$card){
    $notice = " <a href='create' class='alert-xs alert-warning'>или зарегистрируйте карту</a>";
    include('loginform.php');
}else{
ini_set('display_errors', 0);
?>


<!--script src='https://www.google.com/recaptcha/api.js?render=6LdTFmsUAAAAAD_AHFItOC2bPZZP5JAx5l514Y8h'></script-->
<script type="text/javascript">
    var onloadCallback = function() {
        grecaptcha.render('html_element', {
            'sitekey' : '6LcwhzYUAAAAAM8YDvyitVk-M1_J8WXHJborosCB',
            'callback': 'activ_sub',
             'theme'  : 'light',
            'size'    : 'compact'
        });
    };
    function activ_sub(token){
        $("#send_butt").prop("disabled", false);
    }
</script>

<div class="pageTitle">
<h2>Занять BCR</h2>  					
</div>

<?
if($_FILES){
    $user_id = $card['id'];
    $query = "SELECT data FROM accounts WHERE id = '$user_id'";
    $user = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
    $data = $user['data'];
    $docs_add = json_decode($data, true);
    $docs_l = count($docs_add['title']);
    
    $result_add = upload_add($_FILES, $card, $docs_add);
}
    
$user_id = $card['id'];
$query = "SELECT * FROM loans WHERE user_id = '$user_id'";
$loans = mysqli_query($mysqli, $query);
    
$query = "SELECT loan_accept, data FROM accounts WHERE id = '$user_id'";
$user = mysqli_fetch_assoc(mysqli_query($mysqli, $query));
$loan_accept = $user['loan_accept'];
$data = $user['data'];
$docs_add = json_decode($data, true);
$docs_l = count($docs_add['title']);
$gots = 0;
foreach($docs_add['got'] as $got){
    if($got == 1){
        $gots++;
    }
}
    
if($loans->num_rows == 0){
    $hidden = 'hidden';
    //генерация номера на сканы
    $fisl = strval(rand(1,9)) . strval(rand(0,9)) . strval(rand(0,9)) . strval(rand(0,9)) . strval(rand(0,9));
}else{
    $hidden = ''; 
}?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <?if(!$loan_accept){?>
                <div class="panel-heading">
                    <div class="alert alert-danger">Выдача займов запрещена</div>
                </div>
                <?}else{?>
                <div class="panel-heading">
                    <? if($loans->num_rows == 0 || $gots > 0){?>
                        Загрузите сканы Ваших документов
                    <?}else{
                        $amm = $loans->num_rows + 1;
                    ?>
                        Займ № <?=$amm?>
                    <?}?>
                </div>
                <?}?>

                <div class="panel-body">
                    <?if($loan_accept){?>
                    <div id="ajaxresult">
                        <?=$result_add?>
                    </div>
                    <? if($gots == 0){?>
                    <form class="form-horizontal" method="POST" onsubmit="$('#ajaxform button[type=submit]').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxform').serialize();
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
                    });return false;" id="ajaxform">
                        <? if($loans->num_rows == 0){?>
                        <div class="form-group{{ $errors->has('name1') ? ' has-error' : '' }}">
                            <label for="name1" class="col-md-4 control-label">Фамилия</label>

                            <div class="col-md-6">
                                <input id="name1" type="text" class="form-control" name="name1" value="<?=$card['name1']?>" required autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('name2') ? ' has-error' : '' }}">
                            <label for="name2" class="col-md-4 control-label">Имя</label>

                            <div class="col-md-6">
                                <input id="name2" type="text" class="form-control" name="name2" value="<?=$card['name2']?>" required autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('name3') ? ' has-error' : '' }}">
                            <label for="name3" class="col-md-4 control-label">Отчество</label>

                            <div class="col-md-6">
                                <input id="name3" type="text" class="form-control" name="name3" value="<?=$card['name3']?>" required autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="foto" class="col-md-4 control-label">
                                Скан фотография, ФИО
                            </label>
                            <div class="col-md-6">
                                <input id="foto" type="file" class="form-control" name="foto"  autofocus>
                                <input id="fisl" type="hidden" class="form-control" name="fisl" value="<?=$fisl?>">
                                <span class="help-block">
                                    <strong>
                                        (разворот с номером <?=$fisl?>)
                                        <a href="../photo_examp.php?photo=examp&fisl=<?=$fisl?>" target="_blank">Посмотреть пример</a>
                                    </strong>
                                </span>
                            </div>   
                        </div>
                        
                        <div class="form-group">
                            <label for="register" class="col-md-4 control-label">Скан прописка(регистрация)</label>
                            <div class="col-md-6">
                                <input id="register" type="file" class="form-control" name="register"  autofocus>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>   
                        </div>
                        <?}?>
                        
                        <div class="form-group">
                            <label for="sum" class="col-md-4 control-label">Сумма займа, BCR</label>

                            <div class="col-md-6">
                                <input id="sum" class="form-control" name="sum" type="number" min="1"  autofocus>
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
                                    Отправить
                                </button>
                            </div>
                        </div>
                    </form>
                    <?}else{?>
                        <form class="form-horizontal" method="POST" ENCTYPE="multipart/form-data">
                            <? foreach($docs_add['title'] as $key => $title){
                                if($docs_add['got'][$key] == 1){?>
                                    <div class="form-group">
                                        <label for="register" class="col-md-4 control-label"><?=$title?></label>
                                        <div class="col-md-6">
                                            <input id="register" type="file" class="form-control" name="add_<?=$key?>"  autofocus>
                                            <span class="help-block">
                                                <strong>
                                                   <?=$docs_add['descr'][$key]?> 
                                                </strong>
                                            </span>
                                        </div>   
                                    </div>
                                <?}
                            }?>
                            <div class="form-group">
                                <label for="send_butt" class="col-md-4 control-label">
                                </label>
                                <div class="col-md-6">
                                    <button type="submit" id='send_butt' name="send_butt" class="btn btn-primary" > <!--disabled--><!--убрать коммент для рекапчи-->
                                        Отправить
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    <?}?>
                    
                    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
				        async defer> 
				    </script><!--убрать коммент для рекапчи-->
                    <?}?>
                </div>
                <div class="panel-footer" id="ajax_loans">
                    <div class="panel panel-default">
                      <!-- Default panel contents -->
                      <div class="panel-heading">Ваши займы</div>

                      <!-- Table -->
                      <div class='table-responsive'>
                      <table class="table  table-hover">
                          <tr>
                            <th>Сумма займа, BCR</th>
                            <th>Дата займа</th>
                            <th>Решение</th>
                            <th>Дата выдачи</th>
                            <th>Погашенная сумма, BCR</th>
                            <th>Дата погашения</th>
                            <th></th>
                          </tr>
                          
                        <?while($loan = mysqli_fetch_assoc($loans)){?>
                          <tr <?if($loan['decision'] == 0){
                                    echo("class='warning'");
                                }elseif($loan['decision'] == 1){
                                    echo("class='success'");
                                }elseif($loan['decision'] == 2){
                                    echo("class='danger'");
                                }elseif($loan['decision'] == 3 || $loan['decision'] == 5){
                                    echo("class='success_s'");
                                }?>>
                            <?
                            $date_loan = $loan['date_loan']?date('d-m-Y H:i', strtotime($loan['date_loan'])):'-';
                            $issue_date = $loan['issue_date']?date('d-m-Y H:i', strtotime($loan['issue_date'])):'-';
                            $date_rep = $loan['date_rep']?date('d-m-Y H:i', strtotime($loan['date_rep'])):'-';  
                            ?>
                            <td>
                                <?=$loan['sum_loan']?>
                                <? if($loan['sum_loan'] > $loan['sum_issuse'] && $loan['sum_issuse'] > 0){?>
                                    (<?=$loan['sum_issuse']?>)
                                <?}?>
                            </td>
                            <td><?=$date_loan?></td>
                            <td>
                                <?
                                if($loan['decision'] == 0)$act = 'На рассмотрении';
                                if($loan['decision'] == 1)$act = 'Разрешен';
                                if($loan['decision'] == 2)$act = 'Отказан';
                                if($loan['decision'] == 3)$act = 'Выдан';
                                if($loan['decision'] == 5)$act = 'Выдан частично';
                                if($loan['decision'] == 6)$act = 'Запрос доп док';
                                ?>
                                <?=$act?>
                            </td>
                            <td><?=$issue_date?></td>
                            <td><?=$loan['loan_rep']?></td>
                            <td><?=$date_rep?></td>
                            <td>
                            </td>
                          </tr>
                        <?}?>
                      </table>
                      </div>
                        <form class="form-horizontal" method="POST" id="ajaxloan">
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$('.loan_sub').each(function(){
    $(this).on('click', function(){
        $(this).attr('disabled','disabled').text('обработка...');
        var msg = $(this).attr('val');
        $.ajax({
          type: 'POST',
          url: 'ajax/loan_rep.php',
          data: {loan_id: msg},
          success: function(data) {
            $('#ajaxresult').html(data);
          },
          error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });
        return false;
    });
});
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
.success_s{background-color: #aaf0aa;}
</style>

<?}?>
