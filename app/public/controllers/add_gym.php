<?php
include "_includes/functions.php";
try_session_start();

// Check if method is post
// Handle storing new gym
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if user is authenticated
    if (is_authenticated()) {
        // Get data from form
        $name = $_POST['name'];
        $address = $_POST['address'];
        $description = $_POST['description'];
        $session_names = $_POST['session_names'];
        $session_styles = $_POST['session_styles'];
        $start_times = $_POST['start_times'];
        $end_times = $_POST['end_times'];


        // Check if all fields are filled for gym
        if (empty($name) || empty($address) || empty($description)) {
            set_flash_message_and_redirect_to("All fields for the gym must be filled", "add_gym");
        }

        // Check if all fields are filled for sessions
        if (empty($session_names) || empty($session_styles) || empty($start_times) || empty($end_times)) {
            set_flash_message_and_redirect_to("a gym needs at least one session", "add_gym");
        }

        // Create gym in db
        add_gym($name, $address, $description, $_SESSION['user_id']);

        // Create sessions in db
        foreach ($session_names as $i => $session_name) {
            add_session($session_name, $session_styles[$i], $start_times[$i], $end_times[$i], $db->lastInsertId());
        }
    }
}

// Check if method is get
// Handle showing new gym form
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // Check if user is authenticated
    if (is_authenticated()) {
        // Show new gym form
        // get styles from db
        $styles = get_styles();
        include "views/add_gym.php";
    } else {
        // Redirect to login page
        set_flash_message_and_redirect_to("You need to be logged in to add a gym", "/login");
    }
}
