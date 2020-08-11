<?php
	// скрипт генерирует на основе шаблонов и параметров изображение банковской карты
	// пример использования:
	// scr.php?number=1234 5678 9012 3456&expired=02/20&code=123&holder=ALEXANDR NIKOLAENKOV
	
	$number=htmlspecialchars(trim($_REQUEST['number']));
	$expired=htmlspecialchars(trim($_REQUEST['expired']));
	$code=htmlspecialchars(trim($_REQUEST['code']));
	$holder=htmlspecialchars(trim($_REQUEST['holder']));


	//$number='1234 5678 0123 4567';
	//$expired='08/22';
	//$code='123';
	//$holder='ALEXANDR MEDVEDEV';
	

	if (!$number || !$expired || !$code || !$holder) die;

	$w=642;
	$h=833;
	$im= imagecreatetruecolor($w,$h) or die ("Cannot Initialize new GD image stream");
	$im1 = imagecreatefrompng('templates/1.png');
	$im2 = imagecreatefrompng('templates/2.png');

	imagecopy($im, $im1, 0, 0, 0, 0, imagesx($im1), imagesy($im1));
	imagecopy($im, $im2, 0, 423, 0, 0, imagesx($im2), imagesy($im2));

	// номер
	$number_color_hex='#000000';
	$number_fontsize= 26;
	$number_color=imagecolorallocate($im, hexdec(substr($number_color_hex,1,2)), hexdec(substr($number_color_hex,3,2)), hexdec(substr($number_color_hex,5,2)));
	$number_dx=60;
	$number_dy=200;
	// обводка черным цветом - начало
	$number_color=imagecolorallocate($im, hexdec(substr($number_color_hex,1,2)), hexdec(substr($number_color_hex,3,2)), hexdec(substr($number_color_hex,5,2)));
	imagettftext($im, $number_fontsize, 0, $number_dx-1, $number_dy, $number_color, 'fonts/OCR A Std Regular.ttf', $number);
	imagettftext($im, $number_fontsize, 0, $number_dx+1, $number_dy, $number_color, 'fonts/OCR A Std Regular.ttf', $number);
	imagettftext($im, $number_fontsize, 0, $number_dx, $number_dy-1, $number_color, 'fonts/OCR A Std Regular.ttf', $number);
	imagettftext($im, $number_fontsize, 0, $number_dx, $number_dy+1, $number_color, 'fonts/OCR A Std Regular.ttf', $number);
	// обводка черным цветом - конец
	$number_color_hex='#FFFFFF';
	$number_color=imagecolorallocate($im, hexdec(substr($number_color_hex,1,2)), hexdec(substr($number_color_hex,3,2)), hexdec(substr($number_color_hex,5,2)));
	imagettftext($im, $number_fontsize, 0, $number_dx, $number_dy, $number_color, 'fonts/OCR A Std Regular.ttf', $number);

	// держатель
	$holder_color_hex='#FFFFFF';
	$holder_fontsize= 18;
	$holder_color=imagecolorallocate($im, hexdec(substr($holder_color_hex,1,2)), hexdec(substr($holder_color_hex,3,2)), hexdec(substr($holder_color_hex,5,2)));
	$holder_dx=60;
	$holder_dy=360;
	imagettftext($im, $holder_fontsize, 0, $holder_dx, $holder_dy, $holder_color, 'fonts/HALTER__.ttf', $holder);

	// срок
	$expired_color_hex='#FFFFFF';
	$expired_fontsize= 14;
	$expired_color=imagecolorallocate($im, hexdec(substr($expired_color_hex,1,2)), hexdec(substr($expired_color_hex,3,2)), hexdec(substr($expired_color_hex,5,2)));
	$expired_dx=490;
	$expired_dy=305;
	imagettftext($im, $expired_fontsize, 0, $expired_dx, $expired_dy, $expired_color, 'fonts/HALTER__.ttf', $expired);

	// код
	$code_color_hex='#333333';
	$code_fontsize= 14;
	$code_color=imagecolorallocate($im, hexdec(substr($code_color_hex,1,2)), hexdec(substr($code_color_hex,3,2)), hexdec(substr($code_color_hex,5,2)));
	$code_dx=450;
	$code_dy=575;
	imagettftext($im, $code_fontsize, 0, $code_dx, $code_dy, $code_color, 'fonts/HALTER__.ttf', $code);


	// Вывод и освобождение памяти
	header('Content-type: image/png');
	imagepng($im);
	imagedestroy($im);
?>
