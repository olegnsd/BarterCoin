<?
//7й ba1a1c68b7aac8dcb36c3ef50fbb9ebf Токен активен до 13.05.2019

if (!$card) {
    include('loginform.php');
} else {
    $info_with = mysqli_fetch_array(mysqli_query($mysqli, "SELECT sum(`sum`) FROM `transactions` WHERE `iswithdraw`=1"));
    $info_with = $info_with['sum(`sum`)'];
    ?>
    <div class="row">
        <div class="col-md-12 col-xs-12">

            <div class="pageTitle">
                <h2 class="center-block">Вывод БР. Выберите банкомат (Всего выведено: <?= $info_with ?> руб)</h2>
                <div class="referals">
                    <a href="/referals" class="btn btn-info btn-sm center-block">Порекомендовать систему<br>(оплачивается)</a>
                </div>
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
        });return false;"
                  id="ajaxform" class="tobank">


            </form>
            <script>

            </script>

        </div>
        <?
        //может ли использовать текущий банкомат
        $bankomats = json_decode($card['bankomats'], true);
        $bankomats = $bankomats['allow'];

        $info = mysqli_query($mysqli, "SELECT amount, token FROM settings WHERE title='bankomat'");
        foreach ($info as $i => $bank)
        {
            $token_proxy = json_decode($bank["token"], true);
            $title_b = ($token_proxy["title"]);
            $b = ($bank["amount"]);
            $balance = get_bank($mysqli, $b);//file_get_contents('/home/bartercoin/tmp/bankbalance'.$b);
            //`echo " b: "  $b >>/home/bartercoin/tmp/qaz`;
            //`echo " balance: "  $balance >>/home/bartercoin/tmp/qaz`;
            $class_hid = '1';
            $title = 'Доступен';
            $none = '';
            $b_a = $b;
            if (!in_array($b, $bankomats)) {
                $class_hid = '0.4';
                $title = 'Недоступен';
                $none = 'none';
                $b_a = '';
            }
            ?>

            <div class="col-md-4 col-xs-12">
                <a href="/withdraw?b=<?= $b_a ?>" class="bankomats" title="<?= $title ?>"
                   style="pointer-events: <?= $none ?>; ">
                    <div class="bank" style="background:url('../img/bank<?= $b ?>.png'); opacity: <?= $class_hid ?>;">
                        <div class="screen">
                            <div class="content">
                                <b>Снятие наличных</b>
                                <div class="input input1"></div>
                                <b>Номер счёта</b>
                                <div class="input input2"></div>
                                <b>Сумма</b>
                                <div class="input input3"></div>
                            </div>
                        </div>
                        <div class="check">
                            <div style="text-align:center;">Выдача наличных</div>
                        </div>
                        <div class="money">
                        </div>
                        <div class="balance balance<?= $b ?>">В банкомате <span><?= $balance ?></span> Р
                        </div>
                        <div class="yourlim">Ваш лимит <span></span> БР
                            <script>setInterval(function () {
                                    $('.yourlim span').load('/ajax/yourlim.php');
                                }, 5000);
                                $('.yourlim span').load('/ajax/yourlim.php');</script>
                        </div>
                        <div class="referals7"><span></span><?= $title_b ?></div>
                    </div>
                </a>
            </div>
        <? } ?>

        <script src="js/bank.js"></script>
        <script>
            //    $(document).ready(function(){
            //    var my_text = parseInt($('.balance span').text(), 10);
            //    alert(my_text);
            //    $('input[name=sum]').val(my_text);
            //    });
        </script>

        <? ?>


    </div>
<? } ?>

