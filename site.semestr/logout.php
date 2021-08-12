<?php
include "connect.php";
unset($_SESSION['user']);
unset($_SESSION['id']);
$url = $_SERVER['HTTP_REFERER'];
$url = str_replace('http://site.semestr','',$url);
header('Location: '.$url);