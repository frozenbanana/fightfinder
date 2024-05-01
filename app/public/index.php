<?php
require_once "_includes/database.php";

$config = require_once "config.php";
$database_config = $config["database"];
$user = $database_config["user"];
$passw = $database_config["passw"];

$db = new Database($database_config, $user, $passw);

require_once "_includes/functions.php";
require_once "router.php";
