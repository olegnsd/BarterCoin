<form action="/delete_save" method="post" id="savecard">
    <div class="closeBtn" onclick="$('.clientLogin > form').toggleClass('clicked');">
        <i class="fa fa-close"></i>
    </div>
    <div class="h5">Ваша карта сохранена</div>
    <input type="text" readonly class="form-control cardnum" placeholder="Номер карты" value="<?=substr($card['number'],0,4).' '.substr($card['number'],4,4).' '.substr($card['number'],8,4).' '.substr($card['number'],12,4);?>">
    <br>
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
</form>
