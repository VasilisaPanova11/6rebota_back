<?php
session_start();

$redis = new Redis();
$redis->connect('redis', 6379);
$cookie_time = 60;
if (isset($_SERVER["PHP_AUTH_USER"])) {
    $username = $_SERVER["PHP_AUTH_USER"];
    $theme = $redis->hget($username, "theme");
    $theme = empty($theme) ? 'light' : $theme;
    $lang = $redis->hget($username, "lang");
    $lang = empty($lang) ? 'ru' : $lang;

    $_SESSION['username'] = $username; 
    $_SESSION["theme"] = $theme;
    $_SESSION["lang"] = $lang;
    // Установка и проверка значений куки
    if (!isset($_COOKIE['username2'])) {
        setcookie('username2', $username, time() + $cookie_time, "/");
        $_COOKIE['username2'] = $username;
    }
    if (!isset($_COOKIE['theme2'])) {
        setcookie('theme2', $theme, time() + $cookie_time, "/"); 
        $_COOKIE['theme2'] = $theme;
    }
    if (!isset($_COOKIE['lang2'])) {
        setcookie('lang2', $lang, time() + $cookie_time, "/"); 
        $_COOKIE['lang2'] = $lang;
    }
}

$username = $_SESSION['username'];
$theme = $_SESSION['theme'];
$lang = $_SESSION['lang'];
?>
