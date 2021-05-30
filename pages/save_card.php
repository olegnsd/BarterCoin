<?

$redirectUri = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	redirect($redirectUri);
}

$_SESSION['showForm'] = true;

if (empty($_POST['savenum']) || empty($_POST['savemonth']) || empty($_POST['saveyear']) || empty($_POST['savecvc'])) {
	redirect($redirectUri);
}

$card = getcard($_POST['savenum'], $_POST['savemonth'], $_POST['saveyear'], $_POST['savecvc']);

if (!$card || $card['black'] == 1) {
	$_SESSION['cardError'] = true;
} else {
    setcookie ( 'card1', $_POST['savenum'],time()+60*60*24*30, '/');
    setcookie ( 'card2', $_POST['savemonth'],time()+60*60*24*30, '/');
    setcookie ( 'card3', $_POST['saveyear'],time()+60*60*24*30, '/');
    setcookie ( 'card4', $_POST['savecvc'],time()+60*60*24*30, '/');
}

redirect($redirectUri);
