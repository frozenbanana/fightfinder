
<?php
    include_once "_includes/functions.php";

    // Starta session för att skicka/ta emot flash meddelande
    session_start();

    guard_user_not_logged_in();

    $title = "Login";

    // Kontrollera om det finns flash meddelande
    // Om det finns, skriv det till sidan
    display_flash_message();

    // Hantera formulär request för att registera ny användare
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

?>
<?php include "partials/head.php"; ?>
<?php include "partials/header.php"; ?>
<?php include "partials/nav.php"; ?>

<main>
    <!-- Ett Formulär för att logga in -->
    <h1>Login</h1>
    <form action="/login" method="post">
        <label for="username">Användarnamn</label>
        <input type="text" name="username" id="username">

        <label for="password">Lösenord</label>
        <input type="password" name="password" id="password">

        <button type="submit">Login</button>
    </form>
</main>

<?php include "partials/footer.php"; ?>


