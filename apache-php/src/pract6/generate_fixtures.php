<?php

require_once "/var/www/vendor/autoload.php";
require_once "./helper.php";

function next_data($faker, $number) {
	return "(" .
    $faker->numberBetween(1, $number) . "," .
    $faker->numberBetween(1, 100) . "," .
    "'" . addslashes($faker->city) . "'," .
    "'" . addslashes($faker->firstName) . "'," .
    "'" . addslashes($faker->lastName) . "'," .
    "'" . addslashes($faker->country) . "')";
}

function generate_data() {
    $mysql = openMysqli();
    $count = $mysql->query("SELECT COUNT(*) as count FROM material");
    $count = (int)$count->fetch_row()[0];
    $faker = Faker\Factory::create("ru_RU");


    $num_records = 50;
    $fixtures = "";
    for ($i = 0; $i < $num_records - 1; ++$i) {
        $fixtures .= next_data($faker, $count) . ",";
    }

    $fixtures .= next_data($faker, $count);

    $q = "INSERT INTO purchasing (matID, count, city, name, surname, country) VALUES " . $fixtures;
    $mysql->query($q);
}
