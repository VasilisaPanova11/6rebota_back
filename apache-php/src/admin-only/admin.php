<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Стрaница админа</title>
    <style>span { margin: 10px; }</style>
</head>
<body>
<h1>Список пользователей</h1>
<?php
require_once '../helper.php';
$mysqli = openMysqli();
$stmt = $mysqli->prepare('SELECT * FROM users');
$stmt->execute();
$result = $stmt->get_result();
?>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Имя пользователя</th>
        <th>Хэш пароля</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ID']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['password']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<?php $mysqli->close(); ?>
<button onclick="window.location.replace('/index.html')">На главную</button>
</body>
</html>