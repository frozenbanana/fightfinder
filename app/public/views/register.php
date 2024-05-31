<?php include "partials/head.php"; ?>
<?php include "partials/header.php"; ?>

<main>
<?php include "partials/nav.php"; ?>
<?php include "partials/flash_message.php"; ?>

    <!-- Ett Formulär för att registera sig -->
    <h1>Register new user</h1>
    <form action="/register" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <label for="password2">Password Again</label>
        <input type="password" name="password2" id="password2">

        <button type="submit">Register</button>
    </form>
</main>

<?php include "partials/footer.php"; ?>
