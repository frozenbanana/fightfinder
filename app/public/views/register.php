<?php
    session_start();
    guard_user_not_logged_in();
    $title = "Register";

    // Kontrollera om det finns flash meddelande
    // Om det finns, skriv det till sidan
    display_flash_message();

    // Hantera formulär request för att registera ny användare
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Hämta data från formuläret
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);

        // steg: kontrollera att fälten inte är tomma
        if (empty($username) || empty($password) || empty($password2)) {
            set_flash_message_and_redirect_to("Alla fält måste vara ifyllda", "register.php");
        }

        // TODO: kontrollera att användarnamnet är mellan 3 och 20 tecken långt
        // och inte har några specialtecken eller whitespace med hjälp av Regex

        // steg: kontrollera att lösenorden matchar varandra
        if ($password !== $password2) {
            set_flash_message_and_redirect_to("Lösenorden matchar inte", "register.php");
        }
        
        try {
            // Hämta användaren från databasen
            $user = get_user_by_username($username);

            if ($user) {
                set_flash_message_and_redirect_to("Användarnamnet är upptaget", "register.php");
            }

            // steg: kryptera lösenord
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // steg: registera ny användare i databasen
            // DONE: skapa en funktion för detta i functions.php
            $isSuccessful = register_user($username, $password_hashed);

            if (!$isSuccessful) {
                set_flash_message_and_redirect_to("Något gick fel, användaren kunde inte skapas", "register.php");
            }

            // skicka användaren till login.php
            set_flash_message_and_redirect_to("Lyckad skapelse av användare. Var god att logga in", "login.php");
        } catch(PDOException $e) {
            echo "Database connection exception $e";
        }

        

    }
?>

<?php include "partials/head.php"; ?>
<?php include "partials/header.php"; ?>
<?php include "partials/nav.php"; ?>

<main>
    <!-- Ett Formulär för att registera sig -->
    <h1>Registera ny användare</h1>
    <form action="/register" method="post">
        <label for="username">Användarnamn</label>
        <input type="text" name="username" id="username">

        <label for="password">Lösenord</label>
        <input type="password" name="password" id="password">

        <label for="password2">Bekräfta Lösenord</label>
        <input type="password" name="password2" id="password2">

        <button type="submit">Registrera</button>
    </form>
</main>

<?php include "partials/footer.php"; ?>