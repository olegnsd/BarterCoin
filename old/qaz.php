<?php                                                                                                                     
phpinfo();                  
$headers = 'From: webmaster@easywork24.holding.bz' . "\r\n" .
    'Reply-To: webmaster@easywork24.holding.bz' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();                                                                                              
mail('jondoll@yandex.ru', 'test', 'test');       

