<script src="../js/jquery.min.js"></script>

<div class="modal fade"  id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Конструктор формы</h4>
      </div>
      <div class="modal-body">
        <p>Назначение платежа(перевода)</p>
		<input name="form_pay"><br><br>
		<p>Код формы</p>
		  <textarea  name="form_cod" rows="5" cols="40"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="pageTitle">
<h2>Приём платежей с сайта</h2>
    					
    				</div>
<?if(!$card){include('loginform.php');}else{?>



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
</style><div class="row">
<div class="col-md-6 col-xs-12"><div class="card from"><div class="row">
<div class="col-xs-offset-1 col-xs-10 logo" style="height:120px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input type="text" class="form-control cardnum" readonly style="background: none;color: white;border: 0;    font-size: 25px;" placeholder="Номер карты" name="fromnum"<?if($card)echo(' value="'.substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4).'"');?> required=""></div>
<div class="col-xs-offset-1 col-xs-10 form-inline"><input type="num" name="frommonth"<?if($card)echo(' value="'.$card['expiremonth'].'"');?> class="form-control" readonly style="width:90px;display: inline;background: none;color: white;border: 0;    font-size: 25px;" placeholder="Месяц" required=""> / <input type="num" name="fromyear"<?if($card)echo(' value="'.$card['expireyear'].'"');?> class="form-control" readonly style="width:90px;display: inline;background: none;color: white;border: 0;    font-size: 25px;" placeholder="Год" required=""> <div style="float:right;">СVC: <input type="num" name="fromcvc"<?if($card)echo(' value="'.$card['cvc'].'"');?> class="form-control" readonly style="width:90px;display: inline;background: none;color: white;border: 0;    font-size: 25px;" placeholder="cvc" required=""></div></div>
</div>
</div></div>
<script>
setTimeout(function(){
$('.card.from').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=fromnum]').val().charAt(0)==3)$('.card.from').addClass('ae');
if($('[name=fromnum]').val().charAt(0)==2)$('.card.from').addClass('mi');
if($('[name=fromnum]').val().charAt(0)==4)$('.card.from').addClass('visa');
if($('[name=fromnum]').val().charAt(0)==5)$('.card.from').addClass('mc');
if($('[name=fromnum]').val().charAt(0)==6)$('.card.from').addClass('ma');
if($('[name=fromnum]').val().charAt(0)==1)$('.card.from').addClass('bc');
},1);
</script>


<div class="col-md-6 col-xs-12">
<?if($_POST['newname']!='' & $_POST['url']!=''){
$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
$max=16; 
$size=StrLen($chars)-1; 
while($max--)$key1.=$chars[rand(0,$size)]; 
$max=16; 
while($max--)$key2.=$chars[rand(0,$size)]; 
mysqli_query($mysqli,'INSERT INTO `shops` (`card`, `name`, `key1`, `key2`, `url`) VALUES ('.(int)$card['id'].', \''.mysqli_escape_string($mysqli,$_POST['newname']).'\', \''.$key1.'\', \''.$key2.'\', \''.mysqli_escape_string($mysqli,$_POST['url']).'\');');
?><div class="alert alert-success">Магазин добавлен</div><?
}?>
<?if($_GET['delete']!=''){
$data=mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM `shops` WHERE id='".(int)$_GET['delete']."' LIMIT 1;"));
if($data['card']==$card['id']){
mysqli_query($mysqli, "DELETE FROM `shops` WHERE `id` = ".(int)$_GET['delete']);
header('Location: '.$baseHref.'api?next='.(int)$_GET['next']);die();
}
}?>
<form method="post">
<div class="form-group">
<label>Название</label>
<input type="text" name="newname" class="form-control" required>
</div>
<div class="form-group">
<label>URL для подтверждения платежа</label>
<input type="text" name="url" class="form-control" required>
</div>
<div class="form-group">
<button type="submit" class="btn btn-success">Добавить магазин</button>
</div>
</form>

<button type="button" class="btn btn-success" id="form_pay" data-toggle="modal" data-target="#myModal">Добавить форму платежа на Ваш сайт</button>

</div>
<div class="col-xs-12"><br>
<h3>Ваши магазины</h3>
<?
pagination_main('shops',function($data){return '<tr><td>'.(int)$data['id'].'<td>'.htmlspecialchars($data['name']).'<td>'.htmlspecialchars($data['key1']).' / '.htmlspecialchars($data['key2']).'<td>'.htmlspecialchars($data['url']).'<td><a href="api?delete='.$data['id'].'&next='.(int)$_GET['next'].'" onclick="return confirm(\'Удалить?\');" class="btn btn-xs btn-block btn-danger"><i class="fa fa-trash"></i></a>';},'<table class="table table-bordered"><thead><th>ID<th>Имя<th>Ключи<th>URL подтверждения<th>&nbsp;</thead>%list%</table> %pagination%',15,'api?next=',$_GET['next'],'`card`='.(int)$card['id']);
?>
</div>
</div><div class="clearfix"></div><br><br></div><?}?>

<script>
	$("input[name='form_pay']").on('keyup keypress blur change', function(){
		var form_pay = $(this).val();
		var myObject = {
			comment: form_pay,
			account: <?=$card['number']?>
		};
		var recursiveEncoded = $.param( myObject );
		form_pay = "<iframe src='https://bartercoin.holding.bz/do/form_pay.php?"+recursiveEncoded+"'  width='423' height='226' frameborder='0' allowtransparency='true' scrolling='no'></iframe>";
		$("textarea[name='form_cod']").val(form_pay);
	});
</script>

