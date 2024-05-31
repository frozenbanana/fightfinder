<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    guard_user_not_logged_in();
        // Hämta data från formuläret
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);

        // steg: kontrollera att fälten inte är tomma
        if (empty($email) || empty($username) || empty($password) || empty($password2)) {
            set_flash_message_and_redirect_to("Alla fält måste vara ifyllda", "/register");
        }

        // TODO: kontrollera att användarnamnet är mellan 3 och 20 tecken långt
        // och inte har några specialtecken eller whitespace med hjälp av Regex

        // steg: kontrollera att lösenorden matchar varandra
        if ($password !== $password2) {
            set_flash_message_and_redirect_to("Lösenorden matchar inte", "/register");
        }
        
        try {
            // Hämta användaren från databasen
            $user = get_user_by_username($username);

            if ($user) {
                set_flash_message_and_redirect_to("Användarnamnet är upptaget", "/register");
            }

            // steg: kryptera lösenord
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // steg: registera ny användare i databasen
            // DONE: skapa en funktion för detta i functions.php
            $isSuccessful = register_user($username, $email, $password_hashed);

            if (!$isSuccessful) {
                set_flash_message_and_redirect_to("Något gick fel, användaren kunde inte skapas", "/register");
            }

            // skicka användaren till login.php
            set_flash_message_and_redirect_to("Lyckad skapelse av användare. Var god att logga in", "/login");
        } catch(PDOException $e) {
            echo "Database connection exception $e";
        }

    }

// Handle showing login
if ($_SERVER['REQUEST_METHOD'] == "GET") {
        // Check if user is authenticated
        if (!is_authenticated()) {
            $title = "Register";
            include "views/register.php";
        } else {
            // Redirect to Home
            set_flash_message_and_redirect_to("You are already registered", "home");
        }
}
