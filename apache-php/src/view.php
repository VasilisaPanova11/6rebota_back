<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Информация о материале</title>
</head>
<body>
<?php require_once 'helper.php'; $id = $_GET["id"];
if (!isset($id) || !is_numeric($id)) throw new Exception();

$mysqli = openMysqli();
$stmt = $mysqli->prepare('SELECT * FROM material WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$material = $result->fetch_assoc();
echo "<h1>Описание материала</h1>";
echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Стоимость</th>
    </tr>
    <tr>
        <td>" . $material['ID'] . "</td>
        <td>" . $material['title'] . "</td>
        <td>" . $material['discription'] . "</td>
        <td>" . $material['cost'] . "</td>
    </tr>
</table>";
$mysqli->close();
?>
<button onclick="window.location.replace('/mat.php')">Назад</button>
<button onclick="window.location.replace('/index.html')">На главную</button>
</body>
</html>