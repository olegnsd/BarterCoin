<?php
//session_start();
ini_set('display_errors', 0);
if($auth){

if($_GET['sort9']){
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
    ${$temp} = ' <a href="?settings=9&sort9='.$i.'"><i class="fa fa-chevron-'. $class .'"></i></a>';
    
}

$query = array('ORDER BY l.id', 'ORDER BY u.name', 'ORDER BY u.util_value', 'ORDER BY l.util_pay', 'ORDER BY l.date');

$query1 = 'ORDER BY l.id DESC';
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

$res = json_decode(pagination_9($mysqli, $query1, $num), true);
$transactions = $res[0];
$navigation = $res[1];
$trans_all = $res[2];

$name_all = mysqli_query($mysqli, "SELECT u.id AS u_id, u.name, u.last_pay AS last_date_pay FROM util AS u ORDER BY u.prior DESC");
sql_err($mysqli, 'name_all');
foreach($name_all as $name_one){
    $transactions_all[] = mysqli_query($mysqli, "SELECT SUM(util_pay) FROM util_log WHERE util_id='".$name_one['u_id']."'");
    sql_err($mysqli, 'transactions_all');
    $transactions_m[] = mysqli_query($mysqli, "SELECT SUM(util_pay) FROM util_log WHERE date BETWEEN (SELECT SUBDATE(CURRENT_TIMESTAMP(), INTERVAL 1 MONTH)) AND CURRENT_TIMESTAMP() AND util_id='".$name_one['u_id']."'");
    sql_err($mysqli, 'transactions_m');
    $transactions_d[] = mysqli_query($mysqli, "SELECT SUM(util_pay) FROM util_log WHERE date BETWEEN (SELECT SUBDATE(CURRENT_TIMESTAMP(), INTERVAL 1 DAY)) AND CURRENT_TIMESTAMP() AND util_id='".$name_one['u_id']."'");
    sql_err($mysqli, 'transactions_d');
    $transactions_l[] = mysqli_query($mysqli, "SELECT util_pay FROM util_log WHERE util_id='".$name_one['u_id']."' ORDER BY date DESC LIMIT 1");
    sql_err($mysqli, 'transactions_l');
    
    $tran_sum_all = mysqli_fetch_array(mysqli_query($mysqli, "SELECT SUM(util_pay) FROM util_log "));
    sql_err($mysqli, 'tran_sum_all');
    $tran_sum_m = mysqli_fetch_array(mysqli_query($mysqli, "SELECT SUM(util_pay) FROM util_log WHERE date BETWEEN (SELECT SUBDATE(CURRENT_TIMESTAMP(), INTERVAL 1 MONTH)) AND CURRENT_TIMESTAMP()"));
    sql_err($mysqli, 'tran_sum_m');
    $tran_sum_d = mysqli_fetch_array(mysqli_query($mysqli, "SELECT SUM(util_pay) FROM util_log WHERE date BETWEEN (SELECT SUBDATE(CURRENT_TIMESTAMP(), INTERVAL 1 DAY)) AND CURRENT_TIMESTAMP()"));
    sql_err($mysqli, 'tran_sum_d');
}
mysqli_data_seek($name_all, 0);
    
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
					<td>Название</td>
					<td></td>
				  </tr>
				  <tr>
					<td>ID услуги куда платить</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Идентификатор провайдера киви</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Пополнять, руб</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Пополнять раз в, дней</td>
					<td></td>
				  </tr>
                  <tr>
					<td>Время пополнения</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Приоритет</td>
					<td></td>
				  </tr>
				  <tr>
					<td>Мин донора, руб</td>
					<td></td>
				  </tr>
                  <tr>
					<td>Пополнять</td>
					<td></td>
				  </tr>
                  <tr>
					<td>Последнее пополнение</td>
					<td></td>
				  </tr>
                  <tr>
					<td>Запуск крона</td>
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
<div class="col-md-12 col-xs-12">
    <div class="panel panel-default">
      <!-- Default panel contents -->
		<caption class="bg-info">
			<h2 class="text-center">История пополнений</h2>
		</caption>
      <!-- Table -->
      <div class='table-responsive'>
      <table class="table table-hover table-condensed" id='transaction'>
          <tr>
            <th>Название</th>
            <th>Пополнено за 24ч, руб</th>
            <th>Пополнено за месяц, руб</th>
            <th>Пополнено за все время, руб</th>
            <th>Последнее пополнение, руб</th>
            <th>Дата последнего пополнения</th>
          </tr>
        <? 
        foreach($name_all as $key => $name){
            $trans_d = mysqli_fetch_array($transactions_d[$key]);
            $trans_m = mysqli_fetch_array($transactions_m[$key]);
            $trans_all = mysqli_fetch_array($transactions_all[$key]);
            $trans_l = mysqli_fetch_array($transactions_l[$key]);
        ?>
          <tr>
			<td><a href="javascript:;" akcion='1' data-toggle="modal" data-target="#myModal_info" name="butt_issuse" trans_id="<?=$name['u_id']?>"><?=$name['name']?></a></td>
            <td><?=$trans_d['SUM(util_pay)']?></td>
            <td><?=$trans_m['SUM(util_pay)']?></td>
            <td><?=$trans_all['SUM(util_pay)']?></td>
			<td><?=$trans_l['util_pay']?></td>
			<td><?=$name['last_date_pay']?></td>
          </tr>
        <?}?>
        <tr>
            <td><b>ИТОГО</b></td>
            <td><b><?=$tran_sum_d['SUM(util_pay)']?></b></td>
            <td><b><?=$tran_sum_m['SUM(util_pay)']?></b></td>
            <td><b><?=$tran_sum_all['SUM(util_pay)']?></b></td>
            <td></td>
            <td></td>
        </tr>
      </table>
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
      <table class="table table-hover table-condensed" id='transaction'>
          <tr>
            <th>id операц</th>
            <th>Название</th>
            <th>Пополнять, руб</th>
            <th>Пополнено, руб</th>
            <th>Дата</th>
          </tr>
          <tr>
            <td><?=$sort_up_dwn_1?></td>
            <td><?=$sort_up_dwn_2?></td>
            <td><?=$sort_up_dwn_3?></td>
            <td><?=$sort_up_dwn_4?></td>
            <td><?=$sort_up_dwn_5?></td>
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
        foreach($transactions as $trans){?>
          <tr>
			<td><?=$trans['l_id']?></td>
			<td><a href="javascript:;" akcion='1' data-toggle="modal" data-target="#myModal_info" name="butt_issuse" trans_id="<?=$trans['u_id']?>"><?=$trans['name']?></a></td>
			<td><?=$trans['util_value']?></td>
			<td><?=$trans['util_pay']?></td>
			<td><?=$trans['date']?></td>
          </tr>
        <?}
        ?>
		  <tr>
			  <td colspan='5'><?=$navigation?></td>
		  </tr>
      </table>
      </div>
    </div>   
</div>
</body>
<script>window.trans_all = <?=$trans_all?>;</script>
<script >
    $('a[akcion=1]').each(function() {
        $(this).on('click', function () {
            trans_id = $(this).attr('trans_id');
            $.get('../ajax/user_info.php?trans_id='+trans_id, function(data) {
				//alert(data);
                var user = jQuery.parseJSON(data);
                if(user[9]=='1'){
                    user9 = 'Да';
                }else{
                    user9 = 'Нет';
                }
                $('#user_info tr:nth-child(2) td:nth-child(2)').html(user[1]);
                $('#user_info tr:nth-child(3) td:nth-child(2)').html(user[2]);
                $('#user_info tr:nth-child(4) td:nth-child(2)').html(user[3]);
                $('#user_info tr:nth-child(5) td:nth-child(2)').html(user[4]);
                $('#user_info tr:nth-child(6) td:nth-child(2)').html(user[5]);
                $('#user_info tr:nth-child(7) td:nth-child(2)').html(user[6]);
                $('#user_info tr:nth-child(8) td:nth-child(2)').html(user[7]);
                $('#user_info tr:nth-child(9) td:nth-child(2)').html(user[8]);
                $('#user_info tr:nth-child(10) td:nth-child(2)').html(user9);
                $('#user_info tr:nth-child(11) td:nth-child(2)').html(user[10]);
                $('#user_info tr:nth-child(12) td:nth-child(2)').html(user[11]);
            });
        });
    });
</script>
<?}
$jsScript = false;
function pagination_9($mysqli, $query1, $num){
	// Определяем общее число сообщений в базе данных
	$posts = mysqli_fetch_array(mysqli_query($mysqli, "SELECT MAX(id) FROM util_log"));
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
	$result = mysqli_query($mysqli, "SELECT u.id AS u_id, l.id AS l_id, u.name, u.util_value, l.util_pay, l.date FROM util AS u, util_log AS l WHERE u.id=l.util_id $query1 LIMIT $start, $num;");
	// В цикле переносим результаты запроса в массив $postrow
	while ( $postrow[] = mysqli_fetch_array($result));
	$navbeg = '<nav aria-label="Page navigation"><ul class="pagination">';
	$navend = '</ul></nav>';
	
	// Проверяем нужны ли стрелки назад
	if ($page > 1) $pervpage = 
		'<li>
		  <a href=?settings=9&page=1 aria-label="Previous">
			<span aria-hidden="true">1</span>
		  </a>
		</li>
		<li>
		  <a href=?settings=9&page='. ($page - 1) .' aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
		  </a>
		</li>';
		
	// Проверяем нужны ли стрелки вперед
	if ($page < $total) $nextpage = 
		'<li>
		  <a href=?settings=9&page='. ($page + 1) .' aria-label="Next">
			<span aria-hidden="true">&raquo;</span>
		  </a>
		</li>
		<li>
		  <a href=?settings=9&page=' .$total. ' aria-label="Next">
			<span aria-hidden="true">'.$total.'</span>
		  </a>
		</li>';

	// Находим две ближайшие станицы с обоих краев, если они есть
	if($page - 2 > 0) $page2left = '<li><a href= ?settings=9&page='. ($page - 2) .'>'. ($page - 2) .'</a></li>';
	if($page - 1 > 0) $page1left = '<li><a href= ?settings=9&page='. ($page - 1) .'>'. ($page - 1) .'</a></li>';
	if($page + 2 <= $total) $page2right = '<li><a href= ?settings=9&page='. ($page + 2) .'>'. ($page + 2) .'</a></li>';
	if($page + 1 <= $total) $page1right = '<li><a href= ?settings=9&page='. ($page + 1) .'>'. ($page + 1) .'</a></li>';
	$curpage = '<li class="active"><a href="#">'.$page.'<span class="sr-only">(current)</span></a></li>';

	// Вывод
	return json_encode(array($postrow, $navbeg.$pervpage.$page2left.$page1left.$curpage.$page1right.$page2right.$nextpage.$navend, $posts['MAX(id)']));
	
}

//вывод ошибок sql
function sql_err($mysqli, $fun){
    $myecho = json_encode(mysqli_error($mysqli), JSON_UNESCAPED_UNICODE);
    if(strlen($myecho) > 5)`echo " $fun : "  $myecho >>/home/bartercoin/tmp/qaz_pay_util`;
    return;
}

