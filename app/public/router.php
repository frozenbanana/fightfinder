<?php

// $test = get_address_from_search("bfl bangkok");
// print_r2($test);


$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'views/home.php',
    '/home' => 'views/home.php',
    '/login' => 'controllers/login.php',
    '/register' => 'controllers/register.php',
    '/logout' => 'logout.php',
    '/search' => 'controllers/search.php',
    '/sessions' => 'controllers/session.php',
    '/gyms/add' => 'controllers/add_gym.php',
    '/gyms/edit' => 'controllers/edit_gym.php',
];

$nav_links = [
    "/" =>  ["name" => "Home", "hide_if_auth" => false],
    "/login" => ["name" => "Login", "hide_if_auth" => true],
    "/register" => ["name" => "Register", "hide_if_auth" => true],
    "/gyms/add" => [ "name" => "Add Gym", "hide_if_auth" => true],
    "/users" => [ "name" => "Manage Gyms", "hide_if_auth" => false],
];

if (array_key_exists($uri, $routes)) {
    include $routes[$uri];
} else {
    include 'views/404.php';
}
