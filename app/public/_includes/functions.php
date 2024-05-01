<?php
// copyright funktion

function render_copyright()
{

    return "&copy; " . date("Y") . " Fight Finder";
}

function render_copyright_extended()
{
    return "&copy; " . date("Y") . ", " . date("M") . " Fight Finder";
}

// alternativ funktion för bättre läsbarhet av print_r
function print_r2($a)
{
    echo "<pre>";
    print_r($a);
    echo "</pre>";
}

// funktion för att skriva ut flashmeddelande
function display_flash_message()
{
    if (isset($_SESSION['flash_message'])) {
        echo $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
    }
}

function set_flash_message_and_redirect_to($message, $redirect_to)
{
    $_SESSION['flash_message'] = $message;
    header("Location: $redirect_to");
    exit;
}

// DONE: NR 1 funktion för att hämta en användare från databas givet användarnamn
// T.ex get_user_by_username($pdo, $username)
// ska användas i register.php och login.php
//$db = new Database($config["database"], $config["database"]["user"], $config["database"]["passw"]);

function get_user_by_username($username)
{
    global $db;
    $sql = "SELECT * FROM users WHERE username = ?";
    $statment = $db->query($sql, [$username]);

    // Hämta användaren från databasen
    return $db->fetchOne($statment);
}


// DONE: NR 2 funktion för att registrera en användare till databas givet användarnamn och lösenord
// T.ex register_user($pdo, $username, $password)
// ska användas i register.php
function register_user($username, $password)
{
    global $db;
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    $statement = $db->query($sql, [$username, $password]);

    // Kontrollera att användaren skapades med ett boolean return värde
    return $statement->rowCount() === 1;
}

function get_json_from_url($url) {
    // use file_get_contents to return json from url   
    // $json = file_get_contents($url);

    // return json_decode($json, true);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, 'https://fightfinder.henrybergstrom.com'); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

function get_coordinates_from_address($address) {
    $url_encoded_address = urlencode($address);
    $url = 'https://nominatim.openstreetmap.org/search?q='. $url_encoded_address. '&format=json&limit=1';
    print_r2($url);
    $json = get_json_from_url($url);
    print_r2($json);
    return ['lat' => $json[0]["lat"], 'lon' => $json[0]["lon"]];
}

function add_gym($name, $address, $description, $user_id) {
    global $db;
    // use curl to get lat and lon
    $coordinates = get_coordinates_from_address($address);
    $sql = "INSERT INTO gyms (name, address, lat, lon, description, user_id) VALUES (?, ?, ?, ?, ?, ?)"; 
    $db->query($sql, [$name, $address, $coordinates['lat'], $coordinates['lon'], $description, $user_id]);
}

function add_session($gym_id, $day, $time, $style_id, $user_id) {
    global $db;
    $sql = "INSERT INTO sessions (gym_id, day, time, style_id, user_id) VALUES (?, ?, ?, ?, ?)";
    $db->query($sql, [$gym_id, $day, $time, $style_id, $user_id]);
}

function get_gyms($search_term = "")
{
    global $db;
    $sql = "SELECT * FROM gyms where address LIKE ? or name LIKE ?";
    $statment = $db->query($sql, ["%$search_term%", "%$search_term%"]);

    return $db->fetchAll($statment);
}

function get_styles() {
    global $db;
    $sql = "SELECT * FROM styles";
    $statment = $db->query($sql);
    return $db->fetchAll($statment);
}

function get_gyms_with_users()
{
    global $db;
    // Join tabeller gyms och users med inner join
    $sql = "SELECT * FROM gyms INNER JOIN users ON gyms.user_id = users.id";
    $statment = $db->query($sql);

    return $db->fetchAll($statment);
}

function get_gym_by_id($id)
{
    global $db;
    $sql = "SELECT * FROM gyms WHERE id = ?";
    $statment = $db->query($sql, [$id]);

    return $db->fetchOne($statment);
}

function get_sessions_by_gym_id($gym_id) {
    global $db;
    $sql = "SELECT * FROM sessions INNER JOIN styles ON sessions.style_id = styles.id WHERE gym_id = ?";
    $statment = $db->query($sql, [$gym_id]);

    return $db->fetchAll($statment);
}

function guard_user_logged_in()
{
    if (!isset($_SESSION['user'])) {
        set_flash_message_and_redirect_to("Du måste vara inloggad för att kunna komma åt denna sida", "/login");
    }
}

function is_authenticated() {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    return true;
}

function guard_user_not_logged_in()
{
    if (isset($_SESSION['user'])) {
        set_flash_message_and_redirect_to("Du är redan inloggad", "/home");
    }
}

function render_logged_in_navbar()
{
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        return <<<EOD
    <li">
        <a href="/logout">Logga ut</a>
    </li>
    <li">
        <a href="/users/{$user['id']}">{$user['username']}</a>
    </li>
EOD;
    }
}

