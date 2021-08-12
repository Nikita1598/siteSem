<?php
include "page.php";
global $pdo;
$name = $_POST['user'];
$password = $_POST['password'];
$password = md5($password);
$email = $_POST['email'];
$url = str_replace('http://site.semestr/','',$url);
$url = $_SERVER['HTTP_REFERER'];
$query_user = "SELECT * FROM `web_prog`.`users` WHERE `users`.`login` = '" . $name . "'";
$query_email = "SELECT * FROM `web_prog`.`users` WHERE `users`.`email` = '" . $email . "'";
$query_user = $pdo->query($query_user);
$query_user = $query_user->fetch(PDO::FETCH_LAZY);
sleep(0.4);
$query_email = $pdo->query($query_email);
$query_email = $query_email->fetch(PDO::FETCH_LAZY);
if ($query_user['login'] === $name){
    echo "Такой логин уже занят <i class='far fa-sad-tear'></i>";
} else {
    if ($query_email['email'] === $email) {
        echo "Такой email уже занят <i class='far fa-sad-tear'></i>";
    } else{
        $reg = $pdo->exec("INSERT INTO users(`login`,`password`,`email`) VALUES ('".$name."','".$password."','".$email."')");
        $_SESSION['user'] = $name;
        echo $url;
    }
}