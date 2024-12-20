<?php
require_once "./session-helper.php";

// Удаляем все данные сессии
session_unset();
session_destroy();

// Перенаправляем на страницу входа
http_response_code(401);
echo "<script>window.location.replace('/')</script>";
exit;
?>