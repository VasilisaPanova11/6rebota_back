<?php require_once "./helper.php"; ?>

<!DOCTYPE html>
<html lang="ru">
<head>
        <title>Page Cities</title>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
            table {
                margin-left: auto;
                margin-right: auto;

                border: 2px solid grey;   
                
                width: 90%;
            }
            th {
                padding: 15px 30px;
                border: 1px solid grey;

                text-align: center;
                font-size: 150%;
            }


            td {
                padding: 10px;
                border: 1px solid grey;

                text-align: center;
                font-size: 130%;
            }
        </style>
</head>
<body>
<button onclick="window.location.replace('/index.html')">На главную</button>
<button onclick="window.location.replace('/charts.php')">Графики</button>
    <h1>Фикстуры</h1>

    <?php 
		$mysql = openMysqli();
        $q = "SELECT * FROM purchasing";
        $rows = $mysql->query($q);
        if ($rows->num_rows == 0) {
            require_once "./pract6/generate_fixtures.php";
            generate_data();
            $rows = $mysql->query($q);
        }
    ?>
    <table>
        <tr>
            <th>ID материала</th>
            <th>Кол-во</th>
            <th>Город</th>
            <th>Имя покупателя</th>
            <th>Фамилия покупателя</th>
            <th>Страна</th>
        </tr>
        <?php
            while ($row = $rows->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['matID']}</td>";
                echo "<td>{$row['count']}</td>";
                echo "<td>{$row['city']}</td>";
                echo "<td>{$row['name']}</td>";
                echo "<td>{$row['surname']}</td>";
                echo "<td>{$row['country']}</td>";
                echo "</tr>";
            }
        ?>
    </table>

</body>
</html>