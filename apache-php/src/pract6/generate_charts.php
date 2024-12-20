<?php
require_once "/var/www/vendor/autoload.php";
require_once "./helper.php";

use CpChart\Data;
use CpChart\Image;
use CpChart\Chart\Pie;

function get_columns($mysql) {
    $q = "SELECT DISTINCT m.title, SUM(p.count) OVER(PARTITION BY m.ID) as sum FROM purchasing as p JOIN material as m on p.matID = m.ID;";
	
	$rows = $mysql->query($q);

    $title = [];
    $sum = [];

    while ($row = $rows->fetch_assoc()) {
        $title[] = $row['title'];
        $sum[] = $row['sum'];
    }

    return [$title, $sum];
}

function getData($mysql) {
    list($title, $sum) = get_columns($mysql);

    $data = new Data();
    $data->AddPoints($sum, "Probe");
    $data->setSerieWeight("Probe", 2);
    $data->setPalette("Probe", array("R" => 0, "B" => 255, "G" => 128));
    $data->setAxisName(0, "Кол-во закупленных");

    $data->AddPoints($title, "Labels");
    $data->setSerieDescription("Labels", "Наименование материалов");
    $data->setAbscissa("Labels");
    $data->setAbscissaName("Наименование материалов");

    return $data;
}

function setSettings($image) {
    $scaleSettings = array(
        "LabelRotation"=> 20,
        "Floating"=>TRUE,
        "GridR"=>200,
        "GridG"=>200,
        "GridB"=>200,
        "DrawSubTicks"=>TRUE,
        "CycleBackground"=>TRUE  );
    $image->drawScale($scaleSettings);
}


function getImage($x, $y, $data) {
    $image = new Image($x, $y, $data);
    $image->drawRectangle(0, 0, $x - 1, $y - 1);
    $image->setGraphArea(100, 40, $x - 50, $y - 60);
    $image->setFontProperties([
        "FontName" => "/var/www/html/fonts/tahoma.ttf", 
        "FontSize" => 10
    ]);

    return $image;
}

function generateLineChart($x, $y, $data, $file_path) {
    $img = getImage($x, $y, $data);
	setSettings($img);
    $img->Antialias = FALSE;
    
    $img->drawLineChart();
    $img->Antialias = True;
    
    $img->drawPlotChart([
        "ForceColor" => True,
        "ForceR" => 255,
        "ForceB" => 255,
        "ForceG" => 0
    ]);

    $img->Render($file_path);
}

function generateBarChart($x, $y, $data, $file_path) {
    $img = getImage($x, $y, $data);
	setSettings($img);
    $img->drawBarChart();

    $img->Render($file_path);
}

function generatePieChart($x, $y, $r, $data, $file_path) {
    $img = getImage($x, $y, $data);

    $pie = new Pie($img, $data);
    $pie->draw2DPie($x / 2, $y / 2, [
        'Radius' => $r,
        'DrawLabels' => true,
        "Border" => true,
        "BorderR" => 255,
        "BorderG" => 255,
        "BorderB" => 255
    ]);

    $pie->pChartObject->Render($file_path);
}

function addWatermark($path, $text) {
    $image = imagecreatefrompng($path);
	$fontSize = 20;
	$fontPath = "/var/www/html/fonts/tahoma.ttf";
	$textColor = imagecolorallocate($image,0,0,0);
// Координаты для текста
	$x = 50;
	$y = 100;

	// Добавляем текст на изображение
	imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontPath, $text);

	imagepng($image, $path);
	imagedestroy($image);
}

function generate_only_charts($data, $paths) {
    $x = 800;
    $y = 450;
    generateLineChart($x, $y, $data, $paths[0]);
    generateBarChart($x, $y, $data, $paths[1]);

    $r = min($x / 2, $y / 2) - 40;
    generatePieChart($x, $y, $r, $data, $paths[2]);
}

function generate_charts($text, $dir, $names) {
	$mysql = openMysqli();

    $data = getData($mysql);
	$paths = [];
	foreach ($names as $name) {
		$paths[] = $dir . $name;
	}
		
	generate_only_charts($data, $paths);
	foreach ($paths as $path) {
		addWatermark($path, $text);
	}

	$values = "";
	foreach ($names as $name) {
		$values .= "('" . $name . "'),";
	}
	
	$q = "INSERT INTO charts (path) VALUES " . substr($values, 0, -1);

	$mysql->query($q);
}


?>