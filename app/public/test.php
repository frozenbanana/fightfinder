<?php
ini_set('memory_limit', '512M');

$file_path = "cities_selected.json";
$file = fopen($file_path, "r");
$cities = json_decode(fread($file, filesize("cities_selected.json")));


$sql = "INSERT INTO `cities` (`name`, `ascii_name`, `country_name_english`, `alternate_names`) VALUES (?,?,?,?)";
foreach ($cities as $city) {
    // print selected fields
    // implode $city->alternate_names if exsists
    $alternate_names = $city->alternate_names? implode(",", $city->alternate_names) : "";

    echo $city->name . $city->ascii_name . $city->cou_name_en . $alternate_names . PHP_EOL;
}