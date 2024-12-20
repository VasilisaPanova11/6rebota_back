<?php require_once "./session-helper.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Настройки</title>
</head>
<body>
<button onclick="window.location.replace('/index.html')">На главную</button>

    <h1>Настройки пользователя <?php echo $username; ?></h1>

    <form method="POST">
        <fieldset>
            <legend>Выберите тему:</legend>
            <label for="theme">Тема:</label>
            <select id="theme" name="theme">
                <option value="light" <?php echo $theme == "light" ? "selected" : "" ?> >Светлая тема</option>
                <option value="dark" <?php echo $theme == "dark" ? "selected" : "" ?>>Темная тема</option>
            </select>
        </fieldset>

        <fieldset>
            <legend>Выберите язык:</legend>
            <label for="language">Язык:</label>
            <select id="language" name="language">
                <option value="ru" <?php echo $lang == "ru" ? "selected" : "" ?>>Русский</option>
                <option value="en" <?php echo $lang == "en" ? "selected" : "" ?>>Английский</option>
            </select>
        </fieldset>

        <button type="submit" name='apply'>Применить</button>
    </form>

	<?php

	if (isset($_POST["apply"])) {
		$redis->hset($username, "theme", $_POST['theme']);
		$redis->hset($username, "lang", $_POST['language']);
	}

	?>

</body>
</html>