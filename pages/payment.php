<?php
ini_set('display_errors', 0);
require('./inc/auth_front.php');

if(!$card){include('loginform.php');}else{
if($auth_front){
    if($_POST['add']){ 
        $add_payment = add_payment($account, $card);
        if($add_payment == "false_card"){
            $add_payment = '<div class="alert alert-danger" role="alert">Ошибка добавления карты: Неверная карта</div>';
        }elseif($add_payment == 'exists'){
            $add_payment = '<div class="alert alert-danger" role="alert">Ошибка добавления карты: Карта уже добавлена</div>';
        }elseif($add_payment == 'err_data'){
            $add_payment = '<div class="alert alert-danger" role="alert">Ошибка добавления карты: Неправильная сумма</div>';
        }elseif($add_payment == "true_card"){
            $add_payment = '';
        }
    }elseif($_POST['update']){
        $upd_payment = upd_payment($account, $card);
    }elseif($_GET['del']){
        $del_payment = del_payment($account, $card);
    }elseif($_GET['sort9']){
        if($_SESSION['sort9'. (int)$_GET['sort9']] == 'ASC'){
            $_SESSION['sort9'. (int)$_GET['sort9']] = 'DESC';
        }else{
            $_SESSION['sort9'. (int)$_GET['sort9']] = 'ASC';
        }
        $_SESSION['sorted9'] = (int)$_GET['sort9'];
    } 

for($i = 1; $i <= 5; $i++){
    if($_SESSION['sort9'. $i] == 'ASC'){
        $class = 'up';
    }else{
        $class = 'down';
    }
    $temp = "sort_up_dwn_".$i;
    ${$temp} = ' <a href="payment?sort9='.$i.'"><i class="fa fa-chevron-'. $class .'"></i></a>';
    
}

$query = array('ORDER BY c.name', 'ORDER BY c.number', 'ORDER BY c.amount', 'ORDER BY c.status', 'ORDER BY c.date_act');

$query1 = 'ORDER BY c.id DESC';
if(isset($_SESSION['sorted9'])){
    $query1 = $query[(int)$_SESSION['sorted9']-1] ." ". $_SESSION['sort9'. (int)$_SESSION['sorted9']];
}
if(array_key_exists((int)$_GET['sort9']-1, $query)){
    $query1 = $query[(int)$_GET['sort9']-1] ." ". $_SESSION['sort9'. (int)$_GET['sort9']];
}

//кол-во страниц
$num = 1000;
if (isset($_SESSION["pagin"])) {
	$num = $_SESSION["pagin"];
}
if (isset($_POST["pagin"])) {
	$num = $_POST["pagin"];
	if($num < 2)$num = 2;
	if($num > 1000)$num = 1000;
	$_SESSION["pagin"] = $num;
}

$res = json_decode(pagination_payment($mysqli, $query1, $num, $card, $account), true);
$cards_pay = $res[0];
$navigation = $res[1];
?>
<body >
<!-- header -->
<br>
<!-- Modal -->
<div class="modal" id="myModal_info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Информация владельца карты</h4>
      </div>
      <div class="modal-body">
		<div class="col-md-12 col-xs-12">
			<!-- Table -->
			<div class='table-responsive'>
			  <table class="table table-hover table-condensed" id='user_info'>
				  <tr>
					<th></th>
					<th></th>
				  </tr>
				  <tr>
					<td>Карта</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Баланс</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Кредитный лимит</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Месячный лимит</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Суточный лимит</td>
					<td></td>
				  </tr>
                  <tr>
					<td>Разовый лимит</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Доступные банкоматы</td>
					<td></td>
				  </tr>
			  </table>
			</div>   
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal" id="myModal_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Добавить карту</h4>
      </div>
      <div class="modal-body">
		
			<form class="form-horizontal" id="form_add" method="POST" action="/payment">
                <input type="hidden" class="form-control" name="add" value="1">
				<div class="form-group">
					<label for="name" class="col-md-4 control-label">Название</label>
					<div class="col-md-6">
						<input id="name" type="text" min="1" class="form-control" name="name" value="<?=$name?>" autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label for="number" class="col-md-4 control-label">Номер карты</label>
					<div class="col-md-6">
						<input id="number" type="text" min="1" class="form-control" name="number" value="<?=$number?>" required autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
                </div>
                <div class="form-group">
					<label for="month" class="col-md-4 control-label">Месяц/Год</label>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-5 col-xs-12">
                                <input id="month" type="text" min="1" class="form-control" name="month" value="<?=$month?>" required autofocus>
                            </div>
                            <div class="col-md-2 col-xs-12 text-center" style="line-height: 34px;font-size: 20px;">/</div>
                            <div class="col-md-5 col-xs-12">
                                <input id="year" type="text" min="1" class="form-control" name="year" value="<?=$year?>" required autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
					<label for="cvc" class="col-md-4 control-label">cvc</label>
					<div class="col-md-6">
						<input id="cvc" type="text" min="1" class="form-control" name="cvc" value="<?=$cvc?>" required autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
                </div>
				<div class="form-group">
					<label for="amount" class="col-md-4 control-label">Переводить на счет при активации, руб</label>
					<div class="col-md-6">
						<input id="amount" type="text" min="1" class="form-control" name="amount" value="<?=$amount?>" required autofocus>
						<span class="help-block">
							<strong></strong>
						</span>
					</div>
				</div>
				
			</form>   
		
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="form_add">Сохранить</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal" id="myModal_upd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Редактирование карты</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="form_upd" method="POST" action="/payment">
            <input type="hidden" class="form-control" name="update" value="1">
            <input id="card_n" type="hidden" class="form-control" name="card_n" value="">
            <div class="form-group">
                <label for="name" class="col-md-4 control-label">Название</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="" autofocus>
                    <span class="help-block">
                        <strong></strong>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label for="amount" class="col-md-4 control-label">Переводить на счет при активации, руб</label>
                <div class="col-md-6">
                    <input id="amount" type="text" class="form-control" name="amount" value="" required autofocus>
                    <span class="help-block">
                        <strong></strong>
                    </span>
                </div>
            </div>
        </form>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="form_upd">Сохранить</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal" id="myModal_del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Удаление</h4>
      </div>
      <div class="modal-body">
        <label class="alert-link" id="del_info"></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <a href="/payment?del=" type="button" id='del_butt' key1="" name="send_butt" class="btn btn-danger" >Подтвердить</a>
      </div>
    </div>
  </div>
</div>
<?=$add_payment?>
<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
    <a href="/?logout" type="button" class="btn-xs btn-primary">Выход</a>
    <div class="panel panel-default">
      <!-- Default panel contents -->
		<caption class="bg-info">
			<h2 class="text-center">Пластиковые карты (для оплаты услуг)</h2>
		</caption>
      <!-- Table -->
      <div class='table-responsive'>
      <table class="table table-hover table-condensed" id='transaction'>
          <tr>
            <th>Название</th>
            <th>Номер карты</th>
            <th>Переводить на счет при активации, руб</th>
            <th>Статус</th>
            <th>Дата статуса</th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <td><?=$sort_up_dwn_1?></td>
            <td><?=$sort_up_dwn_2?></td>
            <td><?=$sort_up_dwn_3?></td>
            <td><?=$sort_up_dwn_4?></td>
            <td><?=$sort_up_dwn_5?></td>
            <td></td>
            <td></td>
          </tr>
		  <tr>
		  	<td colspan='5'>
				<div class="col-md-4 col-sm-4 col-xs-4">
					<form method="POST">
						<div class="input-group ">
							<span class="input-group-btn">
								<button class="btn btn-default" type="send">Показать</button>
							</span>
							<input type="number" name="pagin" class="form-control" max="1000" min="2" placeholder="<?=$num?> (2-1000)" aria-describedby="sizing-addon3">
						</div>
					</form>
				</div>
			</td>
		  </tr>

        <?      
        foreach($cards_pay as $key1 => $card_pay){?>
          <tr id="add_ch<?=$key1?>" key1="<?=$key1?>">
			<td><?=$card_pay['name']?></td>
			<td><a href="javascript:;" action='1' data-toggle="modal" data-target="#myModal_info" name="butt_issuse" card_n="<?=$card_pay['id']?>"><?=$card_pay['number']?></a></td>
			<td><?=$card_pay['amount']?></td>
            <td><?=$card_pay['status']?></td>
            <td><?=$card_pay['date_act']?></td>
			<td><a href="javascript:;" action='2' name="update" card_n="<?=$card_pay['id']?>" upd_key1="<?=$key1?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
            <td><a href="javascript:;" action='3' name="del" card_n="<?=$card_pay['id']?>" del_key1="<?=$key1?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
          </tr>
        <?}
        ?>
        <tr id="add_row"></tr>
        <tr>
            <td colspan = "5">
                <div class="input-group">
                    <button class="btn btn-success btn-xs"  data-toggle="modal" data-target="#myModal_add" name="butt_issuse" add_j="<?=$key1+1?>" add_key1="<?=!$key1?-1:$key1?>">Добавить карту</button>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan='5'><?=$navigation?></td>
        </tr>
      </table>
      </div>
    </div>   
</div>
</body>
<script >
    $('a[action=1]').each(function() {
        $(this).on('click', function () {
            card_n = $(this).attr('card_n');
            $.get('../ajax/front_info.php?card_n='+card_n, function(data) {
//                    alert(data);
                if(data == '"card_false"' || data == 'null' || data == ''){
                    $('#user_info tr:nth-child(1) th:nth-child(2)').html('<span class="label label-danger">Карта не найдена</span>');
                }else{
                    var user = jQuery.parseJSON(data);
                    $('#user_info tr:nth-child(2) td:nth-child(2)').html(user[0]);
                    $('#user_info tr:nth-child(3) td:nth-child(2)').html(user[1]);
                    $('#user_info tr:nth-child(4) td:nth-child(2)').html(user[2]);
                    $('#user_info tr:nth-child(5) td:nth-child(2)').html(user[3]);
                    $('#user_info tr:nth-child(6) td:nth-child(2)').html(user[4]);
                    $('#user_info tr:nth-child(7) td:nth-child(2)').html(user[5]);
                    $('#user_info tr:nth-child(8) td:nth-child(2)').html(user[6]);
                }
            });
        });
    });
</script>
<script>
	$("a[name='del']").click(function(){
		var key1 = $(this).attr('del_key1');
		var mark = $(`#add_ch${key1} :first-child`).html();
		var number = $(`#add_ch${key1} :nth-child(2) :first-child`).html();
        var card_n = $(this).attr('card_n');
//        alert('key1:'+key1+' mark:'+mark+' card_n:'+card_n);
		$('#del_info').html(mark+", карта: "+number);
		$('#del_butt').attr("href", "/payment?del="+card_n);
        $('#myModal_del').modal('show');
	});
    
    $("a[name='update']").click(function(){
		var key1 = $(this).attr('upd_key1');
		var mark = $(`#add_ch${key1} :first-child`).html();
		var amount = $(`#add_ch${key1} :nth-child(3)`).html();
        var card_n = $(this).attr('card_n');
//        alert('key1:'+key1+' mark:'+mark+' card_n:'+card_n+' amount:'+amount);
		$("form[id='form_upd'] input[id='card_n']").val(card_n);
		$("form[id='form_upd'] input[id='name']").val(mark);
        $("form[id='form_upd'] input[id='amount']").val(amount);
        $('#myModal_upd').modal('show');
	});
</script>
<script type="text/javascript">
    jQuery(function($) {
        $.mask.definitions['~']='[+-]';
        $('#form_add [name=number]').mask('9999 9999 9999 9999',{completed:function(){$('#form_add [name=month]').focus();}});
        $('#form_add [name=month]').mask('99',{completed:function(){$('#form_add [name=year]').focus();}});
        $('#form_add [name=year]').mask('99',{completed:function(){$('#form_add [name=cvc]').focus();}});
        $('#form_add [name=cvc]').mask('999',{completed:function(){$('#form_add [name=amount]').focus();}});
    });
</script>

<?}else{?>
	<div class="row">
	
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
    <div class="page-header">
      <h1>Доступ к разделу</h1>
    </div>
	<div class="panel panel-default">
	<div class="panel-heading">Вход</div>
	<div class="panel-body">
	
	<form method="post"> 	
	<div class="row"><div class="col-md-4"><div class="form-group"> <input type="number" name="pin" class="form-control" placeholder="КОД"> </div></div>
	    <div class="col-md-8" id="btn1">Забыли код? <a class="btn btn-info submit-button" onclick="if($(this).hasClass('disabled'))return false;$('#btn1 a').addClass('disabled');$('.ajax1').load('<?=$baseHref?>inc/ajaxreg.php?btn=1&card=<?=$card[id]?>&phone='+encodeURI($('#phone1').val()),function(){$('#btn1 a').removeClass('disabled');});return false;">Выслать новый</a></div>
	</div>
	
	<div class="ajax1"></div>
	<?if($_POST[pin]){?><div class="alert alert-danger">Введены неверные данные</div><?}?>
	
	<button type="submit" class="btn btn-success submit-button">Войти</button> </form>
	</div></div></div>
	</div>
	
<?
	exit; 
}
}

