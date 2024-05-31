
<?php include "partials/head.php"; ?>
<?php include "partials/header.php"; ?>
<main>
    <?php include "partials/nav.php"; ?>
    <?php include "partials/flash_message.php"; ?>
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


