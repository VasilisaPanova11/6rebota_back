<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Список материалов</title>
    <style>
        span {
            margin: 10px;
        }
        .list {
            display: flex;
            flex-direction: column;
        }
        .item {
            display: flex;
            flex-direction: row;
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }

        .item:hover { background-color: cadetblue; color: blueviolet }
        </style>

</head>
<body>
<h1>Список материалов</h1>
<?php
require_once 'helper.php';
$mysqli = openMysqli();
$stmt = $mysqli->prepare('SELECT * FROM material');
$stmt->execute();
$result = $stmt->get_result();
?>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Стоимость, за шт/m&sup3</th>
        <th>Ссылка</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ID']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['cost']); ?></td>
            <td><?php echo "<a href='view.php?id=" . $row['ID'] . "'>ссылка</a>"; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<button onclick="window.location.replace('/index.html')">На главную</button>
</body>
</html>