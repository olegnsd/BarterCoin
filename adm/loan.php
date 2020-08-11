<?php
ini_set('display_errors', 0);
//require('../old/functions.php');

if($auth){
    $alert='';
    if(isset($_POST["decision"])){
        $loan_id = (int)$_POST['loan_id'];
        $decision = (int)($_POST["decision"]);
        $sum_issuse = (int)$_POST["sum_issuse"];
        if($decision == 0 || $decision == 2  || $decision == 6){
            $time = "NULL";
        }elseif($decision == 1 && !$_POST["transh"]){
            $time = "NULL";
        }elseif($_POST["transh"] == 1 && $decision == 1){
            $info=mysqli_query($mysqli,"SELECT a.number, a.lim, a.id AS user_id, a.phone, l.sum_loan FROM loans l, accounts a WHERE l.id='$loan_id' AND l.user_id=a.id");
            $info=mysqli_fetch_assoc($info);
            $sum_loan = $info['sum_loan'];
            
            $time = "CURRENT_TIMESTAMP";
            $decision = 3;
            
            if($sum_loan > $sum_issuse){
                $decision = 5; //частично выдан
            }
            
            //начисление займа
            $card1=getcard($info['number']);
            $card2=getcard('1000506236751958');
            
            $user_id = $info['user_id'];
            $lim = $info['lim'] + $sum_issuse;
            mysqli_query($mysqli,"UPDATE accounts SET lim='$lim' WHERE id='$user_id'");
            sms($info['phone'],'Vam vydan limit '.$info['sum_issuse'].' BCR Karta *'.substr($info['number'],-4));//
            
//            transaction($card2,$card1,(int)$sum_loan, 'Выдача займа БР ', 1, $comission, $mincomission);
//            sms($card['phone'],'SMS-kod: '.$smscode[1].'; Vozvrat Zayma BCR');//
        }
        $info=mysqli_query($mysqli,"UPDATE loans SET decision='$decision',  sum_issuse='$sum_issuse', issue_date=".$time." WHERE id='$loan_id'");
        $alert = "<div class='alert alert-success'>Изменения сохранены</div>";
    }else{
        $loan_id = (int)$_GET['loan'];
//        $loan = htmlspecialchars($info);
    }
    $info=mysqli_query($mysqli,"SELECT l.*, a.id AS acc_id, a.number, a.name1, a.name2, a.name3, a.loan_accept, a.data AS docs_add FROM loans l, accounts a WHERE l.id='$loan_id' AND l.user_id=a.id");
    $loan=mysqli_fetch_assoc($info);
    $info_user = $loan['name1']. ' '. $loan['name2']. ' '. $loan['name3']. ', карта: '. $loan['number'];
    //доп документы
    $docs_add = json_decode($loan['docs_add'], true);
    //все займы, кроме текущего
    $acc_id = $loan['acc_id'];
    $loans=mysqli_query($mysqli,"SELECT * FROM loans WHERE user_id='$acc_id' AND id != '$loan_id'");
    
    //удаление займа админом
    if($decision == 4){
        mysqli_query($mysqli,"DELETE FROM loans WHERE id='$loan_id'");
        $loan = '';
    }
    
    //вывод изображений
    $photo_s = getimagesize("/home/bartercoin/tmp/passport/foto". $acc_id .".jpeg");
    $register_s = getimagesize("/home/bartercoin/tmp/passport/register". $acc_id .".jpeg");
    
    $photo_w = $photo_s['0']; 
    $photo_h = $photo_s['1'];
    $register_w = $register_s['0']; 
    $register_h = $register_s['1'];
    
	$photo = imagecreatefromjpeg("home/bartercoin/tmp/passport/foto". $acc_id .".jpeg"); //home/bartercoin/tmp/passport/
	$register = imagecreatefromjpeg("home/bartercoin/tmp/passport/register". $acc_id .".jpeg");
    
?>
<body class="cbp-spmenu-push">
<script src="../js/modal.js"></script>
<!-- header -->
<? include('top.php');?>
<br>
    
<div class="modal bs-example-modal-lg" id="photo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
      <div class="panel panel-default">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="gridSystemModalLabel">Фото</h4>
        </div>
        <div class="panel-body">
            <div class=" thumbnail">
                
                <!--img src="../temp/passport/foto<?$acc_id?>.jpeg" alt="Фото" title="Фото"-->
            </div>
        </div>
      </div>
  </div>
</div>
    
<div class="modal bs-example-modal-lg" id="register" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="panel panel-default">
        <div class="panel-heading">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="gridSystemModalLabel">Регистрация</h4>
        </div>
        <div class="panel-body">
            <div class=" thumbnail">
               
                <!--img src="../temp/passport/register<?$acc_id?>.jpeg" alt="Регистрация" title="Регистрация"-->
            </div>
        </div>
    </div>
  </div>
</div>
    
<!-- Modal -->
<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
            <div class="alert alert-info" role="alert">Займ: <?=$info_user?></div>
        </h4>
      </div>
      <div class="modal-body" >
        <div class="alert alert-success" role="alert">
            Выдать займ BCR
            <label class="alert-link" id="sum_issuse"></label> ?
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <button type="button" id='send_butt' name="send_butt" class="btn btn-success" >Подтвердить</button>
      </div>
    </div>
  </div>
</div>
    
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Займ: <?=$info_user?>
                        <div class="btn-group">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Посмотреть документы <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                            <li><a href="loan_photo.php?photo=photo&id=<?=$acc_id?>&width=<?=$photo_w?>&height=<?=$photo_h?>" target="_blank" class="right">  
                                Посмотреть фото<br>
                                (пров номер <?=$loan['loan_accept']?>)
                                </a>
                            </li>
                            <li><a href="loan_photo.php?photo=register&id=<?=$acc_id?>&width=<?=$photo_w?>&height=<?=$photo_h?>" target="_blank">  
                                Посмотреть прописку
                            </a></li>
                            <? foreach($docs_add['title'] as $key => $doc_add){?>
                                <? if($docs_add['got'][$key] == 1){
                                    $class = "danger";
                                    $text = "нет";
                                }elseif($docs_add['got'][$key] == 2){
                                    $class = "success";
                                    $text = "есть";
                                }?>
                                <li class="bg-<?=$class?>">
                                    <a href="loan_photo.php?photo=add&id=<?=$acc_id?>_<?=$key?>" target="_blank">  
                                        Доп док №<?=$key+1?> '<?=$doc_add?>' <?=$text?>
                                    </a>
                                </li>
                            <?}?>
                            <li role="separator" class="divider"></li>
                            <? if(!($loan['decision'] ==5 || $loan['decision'] ==3)){?>
                                <li><a href="/adm/?loan_add=<?=$loan_id?>" target="_blank">  
                                    Запросить доп доки
                                    </a>
                                </li>
                            <?}?>
                          </ul>
                        </div>
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
                        
                    <? if($decision !=4){?>
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

                              <tr <?if($loan['decision'] == 0 || $loan['decision'] == 6){
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
                        <? if($loan['decision'] != 3 && $loan['decision'] != 5){?>
                        <form class="form-horizontal" method="POST" id="issuse" action="/adm/?loan=<?=$loan['id']?>">
                            <input type="hidden" name="loan_id" value="<?=$loan_id?>">

                            <div class="form-group">
                                <label for="phone" class="col-md-4 control-label">Вердикт</label>
                                <div class="col-md-3">
                                    <?
                                        $inf_cls0 = "";
                                        $inf_cls1 = "";
                                        $inf_cls2 = "";
                                        $inf_cls6 = "";
                                        // $myecho = old('accept');
                                        // `echo "old('accept'): " . $myecho >>/tmp/qaz`; 
                                        if ($loan['decision'] == '0'){
                                            $inf_cls0 = "selected";
                                        }elseif($loan['decision'] == '1'){
                                            $inf_cls1 = "selected";
                                        }elseif($loan['decision'] == '2'){
                                            $inf_cls2 = "selected";
                                        }
                                    ?>
                                    <!-- Single button -->
                                    <div class="btn-group">
                                        <select class="form-control" name="decision">
                                            <option class="bg-default" <?=$inf_cls0?> value="0">На рассмотрении</option>
                                            <? if($loan['decision'] == '6'){?>
                                                <option class="bg-default" <?=$inf_cls6?> value="6" selected>Запрос доп докум</option> 
                                            <?}?>
                                            <option class="bg-success" <?=$inf_cls1?> value="1">Разрешить</option>
                                            <option class="bg-danger" <?=$inf_cls2?> value="2">Отказать</option>
                                            <option class="bg-danger" value="4">Удалить</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary"> <!--disabled--><!--убрать коммент для рекапчи-->
                                        Сохранить
                                    </button>
                                </div>
                            </div>
                            
                            <? if($loan['decision'] == '1'){?>
                            <div class="form-group">
                                <label for="transh" class="col-md-4 control-label">
                                    Сумма BCR
                                    <div id="html_element"></div>
                                </label>
                                <div class="col-md-3">
                                    <input class="form-control" name="sum_issuse" type="number" min="1" value="<?=$loan['sum_loan']?>" autofocus>
                                </div>   
                                <div class="col-md-2">
                                    <input type="hidden" name="transh" value="0">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="butt_issuse">Выдать займ</button>
                                </div>
                                
                            </div>
                            <?}?>
                        </form>
                        <?}elseif($loan['decision'] == 3 || $loan['decision'] == 5){?>
                        <div class='alert alert-success'><h3><center>Займ выдан</center></h3></div>
                        <!--input type="hidden" name="decision" value="4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" >Удалить</button-->
                        <?}?>
                    <?}?>
                        <br><br>
                        <div class="panel-footer" id="ajax_loans">
                            <div class="panel panel-default">
                              <!-- Default panel contents -->
                              <div class="panel-heading">Остальные займы <?=$info_user?></div>

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

                                <? while($loan = mysqli_fetch_assoc($loans)){?>
                                  <tr <?if($loan['decision'] == 0 || $loan['decision'] == 6){
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
                                    <td><a href="?loan=<?=$loan['id']?>">
                                            <?=$loan['sum_loan']?>
                                            <? if($loan['sum_loan'] > $loan['sum_issuse'] && $loan['sum_issuse'] > 0){?>
                                                (<?=$loan['sum_issuse']?>)
                                            <?}?>
                                        </a>
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
