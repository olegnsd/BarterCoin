<?

$redirectUri = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

$_SESSION['showForm'] = true;

setcookie ( 'card1', '',time()+60*60*24*30, '/');
setcookie ( 'card2', '',time()+60*60*24*30, '/');
setcookie ( 'card3', '',time()+60*60*24*30, '/');
setcookie ( 'card4', '',time()+60*60*24*30, '/');

redirect($redirectUri);
