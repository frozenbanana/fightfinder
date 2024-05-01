<?php

$gym_id = $_GET["gym_id"];

if ($gym_id) {
    $sessions = get_sessions_by_gym_id($gym_id);
    include "views/partials/schedule.php";
} else {
    include "views/404.php";
}