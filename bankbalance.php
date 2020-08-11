<?php
require('inc/init.php');

$num = (int)$_GET['b'];

echo(get_bank($mysqli, $num));