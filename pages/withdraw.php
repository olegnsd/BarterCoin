<? if (!$card) {
    include('loginform.php');
} else {
    $b = htmlspecialchars($_GET['b']);

    //может ли использовать текущий банкомат
    $bankomats = json_decode($card['bankomats'], true);
    $bankomats = $bankomats['allow'];
    if ($b <= 0 || $b > 9) {
        $err[] = 'Вы не можете пользоваться этим банкоматом';
    } elseif (!in_array($b, $bankomats)) {
        $err[] = 'Вы не можете пользоваться этим банкоматом!';
    }
    if (!$err[0]) {//на данный момент можно использовать банкомат
        $info = mysqli_query($mysqli, "SELECT token, amount FROM settings WHERE title='bankomat' AND amount='$b'");
        $info = mysqli_fetch_assoc($info);
        $token_proxy = json_decode($info["token"], true);
        $title = ($token_proxy["title"]);
        $balance = get_bank($mysqli, $b);//file_get_contents('/home/bartercoin/tmp/bankbalance'.$b);
        //сумма для снятия в input
        $sum = floor($balance - 0.03 * $balance);
        if ($sum > 100) $sum = 100;
        if ($sum > $card['balance']) $sum = $card['balance'];
        if ($sum <= 0) $sum = 1;
        ?>
        <div class="row">
            <div class="col-md-6 col-xs-12">

                <div class="pageTitle">
                    <h2>Вывод БР, банкомат: <b><?= $title ?></b></h2>

                </div>


                <div id="ajaxresult">

                </div>
                <form onsubmit="$('#ajaxform button[type=submit]').attr('disabled','disabled').text('обработка...');var msg   = $('#ajaxform').serialize();
        $.ajax({
          type: 'POST',
          url: 'ajax/withdraw.php',
          data: msg,
          success: function(data) {
            $('#ajaxresult').html(data);
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });return false;" id="ajaxform" class="tobank">


                    <select name="system" class="form-control">
                        <? if ($b!=8 and $b!=9) {?>
                        <option value="qiwi">Кошелёк QIWI
                        <option value="ya">Яндекс.Деньги
                        <option value="webmoney">Webmoney
                        <option value="visa_mastercard">Visa
                        <?} else {?>
                        <option value="payeer">Payeer
                        <? }?>
                    </select><!-- (+3% к комиссии)-->
                    <br>
        <? if ($b!=8 and $b!=9) {?>
                    <input type="text" name="target" class="form-control" value="<?= $card['qiwi'] ?>"
                           placeholder="Номер / Идентификатор счёта" required><br>
            <?}else{?>
        <input type="text" name="target" class="form-control" value="<?= $card['payeer'] ?>"
               placeholder="Номер / Идентификатор счёта" required><br>
                    <?}?>

                    <input type="text" name="advBv" class="form-control" value="<?= $_COOKIE['advUrl'] ?>"
                           placeholder="Введите ссылку на обьявление с http://bartervito.holding.bz" required><br>
                    <!--<input type="text" name="advBv" class="form-control" value="--><?//$_COOKIE['advBv']
                    ?><!--" placeholder="Введите ссылку на обьявление с http://bartervito.holding.bz" required><br>-->

                    <div id="floatingBarsG">
                        <div class="blockG" id="rotateG_01"></div>
                        <div class="blockG" id="rotateG_02"></div>
                        <div class="blockG" id="rotateG_03"></div>
                        <div class="blockG" id="rotateG_04"></div>
                        <div class="blockG" id="rotateG_05"></div>
                        <div class="blockG" id="rotateG_06"></div>
                        <div class="blockG" id="rotateG_07"></div>
                        <div class="blockG" id="rotateG_08"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 col-xs-8">
                            <input type="number" name="sum" min='1' max='<?= $card['lim_one'] ?>' class="form-control"
                                   value="1">
                            <span id="alrt">
		</span>
                        </div>
                        <div class="col-sm-2 col-xs-4" style="     text-align: left;   line-height: 34px;">БР</div>
                    </div>
                    <br>
                    <input type="hidden" name="b" value="<?= $b ?>">
                    <button type="submit" id="submit123" class="btn btn-success btn-lg">Вывести BCR</button>
                </form>

                <script>
                    $('select[name=system]').on('change', function () {
                        $('#alrt').text('');
                        $('input[name=sum]>span').text('');
                        $('.input2').text('');
                        $('input[name=target]').attr('value', '');
                        $('input[name=sum]').val(<?=$sum?>);
                        $('.input3').text(<?=$sum?>+' БР');
                        $('input[name=sum]').attr('min', '1');
                        if ($(this).find('option:selected').attr('value') == 'qiwi') {
//        $('input[name=target]').mask('');
                            $('input[name=target]').attr('value', <?=$card['qiwi']?>);
                            $('.input2').text(<?=$card['qiwi']?>);
                        } else if ($(this).find('option:selected').attr('value') == 'ya') {
//        $('input[name=target]').mask('');
                            $('input[name=target]').attr('value', <?=$card['yandex']?>);
                            $('.input2').text(<?=$card['yandex']?>);
                        } else if ($(this).find('option:selected').attr('value') == 'visa_mastercard') {
//		$.mask.definitions['~']='[+-]';
//        $('input[name=target]').mask('9999 9999 9999 9999');
                            $('input[name=target]').attr('value', <?=$card['visa_mastercard']?>);
                            $('.input2').text(<?=$card['visa_mastercard']?>);
                            check_vs_mc();
                        } else if ($(this).find('option:selected').attr('value') == 'webmoney') {
                            $('input[name=target]').attr('value', <?=$card['webmoney']?>);
                            $('.input2').text(<?=$card['webmoney']?>);
                            wbm_min = 10;
                            if (<?=$sum?> >
                            10
                        )

                            wbm_min = <?=$sum?>;
                            $('input[name=sum]').attr('min', '10');
                            $('input[name=sum]').val(wbm_min);
                            $('#alrt').html('<span class="label label-info">от 10 BCR</span>');
                            $('.input3').text('10' + ' БР');
                        }
                        else if ($(this).find('option:selected').attr('value') == 'payeer') {
                            $('input[name=target]').attr('value', <?=$card['payeer']?>);
                            $('.input2').text(<?=$card['payeer']?>);
                            check_vs_mc();
                        }
                        $('.input1').text($(':selected', this).text());
                        $('input[name=target]').change();
                    });
                    $('input[name=target]').on('change keyup click', function () {
                        $('.input2').text($(this).val());
                    });
                    $('input[name=target]').on("keyup", check_vs_mc);
                    $('input[name=sum]').on('change keyup click', function () {
                        $('.input3').text($(this).val() + ' БР');
                    });
                    $(document).ready(function () {
                        $('.input1').text($('select[name=system] :selected').text());
                        $('.input2').text($('input[name=target]').val());
                        $('.input3').text($('input[name=sum]').val() + ' БР');

                    });

                    function check_vs_mc() {
                        if ($('select[name=system]').find('option:selected').attr('value') == 'visa_mastercard') {
                            var val_card = $('input[name=target]').val().replace(/\s/g, '');
                            if (val_card.length == 16) {
                                $('#floatingBarsG').css('display', 'block');
                                $('input[name=target]').attr('disabled', 'disabled');
                                $.get(`../ajax/check_vs_mc.php?card=${val_card}`, function (data) {
                                    var card = jQuery.parseJSON(data);
                                    if (card['err'] == 1) {
                                        $('input[name=sum]').attr('min', card['min']);
                                        $('input[name=sum]').val(card['min']);
                                        $('#alrt').html('<span class="label label-info">' + card['card'] + ' от ' + card['min'] + ' BCR</span>');
                                        $('.input3').text(card['min'] + ' БР');
                                    } else if (card['err'] == 2) {
                                        $('input[name=sum]').attr('min', '2000');
                                        $('input[name=sum]').val('2000');
                                        $('#alrt').html('<span class="label label-danger">' + card['err_card'] + '</span>');
                                        $('.input3').text('2000' + ' БР');
                                    } else {
                                        $('input[name=sum]').attr('min', '2000');
                                        $('input[name=sum]').val('2000');
                                        $('#alrt').html('<span class="label label-danger">Ошибка определения карты</span>');
                                        $('.input3').text('2000' + ' БР');
                                    }
                                    $('#floatingBarsG').css('display', 'none');
                                    $('input[name=target]').removeAttr('disabled');
                                });
                            }
                        }
                    }

                </script>

            </div>

            <div class="col-md-6 col-xs-12">
                <div class="bank" style="background:url('../img/bank<?= $b ?>.png');">
                    <div class="screen">
                        <div class="content">

                            <b>Снятие наличных</b>
                            <div class="input input1"></div>
                            <b>Номер счёта</b>
                            <div class="input input2"></div>
                            <b>Сумма</b>
                            <div class="input input3"><?= $sum ?> БР</div>

                        </div>
                    </div>

                    <div class="check">
                        <div style="text-align:center;">Выдача наличных</div>
                    </div>

                    <div class="money"></div>

                    <div class="balance">В банкомате <span><?= $balance ?></span> Р</div>

                    <div class="yourlim">Ваш лимит <span></span> БР
                        <script>setInterval(function () {
                                $('.yourlim span').load('/ajax/yourlim.php');
                            }, 5000);
                            $('.yourlim span').load('/ajax/yourlim.php');</script>
                    </div>

                    <div class="referals"
                         style="position: absolute;line-height: 17px;left: 52px;top: 348px; width: 191px; font-size: 15px; text-align: center;">
                        <span></span><a href="/referals" class="btn btn-info btn-sm">Порекомендовать систему<br>(оплачивается)</a>
                    </div>


                </div>

                <script src="js/bank.js"></script>
                <?/*
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
</style>
<div class="card from"><div class="row">
<div class="col-xs-offset-1 col-xs-10 logo" style="height:120px;"></div>

<div class="col-xs-offset-1 col-xs-10" style="margin-bottom:10px;"><input type="text" class="form-control cardnum" readonly style="background: none;color: white;border: 0;    font-size: 25px;" placeholder="Номер карты" name="fromnum"<?if($card)echo(' value="'.substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4).'"');?> required=""></div>
<div class="col-xs-offset-1 col-xs-10 form-inline"><input type="num" name="frommonth"<?if($card)echo(' value="'.$card['expiremonth'].'"');?> class="form-control" readonly style="width:90px;display: inline;background: none;color: white;border: 0;    font-size: 25px;" placeholder="Месяц" required=""> / <input type="num" name="fromyear"<?if($card)echo(' value="'.$card['expireyear'].'"');?> class="form-control" readonly style="width:90px;display: inline;background: none;color: white;border: 0;    font-size: 25px;" placeholder="Год" required=""> <div style="float:right;">СVC: <input type="num" name="fromcvc"<?if($card)echo(' value="'.$card['cvc'].'"');?> class="form-control" readonly style="width:90px;display: inline;background: none;color: white;border: 0;    font-size: 25px;" placeholder="cvc" required=""></div></div>
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
</script>*/
                ?>

            </div>
        </div>
        <?
    } else {
        ?>
        <div class="alert alert-danger">
            <? foreach ($err as $error) {
                if ($flag) {
                    echo(', ');
                }
                $flag = 1;
                echo($error);
            } ?>
        </div>
    <?
    }
}
?>

