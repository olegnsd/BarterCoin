<!DOCTYPE html>
<html lang="en">
    <head>
<base href="<?=$baseHref;?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BarterCoin</title>

    <!-- main css file -->
    <link rel="stylesheet" href="css/custom/style.css?">
    <!-- responsive css file -->
    <link rel="stylesheet" href="css/responsive/responsive.css">
    <!-- favicon -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">



    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script src="js/jquery.min.js"></script> <!-- jQuery -->
<script src="js/jquery.maskedinput.min.js"></script>
        <script src="js/bootstrap.min.js"></script> <!-- Bootstrap -->

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
<!-- /Yandex.Metrika counter -->

    </head>
    <body class="home">


    <!-- ======= 1.01 Header Area ====== -->
    <header>
        <div class="headerTopArea">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-sm-2 col-xs-12">
<span class="langIcon" style="cursor:default;"><!--Текст--></span>
                    </div>
                    <div class="col-md-7 col-sm-10 col-xs-12">
                        <ul class="topInfo">
                            <!--li class="call"><a href="tel:+214-5212-829"><i class="icofont icofont-ui-call"></i>+214-5212-829</a></li>
                            <li class="email"><a href="mailto:support@spark.com"><i class="icofont icofont-ui-v-card"></i>support@spark.com</a></li-->
<?if($_POST['savenum']){?>
    <script>$(document).ready(function(){$('.clientLogin > form').toggleClass('clicked');});</script><?$card=getcard($_POST['savenum'],$_POST['savemonth'],$_POST['saveyear'],$_POST['savecvc']);
    if($card['black'] == 1)unset($card);
    if($card && $card['black'] != 1){
        setcookie ( 'card1', $_POST['savenum'],time()+60*60*24*30, '/');setcookie ( 'card2', $_POST['savemonth'],time()+60*60*24*30, '/');setcookie ( 'card3', $_POST['saveyear'],time()+60*60*24*30, '/');setcookie ( 'card4', $_POST['savecvc'],time()+60*60*24*30, '/');
    }
}
if($_COOKIE['card1']){$card=getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);}?>
<?if($_POST['delsave']){?><script>$('.clientLogin > form').toggleClass('clicked');</script><?$card=FALSE;setcookie ( 'card1', '',time()+60*60*24*30, '/');setcookie ( 'card2', '',time()+60*60*24*30, '/');setcookie ( 'card3', '',time()+60*60*24*30, '/');setcookie ( 'card4', '',time()+60*60*24*30, '/');}?>
                            <li class="clientAreaLi"><span onclick="$('.clientLogin > form').toggleClass('clicked');"><i class="fa fa-credit-card"></i><?if(!$card){?>Моя карта<?}else{?>Моя карта: <?=substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4);?><?}?></span></li>
<?if($card && $card['black'] != 1){?><li class="clientAreaLi"><span  onclick="$('.clientLogin > form').toggleClass('clicked');" style="background: #73b825;margin: 0;margin-left: -4px;">Баланс: <?=number_format($card['balance'],0, ',',' ');?> БР</span><?}?>
                        </ul>
                      <div class="clientLogin">
    						<form method="post" class="" id="savecard"><?if($card && $card['black'] != 1){?>
<div class="closeBtn" onclick="$('.clientLogin > form').toggleClass('clicked');"><i class="fa fa-close"></i></div>
    							<div class="h5">Ваша карта сохранена</div>
    							<input type="text" readonly class="form-control cardnum" placeholder="Номер карты" value="<?=substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4);?>"><br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" readonly class="form-control cardnum" placeholder="Месяц" value="<?=$card['expiremonth'];?>"></div>
<div class="col-sm-2  col-xs-12 text-center" style="line-height: 34px;font-size: 20px;color: white;">/</div>
<div class="col-sm-5  col-xs-12"><input type="text" readonly class="form-control cardnum" placeholder="Год" value="<?=$card['expireyear'];?>"></div>
</div>

<br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" readonly class="form-control cardnum" placeholder="CVC" value="<?=$card['cvc'];?>"></div>
<div class="col-sm-7  col-xs-12"><input type="submit" name="delsave" style="line-height: 34px;width: 100%;padding: 0;background:#b32525;" value="Удалить"></div>
</div>
<?}else{?>
    							<div class="closeBtn" onclick="$('.clientLogin > form').toggleClass('clicked');"><i class="fa fa-close"></i></div>
    							<div class="h5">Введите данные вашей карты чтобы сохранить их</div>
<?if($_POST['savenum']){?><div class="alert alert-danger">Карта не найдена</div><?}?>
    							<input autofocus="" type="text" class="form-control cardnum" placeholder="Номер карты" name="savenum" required=""><br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="Месяц" name="savemonth" required=""></div>
<div class="col-sm-2  col-xs-12 text-center" style="line-height: 34px;font-size: 20px;color: white;">/</div>
<div class="col-sm-5  col-xs-12"><input type="text" class="form-control cardnum" placeholder="Год" name="saveyear" required=""></div>
</div>

<br>
<div class="row">
<div class="col-sm-5 col-xs-12"><input type="text" class="form-control cardnum" placeholder="CVC" name="savecvc" required=""></div>
<div class="col-sm-7  col-xs-12"><input type="submit" style="line-height: 34px;width: 100%;padding: 0;" value="Сохранить"></div>
</div><script type="text/javascript">

jQuery(function($) {

$.mask.definitions['~']='[+-]';
//
$('#savecard [name=savenum]').mask('9999 9999 9999 9999',{completed:function(){$('#savecard [name=savemonth]').focus();}});

$('#savecard [name=savemonth]').mask('99',{completed:function(){$('#savecard [name=saveyear]').focus();}});

$('#savecard [name=saveyear]').mask('99',{completed:function(){$('#savecard [name=savecvc]').focus();}});

$('#savecard [name=savecvc]').mask('999',{completed:function(){$('#savecard input[type=submit]').focus();}});

///$('[name=sum]').mask('000.000.000.000.000,00',{reverse: true,completed:function(){$('#submit123').focus();}});



});</script>
    						<?}?>	
    						</form>
    					</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="headerBottomArea">
            <div class="container">
                <div class="row">
                    <div class="col-md-1 col-sm-2 col-xs-12">
                        <a href="<?=$baseHref;?>" class="logo"><img src="img/logo.png" alt=""></a>
                    </div>
                    <div class="col-md-11 menuCol col-sm-10 col-xs-12">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only"></span>
                                <i class="fa fa-navicon"></i>
                            </button>
                        </div>
                        <nav id="navbar" class="collapse navbar-collapse">
                            <ul id="nav">
<li<?if($_GET['page']=='index'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>">Главная</a></li>
<li<?if($_GET['page']=='faq'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>faq">FAQ</a></li>


                            <!--ul id="nav2"-->

<li<?if($_GET['page']=='activate'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>activate">Активация карты</a></li>
<li<?if($_GET['page']=='check'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>check">Проверка баланса</a></li>
<li<?if($_GET['page']=='send'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>send">Перевод БР с карты на карту</a></li>
<li<?if($_GET['page']=='deposit'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>deposit">Пополнить баланс карты</a></li>
<li<?if($_GET['page']=='withdraw7'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>withdraw7">Вывод БР</a></li>
<li><a href="http://bartervito.holding.bz">Потратить БР</a></li>
<li<?if($_GET['page']=='api'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>api">Приём платежей с сайта</a></li>
<li<?if($_GET['page']=='create'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>create">Получить карту (регистрация)</a></li>
<li<?if($_GET['page']=='restore'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>restore">Восстановить карту</a></li>
<li<?if($_GET['page']=='loan'){?> class="current-menu-item"<?}?>><a href="<?=$baseHref;?>loan" class='alert-xs alert-success'>Взять займ(без%)</a></li>
                                    </ul>
                                
                        </nav>
                    </div>
                    
                </div>
            </div>
        </div>
    </header>
    <!-- ======= /1.01 Header Area ====== -->


        <div class="container">
