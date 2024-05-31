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

// function to start session IF not already started
function try_session_start() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// funktion för att skriva ut flashmeddelande
function display_flash_message()
{
    try_session_start();
    if (isset($_SESSION['flash_message'])) {
        $ret = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $ret;
    }

    return '';
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
function register_user($username, $email, $password)
{
    global $db;
    $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?,?,?)";
    $statement = $db->query($sql, [$username, $email, $password]);

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
    // print_r2($url);
    $json = get_json_from_url($url);
    // print_r2($json);
    return ['lat' => $json[0]["lat"], 'lon' => $json[0]["lon"]];
}

function get_address_from_search($text_search) {
    global $config;
    $api_key = $config['google_api_key'];
    $query = urlencode($text_search);
    $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=$query&key=$api_key";

    return get_json_from_url($url);
}


function get_gyms_from_google($address) {
    global $config;
    $api_key = $config['google_api_key'];
    $query = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=$query&key=$api_key";
    return get_json_from_url($url);
}

function add_gym($name, $address, $description, $user_id) {
    global $db;
    // use curl to get lat and lon
    $coordinates = get_coordinates_from_address($address);
    $sql = "INSERT INTO gyms (name, address, lat, lon, description, user_id) VALUES (?, ?, ?, ?, ?, ?)"; 
    $db->query($sql, [$name, $address, $coordinates['lat'], $coordinates['lon'], $description, $user_id]);
}

function add_gym_with_coords($name, $address, $lat, $lon, $description, $user_id) {
    global $db;
    // insert into database if not exists
    $sql = "SELECT * FROM gyms WHERE name = ?";
    $statment = $db->query($sql, [$name]);
    $gym = $db->fetchOne($statment);
    if ($gym == null) {
        $sql = "INSERT INTO gyms (name, address, lat, lon, description, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        $db->query($sql, [$name, $address, $lat, $lon, $description, $user_id]);
    }
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

    $result = $db->fetchAll($statment);

    // if result is empty ask google for gyms
    if (count($result) > 0) {
        return $result;
    }

    $google_result = get_gyms_from_google($search_term);

    // format result from google to match database
    foreach ($google_result['results'] as $gym) {
        $result[] = [
            'id' => $gym['place_id'],
            'name' => $gym['name'],
            'address' => $gym['formatted_address'],
            'lat' => $gym['geometry']['location']['lat'],
            'lon' => $gym['geometry']['location']['lng'],
            'description' => $gym['name'],
            'user_id' => 1,
        ];

        // add to database
        add_gym_with_coords($gym['name'], $gym['formatted_address'], $gym['geometry']['location']['lat'], $gym['geometry']['location']['lng'], $gym['name'], 1);
    }

    print_r2("Google");
    print_r2($result);
    print_r2("---");
    return $result;
}

function get_styles() {
    global $db;
    $sql = "SELECT * FROM styles";
    $statment = $db->query($sql);
    return $db->fetchAll($statment);
}

function get_gyms_with_users($search_term = "")
{
    global $db;
    // Join tabeller gyms och users med inner join
    $sql = "SELECT * FROM gyms WHERE name LIKE ? INNER JOIN users ON gyms.user_id = users.id";
    $statment = $db->query($sql, ["%$search_term%"]);

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
        set_flash_message_and_redirect_to("You need to be signed in to access this page", "/login");
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
        set_flash_message_and_redirect_to("You are already signed in", "/home");
    }
}

function render_logged_in_navbar()
{
    if (isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        return <<<EOD
    <li">
        <a href="/logout">Logout</a>
            </li>
            <li>
            <a href="/gyms/add">Add gym</a>
            </li>
    <li">
        <a href="/users/{$user['id']}">{$user['username']}</a>
    </li>
EOD;
    }
}

