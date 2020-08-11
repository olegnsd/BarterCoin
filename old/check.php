<?include('config.php');if(!$_GET[ajax]){?><!DOCTYPE html>
<html>
<head>
<title>BarterCoin - Бартерная расчетная система</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<link href="css/styles.css?v=1.6" rel="stylesheet">
<!-- js -->
<script src="js/jquery.min.js"></script><script src="js/jquery.maskedinput.min.js"></script>
<script src="js/scripts.js?v=1.7"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>

<!-- start-smoth-scrolling --><!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = '6KCmuYT9SRmKqHrhN';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = (d.location.protocol === 'https:' ? 'https:': 'http:')
        + '//call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<!-- /Chatra {/literal} -->
</head>
	<body class="cbp-spmenu-push">
		<!-- header -->
		<div class="header-bg">
					
							<div class="header-top">
							<div class="container" style="position:relative;">

<div class="top-nav">
									<a href="/activate">Активация карты</a>
<a href="/check">Проверка баланса</a>
<a href="/send">Перевод Б₽ с карты на карту</a>
<a href="http://bartervito.holding.bz" target="_new" >Получить Б₽ на карту</a>

								</div>

								<div class="head-logo">
									<a href="/" style="color: #31708f;">BarterCoin - Бартерная расчетная система</a>
								</div>


								<div class="clearfix"> </div>
							</div>
						</div>
			
		</div>
		<!-- //header -->
		<!-- banner-bottom -->
		<div  class="banner-bottom">
			<!-- container -->
			<div class="container"><!--div class="alert alert-danger">Система начинает работу 15 января 2017 года</div-->
												<h2 style="text-align:center;">Проверка баланса карты</h2>
			</div>
			<!-- //container -->
		</div><div class="container">
		<!-- //banner-bottom --><script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';
//
$('[name=fromnum]').mask('9999 9999 9999 9999',{completed:function(){$('[name=frommonth]').focus();}});

$('[name=frommonth]').mask('99',{completed:function(){$('[name=fromyear]').focus();}});

$('[name=fromyear]').mask('99',{completed:function(){$('[name=fromcvc]').focus();}});

$('[name=fromcvc]').mask('999',{completed:function(){$('#submit123').focus();}});




});</script> <style>
.card{border: 2px dashed #dddfe0;
    border-radius: 14px;margin:0 auto;
    transition: .3s ease all;height: 276px;width:420px;}
.card.ae{background-color: #007cc2;background-image:url(images/ae.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.visa{background-color: #ffa336;background-image:url(images/visa.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.mc{background-color: #971010;background-image:url(images/mc.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.ma{background-color: #0079f0;background-image:url(images/ma.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.mi{background-color: #4ca847;background-image:url(images/mi.png);background-position: 230px 210px;background-repeat:no-repeat;}
.card.bc{background-color: #3d2b1f;background-image:url(images/bc.png);background-position: 230px 210px;background-repeat:no-repeat;}

.from.ae p{display:block !important;}
.from.visa p{display:block !important;}
.from.mc p{display:block !important;}
.from.ma p{display:block !important;}
.from.mi p{display:block !important;}
</style>
<form id="form" method=post  onsubmit="var msg   = $('#form').serialize();
        $.ajax({
          type: 'POST',
          url: 'check?ajax=1',
          data: msg,
          success: function(data) {
            $('.ajax').html(data);
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });return false;">
<div class="col-md-5"><div class="card from"><div class="row">
<div class="col-xs-offset-1 col-xs-10 logo" style="height:120px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input autofocus type="text" onkeydown="setTimeout(function(){
$('.card.from').removeClass('visa').removeClass('mc').removeClass('bc').removeClass('ae').removeClass('ma').removeClass('mi');
if($('[name=fromnum]').val().charAt(0)==3)$('.card.from').addClass('ae');
if($('[name=fromnum]').val().charAt(0)==2)$('.card.from').addClass('mi');
if($('[name=fromnum]').val().charAt(0)==4)$('.card.from').addClass('visa');
if($('[name=fromnum]').val().charAt(0)==5)$('.card.from').addClass('mc');
if($('[name=fromnum]').val().charAt(0)==6)$('.card.from').addClass('ma');
if($('[name=fromnum]').val().charAt(0)==1)$('.card.from').addClass('bc');
},1);" class="form-control cardnum" placeholder="Номер карты" name="fromnum" required></div>
<div class="col-xs-offset-1 col-xs-10 form-inline"><input type="num" name="frommonth" class="form-control" style="width:90px;display: inline;" placeholder="Месяц" required> / <input type="num" name="fromyear" class="form-control" style="width:90px;display: inline;" placeholder="Год" required> <div style="float:right;">СVV: <input type="num" name="fromcvc" class="form-control" style="width:90px;display: inline;" placeholder="cvc" required></div></div>
<p style="color:red;padding: 30px;display:none;">Можно узнать баланс<br>только карт BarterCoin</p>
</div>
</div></div>
<div class="col-md-2"><i style="font-size: 30px;padding-top: 100px;text-align:center;display:block;" class="glyphicon glyphicon-chevron-right"></i></div>
<div class="col-md-5"><div class="to"><br><br><br><br><br><div class="ajax" style="text-align:center;"><?}if($_POST[fromnum]){?><button type="submit" id="submit123" class="btn btn-success btn-lg">Узнать баланс</button><br><br><?$_POST[fromnum]=str_replace(' ','',$_POST[fromnum]);
$card=mysqli_query($mysqli,"SELECT COUNT(*) FROM accounts WHERE number='".mysqli_escape_string($mysqli,$_POST[fromnum])."' AND expiremonth='".mysqli_escape_string($mysqli,$_POST[frommonth])."' AND expireyear='".mysqli_escape_string($mysqli,$_POST[fromyear])."' AND cvc='".mysqli_escape_string($mysqli,$_POST[fromcvc])."' AND activated='1'");
$card=mysqli_fetch_assoc($card);
if($card["COUNT(*)"]==0){
?><div class="alert alert-danger">Не существует такой карты, либо она не активирована</div><?}else{
$card=mysqli_query($mysqli,"SELECT * FROM accounts WHERE number='".mysqli_escape_string($mysqli,$_POST[fromnum])."' AND expiremonth='".mysqli_escape_string($mysqli,$_POST[frommonth])."' AND expireyear='".mysqli_escape_string($mysqli,$_POST[fromyear])."' AND cvc='".mysqli_escape_string($mysqli,$_POST[fromcvc])."' AND activated='1'");
$card=mysqli_fetch_assoc($card);
?>
<div class="alert alert-success">
Баланс карты <?=substr($card[number],0,4);?> **** **** *<?=substr($card[number],-3);?>:<br><b><?=number_format($card[balance], 2, ',', ' ');?> BCR</b><?if($card[lim]>0){?><br>Возможен выход в минус до <b><?=number_format($card[lim], 2, ',', ' ');?> BCR</b><?}?>
</div>
<?}
?><?}else{?><button type="submit" id="submit123" class="btn btn-success btn-lg">Узнать баланс</button><?}if(!$_GET[ajax]){?></div><!--button type="submit" id="submit123" class="btn btn-success btn-lg">Перевести валюту <i class="glyphicon glyphicon-chevron-right"></i></button-->
</div><div class="clearfix"></div></form>
</div></div><br><br><br>

<br><br><br>
		<!-- footer -->
		<div class="footer">
			<!-- container -->
			<div class="container">
				<div class="footer-info">

					<!--div class="store-buttons">
<center>			<a href="javascript:alert('Приложение в разработке');" class="btn btn-appstore" target="_blank"><img src="images/btn-appstore.png" alt="App Store"></a>
						<a href="javascript:alert('Приложение в разработке');" class="btn btn-googleplay" target="_blank"><img src="images/btn-googleplay.png" alt="Google Play"></a></center>
					</div-->
				</div>
				<div class="copyright">
					<p> © <a href="http://ksri.holding.bz">ПАО "Конструктор Империй"</a> / <a href="http://www.holding.bz">ПАО "Милитари Холдинг"</a> </p>
				</div>
			</div>
			<!-- //container -->
		</div>
		<!-- //footer -->
		<script type="text/javascript">
									$(document).ready(function() {
										/*
										var defaults = {
								  			containerID: 'toTop', // fading element id
											containerHoverID: 'toTopHover', // fading element hover id
											scrollSpeed: 1200,
											easingType: 'linear' 
								 		};
										*/
										
										$().UItoTop({ easingType: 'easeOutQuart' });
										
									});
								</script>
									<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- content-Get-in-touch -->
	<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter39490575 = new Ya.Metrika({
                    id:39490575,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/39490575" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter --></body>
</html><?}?>
