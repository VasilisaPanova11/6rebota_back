<?php
require_once "./session-helper.php";

echo "<h1>Добро пожаловать в строительный магазин!</h1>";


$username = $_SESSION['username'];
$theme = $_SESSION['theme'];
$lang = $_SESSION['lang'];

$content = "$username! Тема: $theme. Язык: $lang.";


$username2 = $_COOKIE['username2'] ?? '';
$theme2 = $_COOKIE['theme2'] ?? '';
$language2 = $_COOKIE['lang2'] ?? '';

$content2 = "куки: $username2! Тема: $theme2. Язык: $language2.";
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная страница</title>
</head>
<body>
    <button onclick="window.location.replace('/index.html')">На главную</button>
    <h1><?php echo htmlspecialchars($content); ?></h1>
    <h1><?php echo htmlspecialchars($content2); ?></h1>

    <h2>Список загруженных файлов</h2>
    <?php
        // Директория для загрузок
        $uploadDir = 'uploads/';
        if (is_dir($uploadDir)) {
            // Получаем список файлов из директории uploads
            $files = scandir($uploadDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    // Генерация ссылок для скачивания
                    $filePath = $uploadDir . $file;
                    echo '<a href="upload.php?file=' . urlencode($file) . '">' . htmlspecialchars($file) . '</a><br>';
                }
            }
        } else {
            echo "Директория загрузок не найдена.";
        }
    ?>
</body>
</html>