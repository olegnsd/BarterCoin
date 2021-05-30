<?
$card = null;

if (!empty($_COOKIE['card1']) && !empty($_COOKIE['card2']) && !empty($_COOKIE['card3']) && !empty($_COOKIE['card4'])) {
    $card = getcard($_COOKIE['card1'],$_COOKIE['card2'],$_COOKIE['card3'],$_COOKIE['card4']);
}

?>

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

        <noscript>
            <div>
                <img src="https://mc.yandex.ru/watch/39490575" style="position:absolute; left:-9999px;" alt="" />
            </div>
        </noscript>
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

<? if (!empty($_SESSION['showForm'])): ?>
    <script>$(document).ready(function(){$('.clientLogin > form').toggleClass('clicked');});</script>
    <? unset($_SESSION['showForm']); ?>
<? endif; ?>
                            <li class="clientAreaLi">
                                <span onclick="$('.clientLogin > form').toggleClass('clicked');">
                                    <i class="fa fa-credit-card"></i>
                                    <? if(!$card): ?>
                                        Моя карта
                                    <? else: ?>
                                        Моя карта: <?= outputCard($card) ?>
                                    <? endif; ?>
                                </span>
                            </li>
<? if ($card && $card['black'] != 1): ?>
    <li class="clientAreaLi">
        <span  onclick="$('.clientLogin > form').toggleClass('clicked');" style="background: #73b825;margin: 0;margin-left: -4px;">Баланс: <?=number_format($card['balance'],0, ',',' ');?> БР</span>
    </li>
<? endif; ?>
                        </ul>
                        <div class="clientLogin">
                            <? 
                            if ($card && $card['black'] != 1)
                                include(__DIR__.'/../../pages/delete_form.php');
                            else
                                include(__DIR__.'/../../pages/save_form.php');
                            ?>
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
