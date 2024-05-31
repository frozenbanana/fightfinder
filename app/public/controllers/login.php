<?php
include_once "_includes/functions.php";
session_start();

// Hantera formulär request för att registera ny användare
if ($_SERVER['REQUEST_METHOD'] == "POST") {
        guard_user_not_logged_in();
        // Hämta data från formuläret
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // steg: kontrollera att fälten inte är tomma
        if (empty($username) || empty($password)) {
            set_flash_message_and_redirect_to("Alla fält måste vara ifyllda", "login");
        }

        try {
            // Hämta användaren från databasen
            $user = get_user_by_username($username);

            // Kontrollera att användaren finns i databasen 
            // (OM inte finns skicka användaren till register.php)
            if (!$user) {
                set_flash_message_and_redirect_to("Användarnamnet finns inte, registrera dig", "register");
            }

            // steg: kontrollera att lösenorden matchar varandra
            $is_matching_password = password_verify($password, $user['password']);
            if (!$is_matching_password) {
                set_flash_message_and_redirect_to("Fel lösenord", "login");
            }

            // steg: skapa en session för inloggad användare
            unset($user['password']);
            $_SESSION['user'] = $user;

            // skicka användaren till home
            set_flash_message_and_redirect_to("Lyckad inloggning", "home");

        } catch(PDOException $e) {
            echo "Database connection exception $e";
        }
}

// Handle showing login
if ($_SERVER['REQUEST_METHOD'] == "GET") {
        // Check if user is authenticated
        if (!is_authenticated()) {
        $title = "Login";
            include "views/login.php";
        } else {
            // Redirect to home page
            set_flash_message_and_redirect_to("You are already logged in", "home");
        }
}
