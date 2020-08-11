<div class="pageTitle">
<h2>Перевод валюты с карты на карту</h2>
    					
    				</div>

<script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';
//
$('[name=fromnum]').mask('9999 9999 9999 9999',{completed:function(){$('[name=frommonth]').focus();}});

$('[name=frommonth]').mask('99',{completed:function(){$('[name=fromyear]').focus();}});

$('[name=fromyear]').mask('99',{completed:function(){$('[name=fromcvc]').focus();}});

$('[name=fromcvc]').mask('999',{completed:function(){$('[name=tonum]').focus();}});

$('[name=tonum]').mask('9999 9999 9999 9999',{completed:function(){$('[name=sum]').focus();}});
$('[name=tophone]').mask('9(999) 999 99 99',{completed:function(){$('[name=sum]').focus();}});
///$('[name=sum]').mask('000.000.000.000.000,00',{reverse: true,completed:function(){$('#submit123').focus();}});



});</script>
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
</style><form method="POST" action="<?=$baseHref;?>do/" target="_blank">
<input type="hidden" name="action" value="send">
<div class="col-md-5 col-xs-12"><div class="card from"><div class="row">
<div class="col-xs-offset-1 col-xs-10 logo" style="height:120px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input autofocus="" type="text" onkeydown="setTimeout(function(){
$('.card.from').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=fromnum]').val().charAt(0)==3)$('.card.from').addClass('ae');
if($('[name=fromnum]').val().charAt(0)==2)$('.card.from').addClass('mi');
if($('[name=fromnum]').val().charAt(0)==4)$('.card.from').addClass('visa');
if($('[name=fromnum]').val().charAt(0)==5)$('.card.from').addClass('mc');
if($('[name=fromnum]').val().charAt(0)==6)$('.card.from').addClass('ma');
if($('[name=fromnum]').val().charAt(0)==1)$('.card.from').addClass('bc');
},1);" class="form-control cardnum" placeholder="Номер карты" name="fromnum"<?if($card)echo(' value="'.substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4).'"');?> required=""></div>
<div class="col-xs-offset-1 col-xs-10 form-inline"><input type="num" name="frommonth"<?if($card)echo(' value="'.$card['expiremonth'].'"');?> class="form-control" style="width:90px;display: inline;" placeholder="Месяц" required=""> / <input type="num" name="fromyear"<?if($card)echo(' value="'.$card['expireyear'].'"');?> class="form-control" style="width:90px;display: inline;" placeholder="Год" required=""> <div style="float:right;">СVC: <input type="num" name="fromcvc"<?if($card)echo(' value="'.$card['cvc'].'"');?> class="form-control" style="width:90px;display: inline;" placeholder="cvc" required=""></div></div>
<p style="color:red;padding: 30px;display:none;">Перевод возможен<br>только с карт BarterCoin</p>
</div>
</div></div><script>
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
<div class="col-md-2 hidden-sm hidden-xs"><i style="font-size: 30px;padding-top: 100px;text-align:center;display:block;" class="fa fa-chevron-right"></i></div>
<div class="col-md-2 col-xs-12 hidden-md hidden-lg"><i style="font-size: 30px;text-align:center;display:block;" class="fa fa-chevron-down"></i></div>
<div class="col-md-5 col-xs-12"><div class="card to"><div class="row">
<div class="col-xs-offset-1 col-xs-10" style="height:120px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input type="text" onkeydown="setTimeout(function(){
$('.card.to').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=tonum]').val().charAt(0)==3)$('.card.to').addClass('ae');
if($('[name=tonum]').val().charAt(0)==2)$('.card.to').addClass('mi');
if($('[name=tonum]').val().charAt(0)==4)$('.card.to').addClass('visa');
if($('[name=tonum]').val().charAt(0)==5)$('.card.to').addClass('mc');
if($('[name=tonum]').val().charAt(0)==6)$('.card.to').addClass('ma');
if($('[name=tonum]').val().charAt(0)==1)$('.card.to').addClass('bc');
},1);" name="tonum" class="form-control cardnum" placeholder="Номер карты">
</div>
<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;">или</div>
<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input type="text" onkeydown="setTimeout(function(){
$('.card.to').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=tophone]').val().charAt(0)==7)$('.card.to').addClass('bc');
if($('[name=tophone]').val().charAt(0)==8)$('.card.to').addClass('bc');
if($('[name=tophone]').val().charAt(0)=='+')$('.card.to').addClass('bc');
},1);" name="tophone" class="form-control cardnum" placeholder="Номер телефона">
</div>
<p style="color:red;padding: 30px;display:none;">Перевод возможен<br>только на карты BarterCoin</p>
</div>
</div></div><div class="clearfix"></div><div style="text-align:center;padding-top:20px;"><input type="number" class="form-control" placeholder="Сумма перевода" name="sum" style="width:200px;margin:0 auto;margin-bottom:15px;" required=""><button type="submit" id="submit123" class="btn btn-success btn-lg">Перевести валюту <i class="fa fa-chevron-right"></i></button>
<br><br>
<div class="btn-group" role="group">
	<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Настройка отложенных платежей для расчетов
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li><a class="btn btn-default btn-md" href='/pay_card'>Настройка платиковых карт для расчетов</a></li>
		<li><a class="btn btn-default btn-md" href='/pay_phone'>Настройка телефонов для расчетов</a></li>
	</ul>
</div>
</div><br><br></form>
