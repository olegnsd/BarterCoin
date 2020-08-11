</div>
    <!-- ======= 1.09 footer Area ====== -->
    <footer class="secPdngT animated">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="footerInfo">
                        <a href="<?=$baseHref;?>" class="footerLogo">
                            <img src="img/logo.png" alt="">
                        </a>
                        <!--div class="footerTxt">
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh eui smod tincidunt ut laoreet dolore magna.</p>
                        </div>
                        <ul class="footerLinkIcon">
                            <li><a href="index.html#"><i class="icofont icofont-social-facebook"></i></a></li>
                            <li><a href="index.html#"><i class="icofont icofont-social-twitter"></i></a></li>
                            <li><a href="index.html#"><i class="icofont icofont-social-google-plus"></i></a></li>
                            <li><a href="index.html#"><i class="icofont icofont-social-tumblr"></i></a></li>
                            <li><a href="index.html#"><i class="icofont icofont-social-yelp"></i></a></li>
                        </ul-->
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="widget">
                        <!--div class="h4">Important Links</div-->
                        <ul class="footerLink">
                           <li<?if($_GET['page']=='index'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>">Главная</a></li>
<li<?if($_GET['page']=='faq'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>faq">FAQ</a></li>


                            <!--ul id="nav2"-->

<li<?if($_GET['page']=='activate'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>activate">Активация карты</a></li>
<li<?if($_GET['page']=='check'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>check">Проверка баланса</a></li>
<li<?if($_GET['page']=='send'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>send">Перевод БР с карты на карту</a></li>
<li<?if($_GET['page']=='deposit'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>deposit">Пополнить баланс карты</a></li>
<li<?if($_GET['page']=='withdraw7'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>withdraw7">Вывод БР</a></li>
<li<?if($_GET['page']=='api'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>api">Приём платежей с сайта</a></li>
<li style="width: 49%;display: inline-block;"><a href="http://bartervito.holding.bz">Потратить БР</a></li>
<li<?if($_GET['page']=='create'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>create">Получить карту (регистарция)</a></li>
<li<?if($_GET['page']=='loan'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>loan" class='alert-xs alert-success'>Взять займ</a></li>
<li<?if($_GET['page']=='restore'){?> class="current-menu-item"<?}?> style="width: 49%;display: inline-block;"><a href="<?=$baseHref;?>restore">Восстановить карту</a></li>
                        </ul>                        
                    </div>
                </div>
               
                <div class="col-sm-4">
                    <div class="contactInfo"><a href="javascript:void(0);" style="display:block;" onclick="$('.modal3').show(0);" class="contactBtn Btn">Заказать карту</a><hr>
                        <p>&copy; <?=date('Y');?> <a href="http://www.holding.bz">ПАО "Милитари Холдинг"</a></p><a href="//www.free-kassa.ru/"><img src="//www.free-kassa.ru/img/fk_btn/18.png"></a>


                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="copyrightTxt">
                       
                    </div>
                </div>
            </div>
        </div>
    </footer>


<div class="modal modal3" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.modal3').hide(1000);"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Заказать карту почтой за 900 руб.</h4>
      </div>
      <div class="modal-body"><p>После активации баланс карты будет составлять 100 БР</p>
        <form id="form" role="form" class="text-left ajaxform" onsubmit="var msg   = $('#form').serialize();
        $.ajax({
          type: 'POST',
          url: 'form.php',
          data: msg,
          success: function(data) {
            $('.ajaxform').html(data);
          },
          error:  function(xhr, str){
	    alert('Возникла ошибка: ' + xhr.responseCode);
          }
        });return false;"> <div class="form-group">
                                            <label for="inputText1">Имя*</label>
                                            <input type="text" class="form-control" name="name" id="inputText1" placeholder="" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail1">Номер телефона*</label>
                                            <input type="text" class="form-control" name="phone" id="inputEmail1" placeholder="" required>
                                        </div>
<div class="form-group">
                                            <label for="inputEmail1">E-mail</label>
                                            <input type="text" class="form-control" name="email" id="inputEmail1" placeholder="">
                                        </div>
                                       
                                        
                                        <button type="submit" class="btn btn-lg btn-dark  btn-success">Отправить</button>
                                    </form>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


    <!-- ======= /1.09 footer Area ====== -->


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

       <?/* <script src="js/owl.carousel.min.js"></script> <!-- owlCarousel -->
        <script src="js/waypoints.min.js"></script> <!-- waypoint -->
        <script src="js/active.js"></script> <!-- active js -->
        <script src="js/chatScript.js" type="text/javascript"></script> <!--End of Tawk.to Script-->*/?>



    </body>
</html>
