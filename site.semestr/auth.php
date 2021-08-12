<?php
include "page.php";
global $pdo;
$name = $_POST['user'];
$password = $_POST['password'];
$password = md5($password);
$url = $_SERVER['HTTP_REFERER'];
$url = str_replace('http://site.semestr/','',$url);
try {
    $query_user = "SELECT * FROM `web_prog`.`users` WHERE `users`.`login` = '" . $name . "' AND `users`.`password` = '" . $password . "'";
    $query_user = $pdo->query($query_user);
    $query_user = $query_user->fetch(PDO::FETCH_LAZY);
}catch (PDOException $e){
    echo 'Случилась беда, простите <i class="far fa-sad-tear"></i>';
}
sleep(0.4);
if ($query_user['login'] != $name && $query_user['password'] != $password) {
    echo "Неверный логин или пароль <i class='far fa-sad-tear'></i>";
}else{
    if (sizeof($query_user['login'])>0) {
        $_SESSION['user'] = $query_user['login'];
        $_SESSION['id'] = $query_user['id'];
        echo $url;
    }
    else{
        echo 'Случилась беда, простите <i class="far fa-sad-tear"></i>';
    }
}
?>