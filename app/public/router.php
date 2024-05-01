<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$routes = [
    '/' => 'views/home.php',
    '/home' => 'views/home.php',
    '/login' => 'views/login.php',
    '/register' => 'views/register.php',
    '/logout' => 'logout.php',
    '/search' => 'controllers/search.php',
    '/sessions' => 'controllers/session.php',
    '/gyms' => 'controllers/add_gym.php',
];

$nav_links = [
    "" => "Home",
    "login" => "Login",
    "register" => "Register",
];

if (array_key_exists($uri, $routes)) {
    include $routes[$uri];
} else {
    include 'views/404.php';
}