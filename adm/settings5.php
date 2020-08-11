<?php
ini_set('display_errors', 0);
if($auth){
	
if($_GET['sort5']){
	if($_SESSION['sort5'. (int)$_GET['sort5']] == 'ASC'){
		$_SESSION['sort5'. (int)$_GET['sort5']] = 'DESC';
	}else{
		$_SESSION['sort5'. (int)$_GET['sort5']] = 'ASC';
	}
	$_SESSION['sorted5'] = (int)$_GET['sort5'];
} 
	
for($i = 1; $i <= 8; $i++){
    if($_SESSION['sort5'. $i] == 'ASC'){
        $class[] = 'up';
    }else{
        $class[] = 'down';
    }
    
}

$sort_up_dwn_1=' <a href="?settings=5&sort5=1"><i class="fa fa-chevron-'. $class[0] .'"></i></a>';
$sort_up_dwn_2=' <a href="?settings=5&sort5=2"><i class="fa fa-chevron-'. $class[1] .'"></i></a>';
$sort_up_dwn_3=' <a href="?settings=5&sort5=3"><i class="fa fa-chevron-'. $class[2] .'"></i></a>';
$sort_up_dwn_4=' <a href="?settings=5&sort5=4"><i class="fa fa-chevron-'. $class[3] .'"></i></a>';
$sort_up_dwn_5=' <a href="?settings=5&sort5=5"><i class="fa fa-chevron-'. $class[4] .'"></i></a>';
//$sort_up_dwn_6=' <a href="?settings=5&sort5=6"><i class="fa fa-chevron-'. $class[5] .'"></i></a>';
$sort_up_dwn_7=' <a href="?settings=5&sort5=7"><i class="fa fa-chevron-'. $class[6] .'"></i></a>';
$sort_up_dwn_8=' <a href="?settings=5&sort5=8"><i class="fa fa-chevron-'. $class[7] .'"></i></a>';

$query = array('ORDER BY id', 'ORDER BY fromid', 'ORDER BY toid', 'ORDER BY sum', 'ORDER BY timestamp', '', 'ORDER BY iswithdraw', 'ORDER BY bankomat');

$query1 = 'ORDER BY id DESC';
if(isset($_SESSION['sorted5'])){
    $query1 = $query[(int)$_SESSION['sorted5']-1] ." ". $_SESSION['sort5'. (int)$_SESSION['sorted5']];
}
if(array_key_exists((int)$_GET['sort5']-1, $query)){
    $query1 = $query[(int)$_GET['sort5']-1] ." ". $_SESSION['sort5'. (int)$_GET['sort5']];
}

//кол-во страниц
$num = 1000;
if (isset($_SESSION["pagin"])) {
	$num = $_SESSION["pagin"];
}
if (isset($_POST["pagin"])) {
	$num = $_POST["pagin"];
	if($num < 5)$num = 5;
	if($num > 1000)$num = 1000;
	$_SESSION["pagin"] = $num;
}

$res = json_decode(pagination_5($mysqli, $query1, $num), true);
$transactions = $res[0];
$navigation = $res[1];
$trans_all = $res[2];
  
?>
<body class="cbp-spmenu-push">
<!-- header -->
<? include('top.php');?>
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
					<td>id</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Карта</td>
					<td></td>
				  </tr>
				  <tr>
					<td>IP</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Месяц/Год</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Активирована</td>
					<td></td>
				  </tr>
				  <tr>
					<td>В ЧС</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Баланс</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Лимит кредитный</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Лимит месячный</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Лимит дневной</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Лимит разовый</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Банкоматы</td>
					<td></td>
				  </tr>
				  <tr>
					<td>ФИО</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Телефон</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Yandex</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Qiwi</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Visa Mastercard</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Webmoney</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Доверенные IP</td>
					<td></td>
				  </tr>
			  </table>
			</div>   
		</div>
		<!--label class="alert-link" id="user_info1"></label-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<div class="col-md-12 col-xs-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
		<caption class="bg-info">
			<h2 class="text-center">История транзакций</h2>
		</caption>
      <!-- Table -->
      <div class='table-responsive'>
      <table class="table table-hover table-condensed"  id='transaction'>
          <tr>
            <th>id операц</th>
            <th>Откуда</th>
            <th>Куда</th>
            <th>Сумма, BCR</th>
            <th>Дата</th>
            <th>Коментарий</th>
            <th>Вывод BCR</th>
            <th>Банкомат</th>
          </tr>
          <tr>
            <td><?=$sort_up_dwn_1?></td>
            <td><?=$sort_up_dwn_2?></td>
            <td><?=$sort_up_dwn_3?></td>
            <td><?=$sort_up_dwn_4?></td>
            <td><?=$sort_up_dwn_5?></td>
            <td><?$sort_up_dwn_6?></td>
            <td><?=$sort_up_dwn_7?></td>
            <td><?=$sort_up_dwn_8?></td>
          </tr>
		  <tr>
		  	<td colspan='8'>
				<div class="col-md-4 col-sm-4 col-xs-4">
					<form method="POST">
						<div class="input-group ">
							<span class="input-group-btn">
								<button class="btn btn-default" type="send">Показать</button>
							</span>
							<input type="number" name="pagin" class="form-control" max="1000" min="5" placeholder="<?=$num?> (5-1000)" aria-describedby="sizing-addon3">
						</div>
					</form>
				</div>
			</td>
		  </tr>

        <? 
        foreach($transactions as $trans){?>
          <tr>
			<td><?=$trans['id']?></td>
			<td><a href="javascript:;" akcion='1' data-toggle="modal" data-target="#myModal_info" name="butt_issuse"><?=$trans['fromid']?></a></td>
			<td><a href="javascript:;" akcion='1' data-toggle="modal" data-target="#myModal_info" name="butt_issuse"><?=$trans['toid']?></a></td>
			<td><?=$trans['sum']?></td>
			<td><?=$trans['timestamp']?></td>
			<td><?=$trans['comment']?></td>
			<td><?=$trans['iswithdraw']?></td>
			<td><?=$trans['bankomat']?></td>
          </tr>
        <?}
        ?>
		  <tr>
			  <td colspan='8'><?=$navigation?></td>
		  </tr>
      </table>
      </div>
    </div>   
</div>
</body>
<script>window.trans_all = <?=$trans_all?>;</script>
<script>
	$('a[akcion=1]').each(function() {
        $(this).on('click', function () {
            user_id = $(this).html();
			$.get('../ajax/user_info.php?user_id='+user_id, function(data) {
				//alert(data);
				var user = jQuery.parseJSON(data);
				var bankomats = jQuery.parseJSON(user[16]);
				var link_card = '<a href=?card_id='+user[0]+'>'+user[1]+'</a>';
				var link_ip = '<a href=https://yandex.ru/search/?text='+user[22]+' target=_blank>'+user[22]+'</a>';
				//$('#user_info1').html(data);
				$('#user_info tr:nth-child(2) td:nth-child(2)').html(user[0]);
				$('#user_info tr:nth-child(3) td:nth-child(2)').html(link_card);
				$('#user_info tr:nth-child(4) td:nth-child(2)').html(link_ip);
				$('#user_info tr:nth-child(5) td:nth-child(2)').html(user[2]+'/'+user[3]);
				$('#user_info tr:nth-child(6) td:nth-child(2)').html(user[5]);
				$('#user_info tr:nth-child(7) td:nth-child(2)').html(user[6]);
				$('#user_info tr:nth-child(8) td:nth-child(2)').html(user[7]);
				$('#user_info tr:nth-child(9) td:nth-child(2)').html(user[8]);
				$('#user_info tr:nth-child(10) td:nth-child(2)').html(user[9]);
				$('#user_info tr:nth-child(11) td:nth-child(2)').html(user[10]);
				$('#user_info tr:nth-child(12) td:nth-child(2)').html(user[11]);
				$('#user_info tr:nth-child(13) td:nth-child(2)').html(user[16]);
				$('#user_info tr:nth-child(14) td:nth-child(2)').html(user[17]+' '+user[18]+' '+user[19]);
				$('#user_info tr:nth-child(15) td:nth-child(2)').html(user[20]);
				$('#user_info tr:nth-child(16) td:nth-child(2)').html(user[26]);
				$('#user_info tr:nth-child(17) td:nth-child(2)').html(user[27]);
				$('#user_info tr:nth-child(18) td:nth-child(2)').html(user[28]);
				$('#user_info tr:nth-child(19) td:nth-child(2)').html(user[30]);
                $('#user_info tr:nth-child(20) td:nth-child(2)').html(user[24]);
			});
        });
    });
    
    function user_info(this_html){
		user_id = this_html.html();

		$.get('../ajax/user_info.php?user_id='+user_id, function(data) {
			//alert(data);
			var user = jQuery.parseJSON(data);
			var bankomats = jQuery.parseJSON(user[16]);
			var link_card = '<a href=?card_id='+user[0]+'>'+user[1]+'</a>'
			var link_ip = '<a href=https://yandex.ru/search/?text='+user[22]+' target=_blank>'+user[22]+'</a>';
			$('#user_info tr:nth-child(2) td:nth-child(2)').html(user[0]);
			$('#user_info tr:nth-child(3) td:nth-child(2)').html(link_card);
			$('#user_info tr:nth-child(4) td:nth-child(2)').html(link_ip);
			$('#user_info tr:nth-child(5) td:nth-child(2)').html(user[2]+'/'+user[3]);
			$('#user_info tr:nth-child(6) td:nth-child(2)').html(user[5]);
			$('#user_info tr:nth-child(7) td:nth-child(2)').html(user[6]);
			$('#user_info tr:nth-child(8) td:nth-child(2)').html(user[7]);
			$('#user_info tr:nth-child(9) td:nth-child(2)').html(user[8]);
			$('#user_info tr:nth-child(10) td:nth-child(2)').html(user[9]);
			$('#user_info tr:nth-child(11) td:nth-child(2)').html(user[10]);
			$('#user_info tr:nth-child(12) td:nth-child(2)').html(user[11]);
			$('#user_info tr:nth-child(13) td:nth-child(2)').html(user[16]);
			$('#user_info tr:nth-child(14) td:nth-child(2)').html(user[17]+' '+user[18]+' '+user[19]);
			$('#user_info tr:nth-child(15) td:nth-child(2)').html(user[20]);
			$('#user_info tr:nth-child(16) td:nth-child(2)').html(user[26]);
			$('#user_info tr:nth-child(17) td:nth-child(2)').html(user[27]);
			$('#user_info tr:nth-child(18) td:nth-child(2)').html(user[28]);
			$('#user_info tr:nth-child(19) td:nth-child(2)').html(user[30]);
			$('#user_info tr:nth-child(20) td:nth-child(2)').html(user[24]);
		});
	}
	
	window.trans_all = <?=$trans_all?>;
	//проверка новых транзакций
	setInterval(function(){
		$.get('../ajax/user_info.php?trans_all='+window.trans_all, function(data) {
			var trans_new = jQuery.parseJSON(data);
			if(trans_new[0] != 'n'){
				//window.trans_all = window.trans_all + trans_new.length - 1;
				for(i = 0; i <= trans_new.length-2; i++){
						var html_inc =
						`<tr>
							<td>${trans_new[i]['id']} <span class="label label-danger">new</span></td>
							<td><a onclick="user_info($(this))" href="javascript:;" data-toggle="modal" data-target="#myModal_info" name="butt_issuse">${trans_new[i]['fromid']}</a></td>
							<td><a onclick="user_info($(this))" href="javascript:;" data-toggle="modal" data-target="#myModal_info" name="butt_issuse">${trans_new[i]['toid']}</a></td>
							<td>${trans_new[i]['sum']}</td>
							<td>${trans_new[i]['timestamp']}</td>
							<td>${trans_new[i]['comment']}</td>
							<td>${trans_new[i]['iswithdraw']}</td>
							<td>${trans_new[i]['bankomat']}</td>
						  </tr>`;
						console.log("trans_new[i][id]: "+trans_new[i]['id']);
						$(html_inc).insertAfter('#transaction tr:nth-child(3)');
				}
				i--;
				window.trans_all = trans_new[i]['id'];
                console.log("trans_all: "+window.trans_all);	
			}
		});
		
	}, 300000);
</script>
<?}
$jsScript = false;
function pagination_5($mysqli, $query1, $num){
	// Определяем общее число сообщений в базе данных
	$posts = mysqli_fetch_array(mysqli_query($mysqli, "SELECT MAX(id) FROM transactions"));

	// Находим общее число страниц
	$total = intval(($posts['MAX(id)'] - 1) / $num) + 1;
	
	// Извлекаем из URL текущую страницу
	$page = $_GET['page'];
	$page = intval($page);
	// Если значение $page меньше единицы или отрицательно
	// переходим на первую страницу
	// А если слишком большое, то переходим на последнюю
	if(empty($page) or $page < 0) $page = 1;
	if($page > $total) $page = $total;
	// Вычисляем начиная к какого номера
	// следует выводить сообщения
	$start = $page * $num - $num;
	// Выбираем $num сообщений начиная с номера $start
	$result = mysqli_query($mysqli, "SELECT * FROM transactions $query1 LIMIT $start, $num;");
	// В цикле переносим результаты запроса в массив $postrow
	while ( $postrow[] = mysqli_fetch_array($result));
	
	$navbeg = '<nav aria-label="Page navigation"><ul class="pagination">';
	$navend = '</ul></nav>';
	
	// Проверяем нужны ли стрелки назад
	if ($page != 1) $pervpage = 
		'<li>
		  <a href=?settings=5&page=1 aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
		  </a>
		</li>
		<li>
		  <a href=?settings=5&page='. ($page - 1) .' aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
		  </a>
		</li>';
		
	// Проверяем нужны ли стрелки вперед
	if ($page != $total) $nextpage = 
		'<li>
		  <a href=?settings=5&page='. ($page + 1) .' aria-label="Next">
			<span aria-hidden="true">&raquo;</span>
		  </a>
		</li>
		<li>
		  <a href=?settings=5&page=' .$total. ' aria-label="Next">
			<span aria-hidden="true">&raquo;</span>
		  </a>
		</li>';

	// Находим две ближайшие станицы с обоих краев, если они есть
	if($page - 2 > 0) $page2left = '<li><a href= ?settings=5&page='. ($page - 2) .'>'. ($page - 2) .'</a></li>';
	if($page - 1 > 0) $page1left = '<li><a href= ?settings=5&page='. ($page - 1) .'>'. ($page - 1) .'</a></li>';
	if($page + 2 <= $total) $page2right = '<li><a href= ?settings=5&page='. ($page + 2) .'>'. ($page + 2) .'</a></li>';
	if($page + 1 <= $total) $page1right = '<li><a href= ?settings=5&page='. ($page + 1) .'>'. ($page + 1) .'</a></li>';
	$curpage = '<li class="active"><a href="#">'.$page.'<span class="sr-only">(current)</span></a></li>';

	// Вывод
	return json_encode(array($postrow, $navbeg.$pervpage.$page2left.$page1left.$curpage.$page1right.$page2right.$nextpage.$navend, $posts['MAX(id)']));
	
}

