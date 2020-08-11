<?php
if(isset($_GET['number'])){
    $number = $_GET['number'];
    $cvc = $_GET['cvc'];
    $exp = $_GET['exp'];
    $name = $_GET['name'];
    $name = get_in_translate_to_en($name);
    $name = strtoupper($name);
}

//$data = array(
//    'number' => '1354 7856 0767 5635',
//    'exp' => '12/20',
//    'cvc' => '383', 
//    'name' => 'Кириенко Максим'
//);
//echo http_build_query($data) . "\n";

function get_in_translate_to_en($string, $gost=false)
    {
        if($gost)
        {
            $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                    "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                    "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
                    "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
                    "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
                    "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Iu","ю"=>"iu","Я"=>"Ia","я"=>"ia","ъ"=>"","ь"=>"");
        }
        else
        {
            $arStrES = array("ае","уе","ое","ые","ие","эе","яе","юе","ёе","ее","ье","ъе","ый","ий");
            $arStrOS = array("аё","уё","оё","ыё","иё","эё","яё","юё","ёё","её","ьё","ъё","ый","ий");        
            $arStrRS = array("а$","у$","о$","ы$","и$","э$","я$","ю$","ё$","е$","ь$","ъ$","@","@");

            $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                    "Е"=>"Ye","е"=>"e","Ё"=>"Ye","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                    "Й"=>"Y","й"=>"y","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n",
                    "О"=>"O","о"=>"o","П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t",
                    "У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f","Х"=>"Kh","х"=>"kh","Ц"=>"Ts","ц"=>"ts","Ч"=>"Ch","ч"=>"ch",
                    "Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch","Ъ"=>"","ъ"=>"","Ы"=>"Y","ы"=>"y","Ь"=>"","ь"=>"",
                    "Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","@"=>"y","$"=>"ye");

            $string = str_replace($arStrES, $arStrRS, $string);
            $string = str_replace($arStrOS, $arStrRS, $string);
        }

        return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
    }


?>

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="http://allfont.ru/allfont.css?fonts=kredit" rel="stylesheet" type="text/css" />
    
    <link href="../css/card.css" type="text/css" rel="stylesheet">
</head>

<body>
    
    
    
<!--div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="card">
            <h4>h4</h4>
            <div id='' class="category" style="background-image: url(../img/perednyaya_storona.gif);">
                <h5 class="">Custom heading</h5>
                <br>
            </div>
        </div>
    </div>

</div-->

<div class="content">
<div class="container">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="category" style="background-image: url('../img/perednaya_storona.jpg');">
            <!--img src="../img/perednaya_storona.jpg" class="img-responsive center-block category" alt="Responsive image"-->
            <h3 class="number"><?=$number?></h3>
            <h3 class="valid"><?=$exp?></h3>
            <h3 class="name"><?=$name?></h3>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="category" style="background-image: url('../img/zadnaya_storona.jpg');">
            <h5 class="activate"><a class="a_activate"href="https://bartercoin.holding.bz/activate">https://bartercoin.holding.bz/activate</a></h5>
            <h5 class="cvc">cvc: <i class="cvc_text"> <?=$cvc?> </i></h5>
            <h5 class="check"><a class="a_activate"href="https://bartercoin.holding.bz/check">https://bartercoin.holding.bz/check</a></h5>
            <h5 class="app"><a class="a_activate"href="https://bartercoin.holding.bz/app">https://bartercoin.holding.bz/app</a></h5>
            <h5 class="send"><a class="a_activate"href="https://bartercoin.holding.bz/send">https://bartercoin.holding.bz/send</a></h5>
        </div>
        <!--img src="../img/zadnaya_storona.jpg" class="img-responsive center-block category" alt="Responsive image"-->
        
    </div>
</div>
</div>
</div>

  

    
</body>