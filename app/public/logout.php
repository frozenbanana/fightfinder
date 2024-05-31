<?php
include_once "_includes/functions.php";
// Starta upp sessionen igen
try_session_start();

// Logga ut genom att förstöra sessionen
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// skicka användaren till home
set_flash_message_and_redirect_to("You are now logged out", "/home");

