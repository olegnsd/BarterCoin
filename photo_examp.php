<?php

if($_GET['photo']=='examp'){
    $path = "/home/bartercoin/tmp/passport/pass_examp/foto_examp.jpeg"; ///home/bartercoin/tmp/passport/
    $photo = imagecreatefromjpeg($path);
    $im2 = imagecreatefromjpeg('/home/bartercoin/tmp/passport/pass_examp/tetrad_list.jpeg');

	imagecopy($photo, $im2, imagesx($photo)-250, imagesy($photo)-100, 0, 0, 250, 100);
    
    $text_color = imagecolorallocate($photo, 0, 100, 255);
    imagettftext($photo, 60, 0, imagesx($photo)-210, imagesy($photo)-20, $text_color, '/home/bartercoin/tmp/passport/pass_examp/Propisi.TTF', (int)$_GET['fisl']);
}

header('Content-type: image/jpeg');
imagejpeg($photo); 
imagedestroy($photo);
