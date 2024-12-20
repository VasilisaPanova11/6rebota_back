<?php 
require_once "./helper.php"; 

$watermark = "ИКБО-03-22. Панова Василиса Александровна";

?>
<!DOCTYPE html>
<html lang="ru">
<head>
        <title>Page Graphics</title>
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
<button onclick="window.location.replace('/fixtures.php')">Фикстуры</button>
    <h1>Графики</h1>

    <?php 
		$mysql = openMysqli();
        $q = "SELECT * FROM charts";
        $rows = $mysql->query($q);
        if ($rows->num_rows == 0) {
            require_once "./pract6/generate_charts.php";
            $dir = "/var/www/html";
            $folder = "/charts/";
            $names = [
                $folder . "line.png", 
                $folder . "bar.png", 
                $folder . "pie.png"];
            generate_charts($watermark, $dir, $names);
            $rows = $mysql->query($q);
        }
    ?>
    <table>
        <tr>
            <th>График</th>
        </tr>
        <?php
            while ($row = $rows->fetch_assoc()) {
                echo "<tr>";
                echo "<td><img src='{$row['path']}'></td>";
                echo "</tr>";
            }
        ?>
    </table>
</body>
</html>