<?php
ini_set('display_errors', 0);
//require('../old/functions.php');

if($auth){
    $alert='';
    if(isset($_POST["title_add"])){
        $loan_id = (int)$_POST['loan_id'];
//        $alert = "<div class='alert alert-success'>Изменения сохранены</div>";
    }else{
        $loan_id = (int)$_GET['loan_add'];
//        $loan = htmlspecialchars($info);
    }
    $info=mysqli_query($mysqli,"SELECT l.*, a.id AS acc_id, a.number, a.name1, a.name2, a.name3, a.loan_accept, a.data AS docs_add, a.phone FROM loans l, accounts a WHERE l.id='$loan_id' AND l.user_id=a.id");
    $loan=mysqli_fetch_assoc($info);
    $info_user = $loan['name1']. ' '. $loan['name2']. ' '. $loan['name3']. ', карта: '. $loan['number'];
    
    //сохранить новое задание
    if(isset($_POST["title_add"])){
        if(json_decode($loan['docs_add'])){
            $docs_add = json_decode($loan['docs_add'], true);
            
            $docs_add['title'][] = mysqli_escape_string($mysqli, $_POST["title_add"]);
            $docs_add['descr'][] = mysqli_escape_string($mysqli, $_POST["descr_add"]);
            $docs_add['got'][] = "1"; //не получен доп документ
        }else{

            $docs_add['title'][] = mysqli_escape_string($mysqli, $_POST["title_add"]);
            $docs_add['descr'][] = mysqli_escape_string($mysqli, $_POST["descr_add"]);
            $docs_add['got'][] = "1"; //не получен доп документ 
        }
        
//        $docs_l++;
        $title = htmlspecialchars($_POST["title_add"]);
        $acc_id = $loan['acc_id'];
        $docs_add = json_encode($docs_add, JSON_UNESCAPED_UNICODE);
        $info=mysqli_query($mysqli,"UPDATE loans SET decision='6' WHERE id='$loan_id'");
        $info=mysqli_query($mysqli,"UPDATE accounts SET data='$docs_add' WHERE id='$acc_id'");
        
        sms($loan['phone'],'Vam neobhodimo zagruzit dop dokumenty dlya zayma '.$loan['sum_loan'].' BCR Karta *'.substr($loan['number'],-4).' bartercoin.holding.bz/loan');
        
        $alert = "<div class='alert alert-success'>Дополнительный документ '$title' запрошен, смс отправлено</div>";
    }
    
    $info=mysqli_query($mysqli,"SELECT a.data AS docs_add FROM loans l, accounts a WHERE l.id='$loan_id' AND l.user_id=a.id");
    $docs_add=mysqli_fetch_assoc($info);
    $docs_add = json_decode($docs_add['docs_add'], true);
    $docs_l = count($docs_add['title']);
    $docs_l++;
    
    
?>
<body class="cbp-spmenu-push">
<script src="../js/modal.js"></script>
<!-- header -->
<? include('top.php');?>
<br>
    
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Запрос доп документов: <?=$info_user?>
                        
                        <!--a class="" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                          Посмотреть документы
                        </a>
                        <div class="collapse" id="collapseExample">
                            <div class="well">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <a href="#" class="thumbnail" data-toggle="modal" data-target="#photo">
                                            <iframe src="loan_photo.php?photo=photo&id=<?$acc_id?>&width=<?$photo_w?>&height=<?$photo_h?>" width="<?$photo_s['0']?>" height="<?$photo_s['1']?>" align="left">  
                                                Ваш браузер не поддерживает плавающие фреймы!
                                             </iframe>
                                            
                                            <img src="../temp/passport/foto<?$acc_id?>.jpeg" alt="Фото" title="Фото">
                                            
                                        </a>
                                        
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <!--a href="#" class="thumbnail" data-toggle="modal" data-target="#register">
                                            <iframe src="loan_photo.php?photo=register&id=<?$acc_id?>&width=<?$register_w?>&height=<?$register_h?>" width="<?$register_s['0']?>" height="<?$register_s['1']?>" align="left">
                                                Ваш браузер не поддерживает плавающие фреймы!
                                             </iframe>
                                            
                                            <img src="../temp/passport/register<?$acc_id?>.jpeg" alt="Регистрация" title="Регистрация">
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div-->
                        
                    
                    </div>

                    <div class="panel-body">
                        <div id="result"><?=$alert?></div>
                        
                    
                        <div class="alert alert-info">
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
                                    <? if($loan['sum_loan'] == $loan['loan_rep']){?>
                                    <div class='label label-info' role='alert'>Возвращен</div> 
                                    <?}elseif($loan['decision'] == 3 || $loan['decision'] == 5){?>
                                    <div class='label label-info' role='alert'>Возврат возможен</div> 
                                    <?}?>
                                </td>
                              </tr>
                          
                          </table>
                          </div>
                        </div> 
                        
                        <form class="form-horizontal" method="POST" id="issuse" action="/adm/?loan_add=<?=$loan['id']?>">
                            <input type="hidden" name="loan_id" value="<?=$loan_id?>">

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Запрашиваемый документ № <?=$docs_l?></label>
                                <div class="col-md-8">
                                    <input class="form-control" name="title_add" type="text" placeholder="Название" autofocus>
                                    <textarea class="form-control" name="descr_add" type="text"  placeholder="Описание" rows=3 required autofocus></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="send_butt" class="col-md-4 control-label">
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
</div>
    
</body>
<script src="../js/modal.js"></script>
<!--script src="../js/bootstrap.min.js"></script>
<script src="../js/dropdown.js"></script-->
<script>
    $('#butt_issuse').on('click', function () {
        sum_issuse = $('input[name=sum_issuse]').val();
        $('#sum_issuse').html(sum_issuse);
    });
    $('#send_butt').on('click', function () {
        $('input[name=transh]').val('1');
        $('#myModal').modal('hide');
        $('#issuse').submit();
    });
</script>
<?
}?>
